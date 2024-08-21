<?php

namespace App\Notifications\Trip;

use App\Models\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TripApproved extends Notification
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
            ->subject(__('Congratulation ! You have been accepted for the trip : :name', ['name' => $this->trip->name]))
            ->line(__('Your participation has been accepted for the trip : :name', ['name' => $this->trip->name]))
            ->line(__('The trip starting location is now available'))
            ->action(__('Discover'), route('trip.show', $this->trip))
            ->line(__('Enjoy your trip and be safe ❤️'));
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
