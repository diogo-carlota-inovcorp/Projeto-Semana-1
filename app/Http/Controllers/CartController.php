<?php

namespace App\Http\Controllers;


use App\Models\Livro;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $cartItems = collect($cart)->map(function ($item) {
            $item['subtotal'] = $item['preco'] * $item['quantidade'];
            return $item;
        })->values();

        $total = $cartItems->sum('subtotal');

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Livro $livro)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$livro->id])) {
            $cart[$livro->id]['quantidade']++;
        } else {
            $cart[$livro->id] = [
                'livro_id' => $livro->id,
                'nome' => $livro->nome,
                'preco' => (float) $livro->preco,
                'imagem_capa' => $livro->imagem_capa,
                'autor' => $livro->autores->pluck('nome')->join(', '),
                'quantidade' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Livro adicionado ao carrinho.');
    }


    public function remove(Livro $livro)
    {
        $cart = session()->get('cart', []);

        unset($cart[$livro->id]);

        session()->put('cart', $cart);

        return back()->with('success', 'Livro removido do carrinho.');
    }
}
