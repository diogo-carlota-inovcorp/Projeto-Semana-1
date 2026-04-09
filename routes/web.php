<?php

use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\BookRequestController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Google_LivrosController;
use App\Http\Controllers\LivroExportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RequisicaoController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditoraController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\auth\SessionsController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminReviewController;
use App\Http\Controllers\AdminLogController;
use App\Exports\LogsExport;
use Maatwebsite\Excel\Facades\Excel;



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
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');



/*
|--------------------------------------------------------------------------
| Auth + verified
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware('admin')->group(function () {

        // Dashboard admin
        Route::get('/admin/admin', [AdminController::class, 'index'])->name('admin.index');

        // Gestão de Livros
        Route::get('/admin/admin_adicionar', [AdminController::class, 'admin_adicionar'])->name('admin.admin_adicionar');
        Route::get('/admin/adicionar_livro', [AdminController::class, 'adicionar_livro'])->name('admin.adicionar_livro');
        Route::get('/admin/adicionar_autor', [AdminController::class, 'adicionar_autor'])->name('admin.adicionar_autor');
        Route::get('/admin/adicionar_editora', [AdminController::class, 'adicionar_editora'])->name('admin.adicionar_editora');

        Route::post('/admin/livros', [LivroController::class, 'store'])->name('admin.livros.store');
        Route::post('/admin/adicionar_autor', [AdminController::class, 'store_autor'])->name('admin.adicionar_autor.store');
        Route::post('/admin/adicionar_editora', [AdminController::class, 'store_editora'])->name('admin.adicionar_editora.store');

        Route::get('/livros/{livro}/editar', [LivroController::class, 'editar'])->whereNumber('livro')->name('livros.edit');
        Route::patch('/livros/{livro}', [LivroController::class, 'update'])->whereNumber('livro')->name('livros.update');
        Route::delete('/livros/{livro}', [LivroController::class, 'destroy'])->whereNumber('livro')->name('livros.destroy');

        // Gestão de Utilizadores
        Route::prefix('admin/utilizadores')->name('admin.users.')->group(function () {
            Route::get('/', [AdminUsersController::class, 'index'])->name('index');
            Route::get('/gestao', [AdminUsersController::class, 'gestao'])->name('gestao');
            Route::patch('/{user}/promover', [AdminUsersController::class, 'promote'])->name('promote');
            Route::patch('/{user}/rebaixar', [AdminUsersController::class, 'demote'])->name('demote');
            Route::get('/{user}/requisicoes', [RequisicaoController::class, 'userRequisicoes'])->name('requisicoes');
            Route::get('/{user}/historico', [AdminUsersController::class, 'historico'])->name('historico');
            Route::get('/{user}/encomendas', [AdminUsersController::class, 'encomendas'])->name('encomendas');
        });

        // Gestão de Encomendas (ADICIONA ESTE GRUPO)
        Route::prefix('admin/encomendas')->name('admin.orders.')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
            Route::patch('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('update-status');
        });

        // Encomendas por utilizador
        Route::get('/admin/users/{user}/orders', [AdminOrderController::class, 'userOrders'])->name('admin.users.orders');

        // Gestão de Reviews
        Route::prefix('admin/reviews')->name('admin.reviews.')->group(function () {
            Route::get('/', [AdminReviewController::class, 'index'])->name('index');
            Route::get('/{review}', [AdminReviewController::class, 'show'])->name('show');
            Route::put('/{review}', [AdminReviewController::class, 'update'])->name('update');
        });

        // Google Books
        Route::get('/google-books', [Google_LivrosController::class, 'index'])->name('google-books.index');
        Route::get('/google-books/search', [Google_LivrosController::class, 'search'])->name('google-books.search');
        Route::post('/google-books/import', [Google_LivrosController::class, 'import'])->name('google-books.import');

        // Outras rotas admin
        Route::get('/editora/{id}/editar', [LivroController::class, 'editarEditora'])->name('livros.editar_editora');
        Route::put('/editora/{id}', [LivroController::class, 'updateEditora'])->name('livros.update_editora');
        Route::get('/autor/{id}/editar', [LivroController::class, 'editarAutor'])->name('livros.editar_autor');
        Route::put('/autor/{id}', [LivroController::class, 'updateAutor'])->name('livros.update_autor');

        // Rotas de requisições admin
        Route::patch('/admin/requisicoes/{requisicao}/confirmar-devolucao', [RequisicaoController::class, 'confirmarDevolucao'])->name('admin.requisicoes.confirmarDevolucao');
        Route::get('/admin/users/{user}/orders', [AdminOrderController::class, 'userOrders'])->name('admin.users.orders');
        Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');});

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/users/{user}/orders', [AdminOrderController::class, 'userOrders'])->name('users.orders');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');


        //ROUTE PARA LOGS
            Route::get('/admin/logs', [AdminLogController::class, 'index'])->name('admin.logs.index');
            Route::get('/admin/logs/{log}', [AdminLogController::class, 'show'])->name('admin.logs.show');
            Route::delete('/admin/logs/{log}', [AdminLogController::class, 'destroy'])->name('admin.logs.destroy');

       

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
    Route::post('/requisicoes/{requisicao}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::patch('/requisicoes/{requisicao}/pedir-devolucao', [RequisicaoController::class, 'pedirDevolucao'])->name('requisicoes.pedirDevolucao');
    Route::post('/livros/{livro}/alerta', [LivroController::class, 'alerta'])->name('livros.alerta')->middleware('auth');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::post('/checkout/stripe', [CheckoutController::class, 'createStripeSession'])->name('checkout.stripe');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{livro}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/item/{livro}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])->name('checkout.address');
    Route::get('/minhas-encomendas', [OrderController::class, 'myOrders'])->name('minhas.encomendas');
});
