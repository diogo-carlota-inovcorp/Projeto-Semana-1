<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookRequestNotification extends Notification
{
    use Queueable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Novo pedido de livro')
            ->greeting('Novo pedido recebido!')
            ->line('Livro solicitado: ' . $this->data['book_name'])
            ->line('Email do utilizador: ' . $this->data['email'])
            ->line('Motivo:')
            ->line($this->data['reason'])
            ->line('Adicione este livro à biblioteca se possível.');
    }
}
