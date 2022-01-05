<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private $filter;
    public function __construct()
    {
        $this -> filter = [
            'subject' =>'',
            'level' => '',
            'edu_type' => ''
        ];
    }
    public function index()
    {
        return view('site.teacher.index', [
            'filter' => $this -> filter
        ]);
    }
    public function show($id)
    {
        $teacher = User::with(['eduInstitutions', 'teacherCourses'=> function($query){
            $query -> where('status',2);
            $query -> whereHas('lessons', function ($query){
                $query->where('status',2);
            });
            $query -> with(['lessons' => function($query) {
                $query->where('status',2);
            }]);
        }]) -> findOrFail($id);
        return view('site.teacher.show', [
            'teacher' => $teacher,
            'filter' => $this -> filter
        ]);
    }
}
