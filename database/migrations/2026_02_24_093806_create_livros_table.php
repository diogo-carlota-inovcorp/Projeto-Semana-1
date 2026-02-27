<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->unique();
            $table->string('nome');
            $table->foreignId('editoras_id')->constrained('editoras');
            $table->text('bibliografia')->nullable();
            $table->string('imagem-capa')->nullable();
            $table->decimal('preco', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
