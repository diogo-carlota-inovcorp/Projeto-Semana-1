<?php

namespace App\Notifications;

use App\Models\AbandonedCart;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbandonedCartNotification extends Notification
{


    public function __construct(public AbandonedCart $cart)
    {
        //
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $items = collect($this->cart->cart_data)->map(function($item) {
            return "{$item['quantidade']}x {$item['nome']} - €" . number_format($item['preco'] * $item['quantidade'], 2);
        })->implode("\n");

        return (new MailMessage)
            ->subject('Não perca os seus livros! Complete a sua compra')
            ->greeting('Olá ' . ($this->cart->nome ?? 'Cliente') . '!')
            ->line('Notamos que você deixou alguns livros no carrinho e não concluiu a compra.')
            ->line('**Os seus itens:**')
            ->line($items)
            ->line('**Total:** €' . number_format($this->cart->total, 2, ',', '.'))
            ->action('Completar Compra', route('checkout.retrieve', ['session_id' => $this->cart->session_id]))
            ->line('Os itens estão guardados e à sua espera!')
            ->line('Se já concluiu a compra, ignore este email.')
            ->salutation('Obrigado pela preferência!');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Carrinho abandonado!',
            'message' => 'Você deixou ' . count($this->cart->cart_data) . ' livro(s) no carrinho. Complete a sua compra!',
            'cart_id' => $this->cart->id,
            'total' => $this->cart->total,
            'items_count' => count($this->cart->cart_data),
            'action_url' => route('checkout.retrieve', ['session_id' => $this->cart->session_id]),
        ];
    }
}
