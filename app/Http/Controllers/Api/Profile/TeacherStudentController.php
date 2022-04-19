<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherStudentController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        $teacher_profile = $user->teacherAccount;
        $students = $teacher_profile->students()->with('user')->get();
        return $students;
    }
}
