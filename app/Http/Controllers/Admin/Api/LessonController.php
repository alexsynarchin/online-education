<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
use App\Models\Lesson\Lesson;
use Illuminate\Http\Request;
use Auth;

class LessonController extends Controller
{
    public function show($id)
    {

        $lesson = Lesson::with(['content', 'messages'])-> findOrFail($id);
        $course = Course::findOrFail($lesson->course_id);
        $test = $lesson->tests() -> with('questions.options')->first();
        return ['lesson' => $lesson, 'course' => $course, 'test' => $test];
    }
    public function changeStatus(Request $request)
    {
        $lesson = Lesson::findOrFail($request->get('id'));
        $lesson -> status = $request -> get('status');
        $lesson -> save();
        $message='';
        switch ($lesson->status){
            case 1:
                $message = "Урок снят с публикации";
                break;
            case 2:
                $message = "Урок опубликован";
                break;
            case 3:
                $message = "Урок отклонен";
                break;
            default:
                $message = "Повторите попытку";
        }
        return response()->json($message);
    }
    public function canselMsg(Request $request, $id)
    {
        $sender_id = Auth::user() -> id;
        $lesson = Lesson::findOrFail($id);
        $lesson -> status = 3;
        $lesson->save();
        $lesson->messages()->create([
            'sender_id' => $sender_id,
            'recipient_id' => $lesson->user_id,
            'text' => $request->get('message'),
            'sender_type' => 'moderator',
            'cansel_reason' => true,
        ]);
        return 'success';
    }

    public function sendMsg(Request $request, $id)
    {
        $sender_id = Auth::user() -> id;
        $lesson = Lesson::findOrFail($id);
        $lesson->status = 3;
        $lesson->save();
        $message = $lesson->messages()->create([
            'sender_id' => $sender_id,
            'recipient_id' => $lesson->user_id,
            'sender_type' => 'moderator',
            'text' => $request->get('message'),
        ]);
        return $message;
    }
}
