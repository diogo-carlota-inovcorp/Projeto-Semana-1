<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewModeradaNotification extends Notification
{
    use Queueable;

    public Review $review;

    public function __construct(Review $review)
    {
        $this->review = $review->load(['livro', 'user']);
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Estado da sua review')
            ->greeting('Olá ' . $this->review->user->name . '!')
            ->line('A sua review ao livro "' . $this->review->livro->nome . '" foi analisada.')
            ->line('Estado: ' . ucfirst($this->review->estado));

        if ($this->review->estado === 'recusado' && $this->review->justificacao) {
            $mail->line('Justificação: ' . $this->review->justificacao);
        }

        return $mail;
    }
}
