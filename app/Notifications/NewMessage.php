<?php

namespace App\Notifications;

use App\Models\Chat;
use App\Models\User;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessage extends Notification
{
    use Queueable;
    public $message;
    public $fromUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Message $message, User $user)
    {
        $this -> message = $message;
        $this -> fromUser = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $chat = Chat::findOrFail($this->message->chat_id);
        $lesson = $chat->chatable;
        $text = 'Получено личное сообщение в чате "' . $lesson->title . '"';
        return [
            'type' => 'Сообщение',
            'text' => $text,
            'link' => '/profile/messages/' . $this->message->chat_id
        ];
    }
}
