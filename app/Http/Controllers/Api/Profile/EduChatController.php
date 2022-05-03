<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
use Illuminate\Http\Request;

class EduChatController extends Controller
{
    public function index($course_id)
    {
        $course = Course::findOrFail($course_id);
        $messages = $course->messages()->get();
        return $messages;
    }
}
