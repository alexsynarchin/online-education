<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $student_id = \Auth::user()->studentAccount->id;
        $teachers = User::whereHas('teacherAccount', function ($query) use ($student_id){
            $query->whereHas('students', function ($query) use ($student_id){
                $query->where('student_id', $student_id);
            });
        })-> with('eduInstitutions') ->get();
        return $teachers;
    }
}
