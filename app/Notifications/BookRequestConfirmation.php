<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookRequestConfirmation extends Notification
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
            ->subject('Pedido recebido')
            ->greeting('Obrigado pela sugestão!')
            ->line('Recebemos o pedido para o livro:')
            ->line($this->data['book_name'])
            ->line('A nossa equipa irá analisar o pedido.');
    }
}
