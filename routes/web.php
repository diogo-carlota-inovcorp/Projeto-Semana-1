<?php

use App\Http\Controllers\BookRequestController;
use App\Http\Controllers\Google_LivrosController;
use App\Http\Controllers\LivroExportController;
use App\Http\Controllers\RequisicaoController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditoraController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\auth\SessionsController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\PerfilController;


/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::get('/livros/index', [HomeController::class, 'index'])->name('home');
Route::get('/livros/livro', [LivroController::class, 'livro'])->name('livros.livro');
Route::get('/livros/autor', [AutorController::class, 'index'])->name('livros.autor');
Route::get('/livros/editora', [EditoraController::class, 'index'])->name('livros.editora');
Route::get('/livros/{livro}', [LivroController::class, 'show'])->name('livros.show');

/*
|--------------------------------------------------------------------------
| Auth + verified
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // ✅ Admin-only routes (role-based)
    Route::middleware('admin')->group(function () {

        Route::get('/admin/admin', [AdminController::class, 'index'])->name('admin.index');

        Route::get('/admin/adicionar_livro', [AdminController::class, 'adicionar_livro'])->name('admin.adicionar_livro');
        Route::get('/admin/adicionar_autor', [AdminController::class, 'adicionar_autor'])->name('admin.adicionar_autor');
        Route::get('/admin/adicionar_editora', [AdminController::class, 'adicionar_editora'])->name('admin.adicionar_editora');

        Route::post('/admin/livros', [LivroController::class, 'store'])->name('admin.livros.store');
        Route::post('/admin/adicionar_autor', [AdminController::class, 'store_autor'])->name('admin.adicionar_autor.store');
        Route::post('/admin/adicionar_editora', [AdminController::class, 'store_editora'])->name('admin.adicionar_editora.store');

        Route::get('/livros/{livro}/editar', [LivroController::class, 'editar'])
            ->whereNumber('livro')
            ->name('livros.edit');

        Route::patch('/livros/{livro}', [LivroController::class, 'update'])
            ->whereNumber('livro')
            ->name('livros.update');

        Route::delete('/livros/{livro}', [LivroController::class, 'destroy'])
            ->whereNumber('livro')
            ->name('livros.destroy');

        // Admin users management
        Route::get('/admin/utilizadores', [AdminUsersController::class, 'index'])->name('admin.users.index');
        Route::patch('/admin/utilizadores/{user}/promover', [AdminUsersController::class, 'promote'])->name('admin.users.promote');
        Route::patch('/admin/utilizadores/{user}/rebaixar', [AdminUsersController::class, 'demote'])->name('admin.users.demote');

        Route::get('/admin/utilizadores/{user}/requisicoes', [RequisicaoController::class, 'userRequisicoes'])->name('admin.users.requisicoes');

        Route::get('/admin/utilizadores/{user}/historico', [AdminUsersController::class, 'historico'])->name('admin.users.historico');

        Route::patch('/admin/requisicoes/{requisicao}/confirmar-devolucao', [RequisicaoController::class, 'confirmarDevolucao'])->name('admin.requisicoes.confirmarDevolucao');

        Route::get('/google-books', [Google_LivrosController::class, 'index'])->name('google-books.index');
        Route::get('/google-books/search', [Google_LivrosController::class, 'search'])->name('google-books.search');
        Route::post('/google-books/import', [Google_LivrosController::class, 'import'])->name('google-books.import');


        Route::get('/editora/{id}/editar', [LivroController::class, 'editarEditora'])->name('livros.editar_editora');
        Route::put('/editora/{id}', [LivroController::class, 'updateEditora'])->name('livros.update_editora');

        Route::get('/autor/{id}/editar', [LivroController::class, 'editarAutor'])->name('livros.editar_autor');
        Route::put('/autor/{id}', [LivroController::class, 'updateAutor'])->name('livros.update_autor');


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


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/requisicoes', [RequisicaoController::class, 'index'])->name('requisicoes.index');
    Route::post('/requisicoes', [RequisicaoController::class, 'store'])->name('requisicoes.store');
    Route::get('/minhas-requisicoes', [RequisicaoController::class, 'minhas'])->middleware('auth')->name('requisicoes.minhas');
    Route::patch('/requisicoes/{requisicao}/entregar', [RequisicaoController::class, 'entregar'])->middleware('auth')->name('requisicoes.entregar');
    Route::patch('/requisicoes/{requisicao}/pedir-devolucao', [RequisicaoController::class, 'pedirDevolucao'])->name('requisicoes.pedirDevolucao');
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil.show');
    Route::post('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
    Route::get('/requisicoes/{requisicao}', [RequisicaoController::class, 'show'])->name('requisicoes.show');

    Route::get('/book-request', [BookRequestController::class, 'create'])->name('google-books.create');
    Route::post('/book-request', [BookRequestController::class, 'store'])->name('google-books.store');

});
