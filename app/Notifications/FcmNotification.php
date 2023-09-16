<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class FcmNotification extends Notification
{
    use Queueable;

    public function __construct(public string $title, public string $body, public array $data, public ?string $image = null)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['firebase'];
    }

    /**
     * Get the firebase representation of the notification.
     */
    public function toFirebase($notifiable)
    {
        Log::debug($notifiable);
        $notification = (new FirebaseMessage)
            ->withTitle($this->title)
            ->withBody($this->body);
        if (count($this->data) > 0)
            $notification = $notification->withAdditionalData($this->data);
        if ($this->image)
            $notification = $notification->withImage($this->image);
        return $notification
            ->asNotification($notifiable->firebaseTokens()->pluck('token')->toArray()); // OR ->asMessage($deviceTokens);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
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
