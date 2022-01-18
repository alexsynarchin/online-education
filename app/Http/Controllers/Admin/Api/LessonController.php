<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show($id)
    {
        $lesson = Lesson::with(['content', 'tests.questions.options']) -> findOrFail($id);
        return $lesson;
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
        return 'success';
    }
}
