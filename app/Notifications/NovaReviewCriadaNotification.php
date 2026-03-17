<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NovaReviewCriadaNotification extends Notification
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
        return (new MailMessage)
            ->subject('Nova review submetida')
            ->greeting('Olá!')
            ->line('Foi submetida uma nova review.')
            ->line('Cidadão: ' . $this->review->user->name)
            ->line('Email: ' . $this->review->user->email)
            ->line('Livro: ' . $this->review->livro->titulo)
            ->line('Comentário: ' . $this->review->comentario)
            ->action('Ver detalhe da review', route('admin.reviews.show', $this->review->id));
    }
}
