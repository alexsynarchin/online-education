<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = (new Course) -> newQuery();
        if($request->has('status')) {
            $courses = $courses -> where('status', $request->get('status'));
        }
        if($request->has('subject')) {
            $courses = $courses -> where('subject_id', $request->get('subject'));
        }
        if($request->has('edu_type')) {
            $courses = $courses -> where('edu_type_id', $request->get('edu_type'));
        }
        if($request->has('author')) {
            $courses = $courses -> where('author_id', $request->get('author'));
        }
        $courses = $courses -> with(['author', 'edu_type', 'subject', 'level']) -> get();
        return $courses;
    }
    public function show($id)
    {
        $course = Course::with(['author', 'lessons'])->findOrFail($id);
        return $course;
    }

    public function changeStatus(Request $request)
    {
        $course = Course::findOrFail($request->get('id'));
        $course -> status = $request -> get('status');
        $course -> save();
        $message='';
        switch ($course->status){
            case 1:
                $message = "Курс снят с публикации";
                break;
            case 2:
                $message = "Курс опубликован";
                break;
            case 3:
                $message = "Курс отклонен";
                break;
            default:
                $message = "Повторите попытку";
        }
        return response()->json($message);
    }

    public function canselMsg(Request $request, $id)
    {
        return 'success';
    }
}
