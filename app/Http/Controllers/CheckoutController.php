<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $cartItems = collect($cart)->map(function ($item) {
            $item['subtotal'] = $item['preco'] * $item['quantidade'];
            return $item;
        })->values();

        $total = $cartItems->sum('subtotal');

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:50',
            'morada' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
            'cidade' => 'required|string|max:100',
            'pais' => 'required|string|max:100',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'O carrinho está vazio.');
        }

        $moradaCompleta = $request->nome . ', ' .
            $request->telefone . ', ' .
            $request->morada . ', ' .
            $request->codigo_postal . ', ' .
            $request->cidade . ', ' .
            $request->pais;

        session()->put('checkout_address', $moradaCompleta);

        return back()->with('success', 'Morada guardada.');
    }

    public function createStripeSession()
    {
        $cart = session()->get('cart', []);
        $morada = session()->get('checkout_address');

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'O carrinho está vazio.');
        }

        if (!$morada) {
            return redirect()->route('checkout.index')->with('error', 'Guarde primeiro a morada de entrega.');
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['preco'] * $item['quantidade'];
        });

        $order = Order::create([
            'user_id' => auth()->id(),
            'morada' => $morada,
            'estado' => 'pendente_pagamento',
            'total' => $total,
        ]);

        foreach ($cart as $item) {
            $order->items()->create([
                'livro_id' => $item['livro_id'],
                'quantity' => $item['quantidade'],
                'preco_unitario' => $item['preco'],
            ]);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = collect($cart)->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['nome'],
                    ],
                    'unit_amount' => (int) round($item['preco'] * 100),
                ],
                'quantity' => $item['quantidade'],
            ];
        })->values()->toArray();

        $session = StripeSession::create([
            'mode' => 'payment',
            'line_items' => $lineItems,
            'client_reference_id' => (string) $order->id,
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'metadata' => [
                'order_id' => $order->id,
                'user_id' => auth()->id(),
            ],
        ]);

        $order->update([
            'stripe_checkout_session_id' => $session->id,
        ]);

        return redirect($session->url);
    }


public function success(Request $request)
{
    $sessionId = $request->query('session_id');

    if ($sessionId) {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripeSession = \Stripe\Checkout\Session::retrieve($sessionId);

        $order = Order::where('stripe_checkout_session_id', $stripeSession->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($order) {



            if ($order->estado !== 'paga') {
                $order->estado = 'paga';
                $order->save();
            }


            session()->forget('cart');
            session()->forget('checkout_address');
        }
    }

    return view('checkout.success');
}

    public function cancel()
    {
        return view('checkout.cancel');
    }
}
