<?php

namespace App\Http\Controllers\Site\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
use App\Notifications\NewComment;
use Illuminate\Http\Request;
use App\Models\Comment\Comment;
use App\Models\User;
use Auth;
class CommentController extends Controller
{

    public function index($id)
    {
        $course = Course::findOrFail($id);
        $comments =$course  -> comments() -> where('active', 1) -> with('user') ->get();
        return $comments;
    }

    public function store(Request $request)
    {
        $request ->validate([
            'comment' => 'required',
            'conf_agree' =>'accepted'
        ]);
        $course = Course::findOrFail($request->get('course_id'));
        $comment = $course -> comments()->create($request->all());
        $comment -> active = 1;
        $comment -> save();
        $toUser = User::findOrFail($course->author_id);
        $fromUser = Auth::user();
        if($toUser -> notifications) {
            $toUser->notify(new NewComment($course, $fromUser));
        }
        return $comment;
    }
}
