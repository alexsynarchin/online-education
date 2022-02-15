<?php

namespace App\Notifications;

use App\Models\Category\CategoryType;
use App\Models\Category\Course;
use App\Models\Lesson\Lesson;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPaidLesson extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $lesson;
    public $fromUser;
    public function __construct(Lesson $lesson, User $fromUser)
    {
        $this->fromUser = $fromUser;
        $this->lesson = $lesson;
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
      $text = $this->fromUser->name . ' ' . $this->fromUser->surname . ' купил урок "' . $this->lesson->title . '"';
        $course = Course::findOrFail($this->lesson->course_id);
        $edu_type = CategoryType::findOrFail($course->edu_type_id);
        $link = route('lesson.show', [
            'edu_slug' => $edu_type->slug,
            'course_slug' => $course->slug,
            'slug' => $this->lesson->slug]);
        return [
            'type' => 'Покупка',
            'text' => $text,
            'link' => $link
        ];
    }
}
