<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

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
        $courses = $courses -> with(['author', 'edu_type',  'subject', 'level']) ->withCount(['lessons' => function($query){
            $query->where('status', 1);
        }]) -> get();

        return $courses;
    }
    public function show($id)
    {
        $course = Course::with(['author', 'messages', 'direction', 'specialty', 'subject', 'lessons', 'themes' => function($query) {
            $query -> where('active', 0);
        }])->findOrFail($id);
        return $course;
    }
    public function readMsg($id)
    {
        $course = Course::findOrFail($id);
        $unread_messages = $course->messages()->where('read', 0)->get();
        foreach ($unread_messages as $message) {
            if($message->sender_type = 'teacher') {
                $message->read = 1;
                $message->save();
            }
        }

    }
    public function changeStatus(Request $request)
    {
        $course = Course::findOrFail($request->get('id'));
        $course -> status = $request -> get('status');
        $course -> save();
        if($course -> status === 2) {
            $themes = $course->themes;
            foreach ($themes as $theme) {
                $theme -> active = 1;
                $theme -> save();
            }
            $subject = $course->subject;
            $subject->active = 1;
            $subject->save();
            if($course->direction_id) {
                $direction  = $course->direction;
                $direction->active = 1;
                $direction->save();
            }
            if($course->specialty_id) {
                $specialty= $course->specialty;
                $specialty->active = 1;
                $specialty->save();
            }
        }
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
        $sender_id = Auth::user() -> id;
        $course = Course::findOrFail($id);
        $course->status = 3;
        $course->save();
        $course->messages()->create([
            'sender_id' => $sender_id,
            'recipient_id' => $course->author_id,
            'text' => $request->get('message'),
            'sender_type' => 'moderator',
            'cansel_reason' => true,
        ]);
        return 'success';
    }

    public function sendMsg(Request $request, $id)
    {
        $sender_id = Auth::user() -> id;
        $course = Course::findOrFail($id);
        $course->status = 3;
        $course->save();
        $message = $course->messages()->create([
            'sender_id' => $sender_id,
            'recipient_id' => $course->author_id,
            'sender_type' => 'moderator',
            'text' => $request->get('message'),
        ]);
        return $message;
    }
}
