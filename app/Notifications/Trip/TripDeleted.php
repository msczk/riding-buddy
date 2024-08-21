<?php

namespace App\Notifications\Trip;

use App\Models\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TripDeleted extends Notification
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
                    ->subject(__('A trip you participate has been canceled'))
                    ->line(__('The trip ":name" has been canceled', ['name' => $this->trip->name]))
                    ->line(__('Sadly you will not be able to participate to this trip'))
                    ->line(__('But, don\'t worry ! There are plenty of other trips waiting for you'))
                    ->line(__('See you next trip'));
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
