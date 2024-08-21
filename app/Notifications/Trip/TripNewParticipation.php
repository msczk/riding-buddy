<?php

namespace App\Notifications\Trip;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TripNewParticipation extends Notification
{
    use Queueable;

    private Trip $trip;
    private User $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Trip $trip, User $user)
    {
        $this->trip = $trip;
        $this->user = $user;
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
            ->subject(__('You have received a new participation demand'))
            ->line(__('The user :username would like to participate to your trip : ":tripname"', ['username' => $this->user->username, 'tripname' => $this->trip->name]))
            ->action(__('Approve'), route('trip.approve', [$this->trip, $this->user]))
            ->line(__('If you don\'t want this user participate to your trip, just ignore this email'))
            ->line(__('Thank you for using our application!'));
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
