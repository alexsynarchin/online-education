<?php


namespace App\Services\Lesson;


use App\Models\Lesson\Lesson;

class LessonService
{
    public function getLessonEdit($id){
        $lesson = Lesson::where('id', $id) -> with(['tests.questions.options','description'])->first();
        $course = $lesson ->course()->first();

        $lesson->toArray();
        $description = $lesson['description'];
        $content = $lesson['content'];
        unset($lesson['content']);
        $test = $lesson['tests'][0];
        unset($lesson['tests']);
        $lesson['description'] = $description;
        $data = [
            'lesson' => $lesson,
            'content' => $content,
            'test_student' =>$test,
            'course' => $course
        ];

        return $data;
    }
}
