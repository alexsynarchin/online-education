<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
use Illuminate\Http\Request;

class EduChatController extends Controller
{
    public function index(Request $request, $id)
    {
        if($request->get('type') === 'course') {
            $course = Course::findOrFail($id);
            $messages = $course->messages()->get();
        }

        return $messages;
    }

    public function sendMsg($id)
    {

    }
}
