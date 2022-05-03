<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
use App\Models\EduChat;
use App\Models\Lesson\Lesson;
use Illuminate\Http\Request;

class EduChatController extends Controller
{
    public function index(Request $request, $id)
    {
        if($request->get('type') === 'course') {
            $course = Course::findOrFail($id);
            $messages = $course->messages()->get();
        } elseif($request->get('type') === 'lesson') {
            $lesson = Lesson::findOrFail((int) $id);
            $messages = $lesson->messages()->get();
        }

        return $messages;
    }

    public function sendMsg(Request $request, $id)
    {
        if($request->get('type') === 'course') {
            $education = Course::findOrFail($id);

        } else {
            $education = Lesson::findOrFail($id);
        }
        $education ->messages() -> create([
            'sender_id' => \Auth::user()->id,
            'recipient_id' => 1,
            'text' => $request->get('message')
        ]);

        return 'success';
    }
}
