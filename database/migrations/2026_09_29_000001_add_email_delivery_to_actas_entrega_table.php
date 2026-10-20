<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('actas_entrega', function (Blueprint $table) {
            $table->string('recibe_email')->nullable()->after('recibe_identidad');
            $table->timestamp('enviado_email_at')->nullable()->after('observaciones');
        });
    }

    public function down(): void
    {
        Schema::table('actas_entrega', function (Blueprint $table) {
            $table->dropColumn(['recibe_email', 'enviado_email_at']);
        });
    }
};
