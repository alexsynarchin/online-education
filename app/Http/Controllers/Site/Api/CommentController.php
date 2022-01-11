<?php

namespace App\Http\Controllers\Site\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{



    public function store(Request $request)
    {
        $request ->validate([
            'comment' => 'required',
            'conf_agree' =>'accepted'
        ]);
        dd($request->all());
    }
}
