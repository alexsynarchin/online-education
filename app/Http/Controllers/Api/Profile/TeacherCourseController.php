<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Models\Category\Course;
use Illuminate\Http\Request;
use Auth;

class TeacherCourseController extends Controller
{
    public function index($type)
    {
        $user = Auth::user();
        if ($type === 'moderate'){
            $status = 1;
            $empty_message = "В данный момент у вас нет курсов ожидающих модерации";
        }
        elseif ($type === 'draft')
        {
            $status = 0;
            $empty_message = "В данный момент у вас нет сохраненных  черновиков";

        }
        elseif($type === 'active'){
            $status = 2;
            $empty_message = "В данный момент у вас нет уроков прошедщих модерацию";
        }
        elseif($type === 'cancel'){
            $status = 3;
            $empty_message = "В данный момент у вас нет отклоненных уроков";
        }
        else{
            $status='moderate';
            $empty_message = "В данный момент у вас нет уроков ожидающих модерации";
        }
        $courses = Course::where('author_id', $user -> id)->where('status', $status) -> get();
        return $courses;
    }
    public function store(Request $request)
    {
        $request -> validate([
            'title' =>'required',
            'edu_type_id' => 'required',
            'subject_id' => 'required',
            'edu_level_id' => 'required'
        ], [
            'title.required' => 'Введите название курса',
            'edu_type_id.required' => 'Выберите  уровень образования',
            'subject_id.required' => 'Выберите предмет',
            'edu_level_id.required' => 'Выберите  уровень образования',
        ]);
        $edu_cat = Category::firstOrCreate([
            'category_type_id' => $request->get('edu_type_id')
        ]);
        $subject_cat = Category::firstOrCreate([
            'category_type_id' => $request->get('subject_id'),
            'parent_id' => $edu_cat -> id,
        ]);
        $edu_level_cat = Category::firstOrCreate([
            'category_type_id' => $request->get('edu_level_id'),
            'parent_id' => $subject_cat -> id,
        ]);
        $course = Course::create($request->except(['image']));
        $course -> category_id = $edu_level_cat -> id;
        $course -> author_id = Auth::user()-> id;
        $course -> status = 1;
        $course -> save();
        if($request->has('image')) {
            $course ->addMediaFromBase64($request->get('image'))
                ->toMediaCollection('courses');
        }
        return $course;
    }
    public function update(Request $request)
    {

    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug) -> firstOrFail();
        return $course;
    }
}
