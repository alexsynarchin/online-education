<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $filter = [
            'subject' =>'',
            'level' => '',
            'edu_type' => ''
        ];
        return view('site.teacher.index', [
            'filter' => $filter
        ]);
    }
}
