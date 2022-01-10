<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
use App\Models\Lesson\Lesson;
use App\Services\Lesson\UpdateLessonService;
use App\Services\StoreLessonService;
use Illuminate\Http\Request;

class TeacherLessonController extends Controller
{
    public function show($course_slug, $slug)
    {
        $course = Course::where('slug', $course_slug) -> firstOrFail();
        $lesson = Lesson::where('course_id', $course -> id) -> where('slug', $slug) ->with(['content']) -> firstOrFail();
        $test = $lesson->tests() -> with('questions.options')->first();
        return ['lesson' => $lesson, 'course' => $course, 'test' => $test];
    }

    public function store(Request $request)
    {
        $storeLesson = new StoreLessonService();
        $lesson = $storeLesson -> make($request);
        $course = Course::findOrFail($lesson -> course_id);
        return redirect(route('profile.course.show',[
            'slug' => $course -> slug
        ]))->with(['msg', 'The Message']);

    }

    public function update(Request $request)
    {
        $updateService = new UpdateLessonService();
        $lesson = $updateService ->update($request, $request->get('lesson')['id']);
        return 'success';
    }

    public function remove($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson -> delete();
        return $lesson -> id;
    }

}
