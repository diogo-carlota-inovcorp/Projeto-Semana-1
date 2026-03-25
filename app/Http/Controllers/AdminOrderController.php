<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Ver todas as encomendas de um utilizador específico
     */
    public function userOrders($user)
    {
        // Buscar o utilizador
        $user = User::findOrFail($user);

        // Buscar as encomendas do utilizador com os items e livros
        $orders = Order::where('user_id', $user->id)
            ->with(['items.livro']) // Carrega os items e os livros
            ->orderBy('created_at', 'desc')
            ->get();

        // Retornar a view com os dados
        return view('admin.orders.user-orders', compact('orders', 'user'));
    }

    /**
     * Ver todas as encomendas de todos os utilizadores (lista geral)
     */
    public function index()
    {
        $orders = Order::with(['user', 'items.livro'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

     public function show(Order $order)
    {
        // Carregar os itens, livros e utilizador
        $order->load(['items.livro', 'user']);

        return view('admin.orders.show', compact('order'));
    }   
}
