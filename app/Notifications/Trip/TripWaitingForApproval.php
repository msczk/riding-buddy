<?php

namespace App\Notifications\Trip;

use App\Models\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TripWaitingForApproval extends Notification
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
                    ->subject(__('Your participation is waiting for approval by the initiator of the trip'))
                    ->line(__('Your participation to the trip ":name" is almost complete', ['name' => $this->trip->name]))
                    ->line(__('You just need to be approved before you can participate it', ['name' => $this->trip->name]))
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
