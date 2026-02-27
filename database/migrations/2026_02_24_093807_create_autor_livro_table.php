<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('livro_autor', function (Blueprint $table) {
            $table->id();

            $table->foreignId('autor_id')->constrained('autores')->cascadeOnDelete();
            $table->foreignId('livro_id')->constrained('livros')->cascadeOnDelete();

            $table->unique(['autor_id', 'livro_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livro_autor');
    }

};
