<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $edu_types = CategoryType::where('type', 'edu_type') -> get(['id', 'title']);
        $slides = [];
        foreach ($edu_types as $edu_type) {
            $slide = [
                'id' => $edu_type -> id,
                'title' => $edu_type -> title,
                'text' => 'Учёба.ру — это самый большой каталог учебных заведений и программ в России и за рубежом.',
                'label' =>'курс',
                'levels' => CategoryType::where('type', 'edu_level') -> where('parent_id', $edu_type->id) -> get(['id', 'title']),

            ];
            array_push($slides, $slide);
            $slides[0]['label'] = 'класс';
        }
        return view('site.home.index',[
            'slides' => $slides,
        ]);
    }
}
