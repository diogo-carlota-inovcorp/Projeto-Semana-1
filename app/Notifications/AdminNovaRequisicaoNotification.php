<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class AdminNovaRequisicaoNotification extends Notification
{
    use Queueable;

    public function __construct(public $requisicao)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nova requisição de livro')
            ->greeting('Nova requisição registada')
            ->line('Foi criada uma nova requisição no sistema.')
            ->line('Utilizador: ' . $this->requisicao->user->name)
            ->line('Email: ' . $this->requisicao->user->email)
            ->line('Livro: ' . $this->requisicao->livro->nome)
            ->line('ISBN: ' . ($this->requisicao->livro->isbn ?? 'Sem ISBN'))
            ->line('Data da requisição: ' . $this->requisicao->created_at->format('d/m/Y H:i'))
            ->line('Entrega prevista: ' . Carbon::parse($this->requisicao->fim_previsto)->format('d/m/Y'))
            ->action('Ver utilizadores', route('admin.users.index'))
            ->line('Obrigado!');
    }
}
