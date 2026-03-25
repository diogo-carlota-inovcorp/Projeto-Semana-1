<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Buscar as encomendas com os items e os livros
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.livro']) // <-- Isto é ESSENCIAL!
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.livro']) // <-- Isto é ESSENCIAL!
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }
}
