<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        return redirect(route('lesson.show',[
            'id' => $lesson->id
        ]))->with(['msg', 'The Message']);
        //$data = json_encode($request->all());
        // return $data;
    }
}
