<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RequisicaoConfirmadaNotification extends Notification
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
            ->subject('Requisição Confirmada')
            ->greeting('Requisição Confirmada')
            ->line('A sua requisição foi criada com sucesso.')
            ->line('Número: ' . $this->requisicao->id)
            ->line('Livro: ' . $this->requisicao->livro->nome)
            ->line('ISBN: ' . ($this->requisicao->livro->isbn ?? 'Sem ISBN'))
            ->line('Data da requisição: ' . $this->requisicao->created_at->format('d/m/Y H:i'))
            ->line('Entrega prevista: ' . \Carbon\Carbon::parse($this->requisicao->fim_previsto)->format('d/m/Y'))
            ->action('Ver as minhas requisições', route('requisicoes.minhas'))
            ->line('Obrigado!');
    }
}
