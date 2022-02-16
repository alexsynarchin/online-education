<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SliderFilterController extends Controller
{
    public function filter(Request $request)
    {
        $url = route('catalog',['edu_slug' => $request->get('edu_type'), 'level' =>$request->get('edu_level')]);
        return $url;
    }
}
