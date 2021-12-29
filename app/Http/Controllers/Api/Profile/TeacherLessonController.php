<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
use App\Services\StoreLessonService;
use Illuminate\Http\Request;

class TeacherLessonController extends Controller
{
    public function store(Request $request)
    {
        /*$request->validate([
       'course_theme_id' => 'required',
       'lesson_description' => 'required',
       'lesson_content' => 'required'
   ]);*/

        $storeLesson = new StoreLessonService();
        $lesson = $storeLesson -> make($request);
        $course = Course::findOrFail($lesson -> course_id);
        return redirect(route('profile.course.show',[
            'slug' => $course -> slug
        ]))->with(['msg', 'The Message']);
        //$data = json_encode($request->all());
        // return $data;
    }
}
