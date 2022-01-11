<?php

namespace App\Http\Controllers\Site\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
use Illuminate\Http\Request;
use App\Models\Comment\Comment;
class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::where('active', 1) ->get();
        return$comments;
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
        return $comment;
    }
}
