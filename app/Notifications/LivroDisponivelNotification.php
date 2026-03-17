<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LivroDisponivelNotification extends Notification
{
    use Queueable;

    protected $livro;

    public function __construct($livro)
    {
        $this->livro = $livro;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Livro disponível!')
            ->line('O livro "' . $this->livro->nome . '" já está disponível.')
            ->action('Requisitar Livro', route('livros.show', $this->livro->id))
            ->line('Podes agora fazer a requisição.');
    }
}
