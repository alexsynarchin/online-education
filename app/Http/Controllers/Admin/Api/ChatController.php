<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson\Lesson;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function readMessages(Request $request)
    {
        if($request->get('type') === 'lesson') {
            $lesson = Lesson::findOrFail($request->get('id'));
            $messages = $lesson->messages()->where('sender_id', $lesson->user_id)->get();
            foreach ($messages as $message) {
                $message->read = 1;
                $message->save();
            }
        }
        return 'success';
    }
}
