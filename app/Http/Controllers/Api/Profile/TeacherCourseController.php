<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Models\Category\CategoryType;
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
        elseif($type === 'cansel'){

            $status = 3;
            $empty_message = "В данный момент у вас нет отклоненных уроков";
        }
        else{
            $status='moderate';
            $empty_message = "В данный момент у вас нет уроков ожидающих модерации";
        }
        $courses = Course::where('author_id', $user -> id)->where('status', $status)->with(['edu_type', 'subject', 'level', 'messages'=> function ($query) {
            $query->where('cansel_reason', 1);
            return $query->orderBy('id', 'desc')->limit(1);
        }]) -> get();
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
        $subject_id = $request->get('subject_id');
        if(!CategoryType::where('id', $subject_id)->exists()) {
            if(CategoryType::where('type', 'subject') -> where('title', $subject_id)->exists()) {
                $subject = CategoryType::where('type', 'subject') -> where('title', $subject_id)->first();
                $subject_id = $subject->id;
            } else {
                $subject = CategoryType::create([
                   'type' => 'subject',
                   'title' => $subject_id,
                   'active' => 0
                ]);
                $subject_id = $subject ->id;
            }
        }
        $subject_cat = Category::firstOrCreate([
            'category_type_id' =>$subject_id,
            'parent_id' => $edu_cat -> id,
        ]);
        $direction_id = $request->get('direction_id');
        if($direction_id) {
            if(!CategoryType::where('id', $direction_id)->exists()){
                if(CategoryType::where('type', 'specialty') ->where('parent_id', 0) -> where('title', $direction_id)->exists()) {
                    $direction = CategoryType::where('type', 'specialty') ->where('parent_id', 0) -> where('title', $direction_id)->first();
                } else {
                    $direction =  CategoryType::create([
                        'type' => 'specialty',
                        'title' => $direction_id,
                        'active' => 0,
                    ]);
                }
                $direction_id = $direction->id;
            }
        }
        $specialty_id = $request->get('specialty_id');
        if($direction_id && $specialty_id) {
            if(!CategoryType::where('id', $specialty_id)->exists()) {
                if(CategoryType::where('type', 'specialty')->where('parent_id', $direction_id)->where('title', $specialty_id)->exists()) {
                    $specialty = CategoryType::where('type', 'specialty')->where('parent_id', $direction_id)->where('title', $specialty_id)->first();
                } else {
                    $specialty = CategoryType::create([
                        'type' => 'specialty',
                        'title' => $specialty_id,
                        'active' => 0,
                        'parent_id' => $direction_id
                    ]);
                }
                $specialty_id = $specialty->id;
            }
        }


        $edu_level_cat = Category::firstOrCreate([
            'category_type_id' => $request->get('edu_level_id'),
            'parent_id' => $subject_cat -> id,
        ]);
        $course = Course::create($request->except(['image','imageName', 'subject_id', 'direction_id', 'specialty_id']));
        $course -> category_id = $edu_level_cat -> id;
        $course->direction_id = $direction_id;
        $course -> specialty_id = $specialty_id;
        $course -> author_id = Auth::user()-> id;
        $course -> status = 1;
        $course->subject_id = $subject_id;
        $course -> save();
        if($request->has('image') && $request->get('image')) {
            $course ->addMediaFromBase64($request->get('image'))
                ->toMediaCollection('courses');
        }
        if(count($request->get('themes')) > 0) {
            foreach ($request->get('themes') as $theme) {
                if(!CategoryType::where('id', $theme)  -> exists()) {
                    if(CategoryType::where('type', 'theme') -> where('title', $theme) -> exists()) {
                        $theme = CategoryType::where('type', 'theme') -> where('title', $theme)->first();
                    } else {
                        $theme = CategoryType::create([
                            'type' => 'theme',
                            'title' => $theme,
                            'active' => 0,
                        ]);
                    }
                }
                $course -> themes() -> attach($theme);
            }
        }
        return route('profile.course.show', $course -> slug);
    }
    public function update(Request $request)
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
        $subject_id = $request->get('subject_id');
        if(!CategoryType::where('id', $subject_id)->exists()) {
            if(CategoryType::where('type', 'subject') -> where('title', $subject_id)->exists()) {
                $subject = CategoryType::where('type', 'subject') -> where('title', $subject_id)->first();
                $subject_id = $subject->id;
            } else {
                $subject = CategoryType::create([
                    'type' => 'subject',
                    'title' => $subject_id,
                    'active' => 0
                ]);
                $subject_id = $subject ->id;
            }
        }
        $subject_cat = Category::firstOrCreate([
            'category_type_id' => $subject_id,
            'parent_id' => $edu_cat -> id,
        ]);
        $direction_id = $request->get('direction_id');
        if($direction_id) {
            if(!CategoryType::where('id', $direction_id)->exists()){
                if(CategoryType::where('type', 'specialty') ->where('parent_id', 0) -> where('title', $direction_id)->exists()) {
                    $direction = CategoryType::where('type', 'specialty') ->where('parent_id', 0) -> where('title', $direction_id)->first();
                } else {
                    $direction =  CategoryType::create([
                        'type' => 'specialty',
                        'title' => $direction_id,
                        'active' => 0,
                    ]);
                }
                $direction_id = $direction->id;
            }
        }
        $specialty_id = $request->get('specialty_id');
        if($direction_id && $specialty_id) {
            if(!CategoryType::where('id', $specialty_id)->exists()) {
                if(CategoryType::where('type', 'specialty')->where('parent_id', $direction_id)->where('title', $specialty_id)->exists()) {
                    $specialty = CategoryType::where('type', 'specialty')->where('parent_id', $direction_id)->where('title', $specialty_id)->first();
                } else {
                    $specialty = CategoryType::create([
                        'type' => 'specialty',
                        'title' => $specialty_id,
                        'active' => 0,
                        'parent_id' => $direction_id
                    ]);
                }
                $specialty_id = $specialty->id;
            }
        }
        $edu_level_cat = Category::firstOrCreate([
            'category_type_id' => $request->get('edu_level_id'),
            'parent_id' => $subject_cat -> id,
        ]);
        $course = Course::findOrFail($request->get('id'));
        $course -> update(($request->except(['image','imageName', 'subject_id', 'direction_id', 'specialty_id'])));
        $course->direction_id = $direction_id;
        $course -> specialty_id = $specialty_id;
        $course -> status = 1;
        $course->subject_id = $subject_id;
        $course -> save();
        if($request -> has('imageName')) {
            $course ->addMediaFromBase64($request->get('image'))
                ->toMediaCollection('courses');
        }
        $course->themes()->detach();
        if(count($request->get('themes')) > 0) {
            foreach ($request->get('themes') as $theme) {
                if(!CategoryType::where('id', $theme)  -> exists()) {
                    if(CategoryType::where('type', 'theme') -> where('title', $theme) -> exists()) {
                        $theme = CategoryType::where('type', 'theme') -> where('title', $theme)->first();
                    } else {
                        $theme = CategoryType::create([
                            'type' => 'theme',
                            'title' => $theme,
                            'active' => 0,
                        ]);
                    }
                }
                $course -> themes() -> attach($theme);
            }
        }
        return route('profile.course.show', $course -> slug);
    }

    public function remove($id)
    {
        $course = Course::findOrFail($id);
        $course -> delete();
        return $course -> id;
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug) ->with(['lessons.messages'=>function($query) {
            $query->where('cansel_reason', 1);
            return $query->orderBy('id', 'desc')->limit(1);
        }, 'themes' => function($query){
            $query ->select('theme_id');
        }]) -> firstOrFail();
        $themes = [];
        foreach ($course -> themes as $theme) {
            $themes[] = $theme->theme_id;
        }
        $course = $course -> toArray();
        $course['themes'] = $themes;

        return $course;
    }
    public function getCoursesCount(Request $request)
    {
        $tabs=[];
        $names = [

            [
                'type' => 'active',
                'title' => 'Активные'
            ],
            [
                'type' => 'moderate',
                'title' => 'На модерации'
            ],
            [
                'type' => 'draft',
                'title' => 'Черновики'
            ],

            [
                'type' => 'cansel',
                'title' =>  'Отклоненные'
            ]
        ];
        foreach ($request->get('statuses') as $key => $status)
        {

            $tab = [
                'type' => $names[$key]['type'],
                'title' => $names[$key]['title'],
                'count' => Course::where('status', $status)->where('author_id', Auth::user()->id)->count()
            ];
            $tabs[]=$tab;
        }
        return $tabs;
    }
}
