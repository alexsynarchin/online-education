<?php

namespace App\Notifications;

use App\Models\Category\CategoryType;
use App\Models\Category\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewComment extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $fromUser;
    public $course;

    public function __construct(Course $course, User $fromUser)
    {
        $this -> fromUser = $fromUser;
        $this -> course = $course;
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
        $text = $this->fromUser->name . ' ' . $this->fromUser->surname . ' оставил отзыв к курсу "' . $this->course->title . '"';
        $edu_category = CategoryType::findOrFail($this -> course -> edu_type_id);
        $link = route('catalog.show',['edu_slug' => $edu_category->slug, 'slug' => $this->course->slug]);
        return [
            'type' => 'Отзыв',
            'text' => $text,
            'link' => $link
        ];
    }
}
