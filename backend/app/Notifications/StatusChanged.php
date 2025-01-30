<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use app\Models\Reservation;
use App\Models\User;

class StatusChanged extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Reservation $reservation, public User $user)
    {
        //
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
        // Map status to human readable text
        $status_names = [
            0 => 'Pending',
            1 => 'Approved',
            -1 => 'Rejected',
        ];
        return (new MailMessage)
                    ->subject('Reservation status changed')
                    ->greeting('Hello ' . $this->user->firstname . ' ' . $this->user->lastname . '!')
                    ->line('The status of your reservation for the book ' . $this->reservation->book->title . ' has been changed to ' . $status_names[$this->reservation->status] . '.')
                    ->action('Go to our website', url('/'))
                    ->line('Thank you for using our application!');
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
