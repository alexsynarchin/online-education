<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Lesson\Lesson;
use Illuminate\Http\Request;

class TestResultController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        $user_id = $user->id;
        $studentAccount = $user->studentAccount;
        $lessons = Lesson::whereHas('tests', function ($query) use ($user_id) {
            $query->whereHas('results', function ($query) use ($user_id){
               $query->where('user_id', $user_id);
            });
        }) -> with('course.edu_type') -> get();
        return $lessons;
    }
}
