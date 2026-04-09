<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mensagens_nao_lidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('conversavel');
            $table->integer('quantidade')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'conversavel_id', 'conversavel_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('mensagens_nao_lidas');
    }
};
