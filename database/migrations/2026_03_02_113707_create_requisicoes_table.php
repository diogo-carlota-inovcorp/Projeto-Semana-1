<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requisicoes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('livro_id')->constrained('livros')->cascadeOnDelete();

            $table->timestamp('requisitado_em')->useCurrent();
            $table->date('fim_previsto'); // +5 dias

            $table->string('status')->default('pendente');
            // pendente | ativa | rejeitada | entregue

            $table->timestamps();

            $table->index(['livro_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisicoes');
    }
};
