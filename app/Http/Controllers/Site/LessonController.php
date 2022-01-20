<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
use App\Models\Lesson\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show($edu_slug, $course_slug, $slug)
    {
        $course = Course::where('slug', $course_slug) -> firstOrFail();
        $lesson = Lesson::where('slug', $slug) -> firstOrFail();
        $other_lessons = $course -> lessons() -> where('status', 2) ->  where('id', '!=', $lesson->id) ->get();
        $filter = [
            'redirect' => true,
            'yege' => $course->yege ? [1] : [],
            'subjects' => [$course -> subject_id],
            'levels' => [$course -> edu_level_id],
            'edu_type' => $course -> edu_type_id,
            'themes' => [],
        ];
        return view('site.lesson.show', [
            'course' => $course,
            'lesson' => $lesson,
            'filter' => $filter,
            'other_lessons' => $other_lessons,
        ]);
    }
}
