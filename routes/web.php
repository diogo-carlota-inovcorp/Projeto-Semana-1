<?php

use App\Http\Controllers\LivroExportController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditoraController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\auth\SessionsController;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::get('/livros/index', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Auth + Email Verified routes (main app)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Livros (lista)
    Route::get('/livros/livro', [LivroController::class, 'livro'])->name('livros.livro');

    // Autores / Editoras (rotas específicas PRIMEIRO)
    Route::get('/livros/autor', [AutorController::class, 'index'])->name('livros.autor');
    Route::get('/livros/editora', [EditoraController::class, 'index'])->name('livros.editora');

    // Livros (detalhe/apagar) - genérica DEPOIS e só números
    Route::get('/livros/{livro}', [LivroController::class, 'show'])
        ->whereNumber('livro')
        ->name('livros.show');

    Route::delete('/livros/{livro}', [LivroController::class, 'destroy'])
        ->whereNumber('livro')
        ->name('livros.destroy');

    // Admin
    Route::middleware('can:ViewAdicionar')->group(function () {
        Route::get('/admin/admin', [AdminController::class, 'index'])->name('admin.index');

        Route::get('/admin/adicionar_livro', [AdminController::class, 'adicionar_livro'])->name('admin.adicionar_livro');
        Route::get('/admin/adicionar_autor', [AdminController::class, 'adicionar_autor'])->name('admin.adicionar_autor');
        Route::get('/admin/adicionar_editora', [AdminController::class, 'adicionar_editora'])->name('admin.adicionar_editora');

        Route::post('/admin/livros', [LivroController::class, 'store'])->name('admin.livros.store');
        Route::post('/admin/adicionar_autor', [AdminController::class, 'store_autor'])->name('admin.adicionar_autor.store');
        Route::post('/admin/adicionar_editora', [AdminController::class, 'store_editora'])->name('admin.adicionar_editora.store');



    });
});


Route::get('/livros/exportar-excel', [LivroExportController::class, 'export'])
    ->middleware('auth')
    ->name('livros.exportar.excel');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::delete('/logout', [SessionsController::class, 'destroy'])->name('logout');
