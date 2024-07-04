<?php

namespace App\Notifications;

use App\Models\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AskForRating extends Notification
{
    use Queueable;

    private Trip $trip;

    /**
     * Create a new notification instance.
     */
    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject(__('Qu\'avez-vous pensé de la balade : '.$this->trip->name))
                    ->line(_('Merci d\'avoir participé à la balade.'))
                    ->line(_('Afin d\'améliorer l\'expérience de chacun, vous pouvez noter ce trajet. Cela ne prendra pas plus d\'une minute (vraiment).'))
                    ->action('Je laisse une note', route('trip.rate', $this->trip))
                    ->line('On remet ça quand ?');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
