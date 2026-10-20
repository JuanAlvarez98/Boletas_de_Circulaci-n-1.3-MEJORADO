<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('two_factor_sent_at')->nullable()->after('two_factor_expires_at');
            $table->unsignedTinyInteger('two_factor_attempts')->default(0)->after('two_factor_sent_at');
            $table->timestamp('disabled_at')->nullable()->after('two_factor_attempts');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('boletas_circulacion', function (Blueprint $table) {
            $table->text('motivo_anulacion')->nullable();
            $table->foreignId('anulada_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('anulada_at')->nullable();
        });

        Schema::table('stickers', function (Blueprint $table) {
            $table->uuid('verification_token')->nullable()->unique();
            $table->string('estado', 20)->default('activo')->index();
            $table->text('motivo_anulacion')->nullable();
            $table->foreignId('anulado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('anulado_at')->nullable();
        });

        DB::table('stickers')->whereNull('verification_token')->orderBy('id')->eachById(function ($sticker) {
            DB::table('stickers')->where('id', $sticker->id)->update(['verification_token' => (string) Str::uuid()]);
        });

        Schema::table('actas_entrega', function (Blueprint $table) {
            $table->string('estado', 20)->default('registrada')->index();
            $table->text('motivo_anulacion')->nullable();
            $table->foreignId('anulada_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('anulada_at')->nullable();
        });

        Schema::create('document_sequences', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->unsignedBigInteger('value')->default(0);
            $table->timestamps();
        });

        $sequences = [
            'boleta' => ['table' => 'boletas_circulacion', 'column' => 'folio'],
            'sticker' => ['table' => 'stickers', 'column' => 'codigo'],
            'acta' => ['table' => 'actas_entrega', 'column' => 'folio'],
        ];
        foreach ($sequences as $type => $source) {
            $last = DB::table($source['table'])->where($source['column'], 'like', '%-'.now()->year.'-%')
                ->orderByDesc('id')->value($source['column']);
            DB::table('document_sequences')->insert([
                'key' => $type.'-'.now()->year,
                'value' => $last ? (int) substr($last, strrpos($last, '-') + 1) : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 80)->index();
            $table->nullableMorphs('auditable');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('document_sequences');

        Schema::table('actas_entrega', function (Blueprint $table) {
            $table->dropConstrainedForeignId('anulada_por');
            $table->dropColumn(['estado', 'motivo_anulacion', 'anulada_at']);
        });
        Schema::table('stickers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('anulado_por');
            $table->dropColumn(['verification_token', 'estado', 'motivo_anulacion', 'anulado_at']);
        });
        Schema::table('boletas_circulacion', function (Blueprint $table) {
            $table->dropConstrainedForeignId('anulada_por');
            $table->dropColumn(['motivo_anulacion', 'anulada_at']);
        });
        Schema::table('vehicles', fn (Blueprint $table) => $table->dropSoftDeletes());
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn([
            'two_factor_sent_at', 'two_factor_attempts', 'disabled_at',
        ]));
    }
};
