<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $slides = [];
        $page = Page::where('type', 'main-page')->firstOrFail();
        if(isset($page->blocks['slider'])) {
            $ids=[];
            foreach ($page->blocks['slider'] as $slide) {
                $ids[] = $slide['edu_type_id'];
            }

            $edu_types = CategoryType::whereIn('id',$ids)->with('levels') -> get(['id', 'title', 'slug']);
            foreach ($edu_types as $key => $edu_type) {
                $label = 'курс';
                if($edu_type->id === 1) {
                    $label = 'класс';
                }
                $slide = [
                    'id' => $edu_type -> id,
                    'title' => $page->blocks['slider'][$key]['title'],
                    'slug' => $edu_type -> slug,
                    'text' => $page->blocks['slider'][$key]['text'],
                    'label' =>$label,
                    'image' => $page->blocks['slider'][$key]['image']['link'],
                    'levels' => $edu_type->levels,

                ];
                array_push($slides, $slide);
                $slides[0]['label'] = 'класс';
            }
        }

        return view('site.home.index',[
            'slides' => $slides,
        ]);
    }
}
