<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Account\StudentAccount;
use App\Models\Category\Course;
use App\Models\Lesson\Lesson;
use App\Models\Order;
use App\Models\User;
use App\Notifications\NewBuyLesson;
use App\Notifications\NewPaidLesson;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function success(Request $request)
    {
        $order = Order::findOrFail($request->get('InvId'));
        $order -> status = 'success';
        $order->save();
        if($order->type === 'course') {
            $course = Course::findOrFail($order->buying_id);
            $lessons = $course->lessons()->get();
            foreach ($lessons as $lesson) {
                $this->lessonToStudent($lesson, $order->student_id);
            }
            $url = route('catalog.show', [
                'edu_slug' => $course -> edu_type -> slug,
                'slug' => $course->slug
            ]);
            $teacher = User::findOrFail($course->author_id);
        } else {
            $lesson = Lesson::findOrFail($order->buying_id);
            $this->lessonToStudent($lesson, $order->student_id);
            $teacher = User::findOrFail($lesson->user_id);
            $course = Course::findOrFail($lesson->course_id);
            $url = route('lesson.show', [
                'edu_slug' => $course -> edu_type -> slug,
                'course_slug' => $course->slug,
                'slug' => $lesson->slug
            ]);
        }
        $teacher = $teacher -> teacherAccount;
        $teacher->balance = $teacher->balance + $order->money;
        $teacher->promo_balance = $teacher->promo_balance + $order->bonus;
        $teacher->save();
        $teacher_id = $teacher -> id;
        $student = StudentAccount::findOrFail($order->student_id);
            $student->promo_balance = $student -> promo_balance - $order->bonus;
            $student -> save();
        if(!$student->teachers()->where('student_id', $student->id)->exists()) {
            $student->teachers()->attach($teacher_id);
        }
        return redirect($url) ;
    }

    public function fail(Request $request)
    {
        dd($request->all());
    }
    private function lessonToStudent($lesson, $student_id)
    {
        if(!$lesson->students()->where('student_id', $student_id) -> exists()){
            $lesson->students()->attach($student_id);
            $student = StudentAccount::findOrFail($student_id);
            $student = $student->user;
            $teacher = User::findOrFail($lesson->user_id);
            if($teacher->notifications){
                $teacher->notify(new NewPaidLesson($lesson, $student));
            }
            if($student->notifications) {
                $student->notify(new NewBuyLesson($lesson));
            }

        }
    }
}
