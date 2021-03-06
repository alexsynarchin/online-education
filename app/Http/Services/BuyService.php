<?php

namespace App\Http\Services;
use App\Models\Account\StudentAccount;
use App\Models\Category\Course;
use App\Models\Lesson\Lesson;
use App\Models\User;
use App\Notifications\NewBuyLesson;
use App\Notifications\NewPaidLesson;
use Illuminate\Http\Request;

class BuyService
{
    public function finishBuy(Request $request)
    {
        $student = \Auth::user()->studentAccount;
        $student->promo_balance = $student->promo_balance-$request->get('price');
        $student->save();
        $url='/profile/education/';

        if($request->get('type') === 'course') {
            $course = Course::findOrFail($request->get('id'));
            $lessons = $course->lessons()->where('status', 2)->get();
            foreach ($lessons as $lesson) {
                $this->lessonToStudent($lesson, $student->id);
            }
            $url = route('catalog.show', [
                'edu_slug' => $course -> edu_type -> slug,
                'slug' => $course->slug
            ]);
            $teacher = User::findOrFail($course->author_id);
        } else {
            $lesson = Lesson::findOrFail($request->get('id'));
            $this->lessonToStudent($lesson, $student->id);
            $teacher = User::findOrFail($lesson->user_id);
            $course = Course::findOrFail($lesson->course_id);
            $url = route('lesson.show', [
                'edu_slug' => $course -> edu_type -> slug,
                'course_slug' => $course->slug,
                'slug' => $lesson->slug
            ]);
        }
        $teacher = $teacher -> teacherAccount;
        $teacher->promo_balance = $teacher->promo_balance + $request->get('price');
        $teacher->save();
        $teacher_id = $teacher -> id;
        if(!$student->teachers()->where('student_id', $student->id)->exists()) {
            $student->teachers()->attach($teacher_id);
        }
        return $url;
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
