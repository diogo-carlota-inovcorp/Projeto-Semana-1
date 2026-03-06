<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            $table->string('numero')->unique()->nullable()->after('id');
            $table->timestamp('reminder_enviado_em')->nullable()->after('fim_previsto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            //
        });
    }
};
