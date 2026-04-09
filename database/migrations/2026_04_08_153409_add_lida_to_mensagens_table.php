<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mensagens', function (Blueprint $table) {
            $table->boolean('lida')->default(false)->after('conteudo');
            $table->timestamp('lida_em')->nullable()->after('lida');
        });
    }

    public function down()
    {
        Schema::table('mensagens', function (Blueprint $table) {
            $table->dropColumn(['lida', 'lida_em']);
        });
    }
};
