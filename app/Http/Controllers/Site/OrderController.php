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
        if($order->type === 'course') {
            $course = Course::findOrFail($order->buying_id);
            $price = $course->price;
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
            $price = $lesson->price? $lesson->price : $lesson->price_user;
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
        $teacher->balance = $teacher->balance + $price;
        $teacher->save();
        $teacher_id = $teacher -> id;
        $student = StudentAccount::findOrFail($order->student_id);
        if($price > $request->get('OutSum')) {
            $student->promo_balance = $student -> promo_balance - ($price - $request->get('OutSum'));
            $student -> save();
        }
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
