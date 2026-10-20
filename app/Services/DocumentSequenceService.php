<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DocumentSequenceService
{
    public function next(string $type, string $prefix): string
    {
        $year = now()->year;
        $key = "{$type}-{$year}";

        return DB::transaction(function () use ($key, $prefix, $year) {
            DB::table('document_sequences')->insertOrIgnore([
                'key' => $key,
                'value' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $sequence = DB::table('document_sequences')->where('key', $key)->lockForUpdate()->first();
            $next = $sequence->value + 1;

            DB::table('document_sequences')->where('key', $key)->update([
                'value' => $next,
                'updated_at' => now(),
            ]);

            return sprintf('%s-%d-%06d', $prefix, $year, $next);
        }, 3);
    }
}
