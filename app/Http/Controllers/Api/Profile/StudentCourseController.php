<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function index()
    {
        $student_id = \Auth::user()->studentAccount->id;

        $courses = Course::whereHas('lessons', function($query) use ($student_id){
            $query->whereHas('students', function ($query) use ($student_id){
                $query->where('student_id', $student_id);
            });
        })->with(['author', 'edu_type','lessons' => function($query) use ($student_id){
            $query->whereHas('students', function ($query) use ($student_id){
                $query->where('student_id', $student_id);
            });
        }]) -> get();
        return $courses;
    }
}
