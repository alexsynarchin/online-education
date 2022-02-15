<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Lesson\Lesson;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessage;
use Illuminate\Http\Request;
use Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        $user_id = $user->id;
        if ($user ->profile_type ==='student') {
            $student_id = $user->studentAccount->id;
            $chats = Chat::whereHasMorph('chatable',['App\Models\Lesson\Lesson'], function ($query) use ($student_id){
                $query ->whereHas('students',function ($query) use ($student_id){
                    $query->where('student_id', $student_id);
                });
            })->where('chat_type','student_chat')->get();
        } elseif ($user ->profile_type ==='teacher')
        {
            $chats = Chat::whereHasMorph('chatable',['App\Models\Lesson\Lesson'], function ($query) use ($user_id){
                $query -> where('user_id', $user_id);
            })->where('chat_type','student_chat')->get();
        }
        return $chats;
    }
    public function show($id)
    {
        $chat = Chat::findOrFail($id);
        $lesson = $chat ->chatable()->first();
        $user = \Auth::user();
        $unread = $chat->messages()->where('messagable_id','!=', $user->id)->update(['read'=> true]);
        return [
            'chat' => $chat,
            'lesson' => $lesson
        ];
    }
    public function createOrGo(Request $request)
    {
        $lesson = Lesson::findOrFail($request->get('lesson_id'));
        $chat =  $lesson->chat()->firstOrCreate([
            'sender_id' => \Auth::user()->id,
            'teacher_id' => $lesson->user_id,
            'chat_type' =>  'student_chat'
        ]);
        $url = '/profile/messages/' . $chat->id;
        return $url;
    }
    public function sendMessage(Request $request, $id)
    {
        $user = \Auth::user();
        $message = $user->messages()->create([
            'chat_id' => $id,
            'text' => $request -> get('text')
        ]);
        if($request->file('files')) {

            foreach ($request->file('files') as $key => $file) {
                $message ->addMedia($request->file('files')[$key]['file'])->toMediaCollection('messages');
            }
        }
        $chat = Chat::findOrFail($id);
        $fromUser = User::findOrFail($chat->sender_id);
        $user->notify(new NewMessage($message, $fromUser));
        return 'Сообщение успешно отправлено';
    }
    public function messages($id)
    {
        $messages = Message::where('chat_id', $id)->get();
        return $messages;
    }
}
