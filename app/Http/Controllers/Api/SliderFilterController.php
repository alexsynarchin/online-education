<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SliderFilterController extends Controller
{
    public function filter(Request $request)
    {
        $url = route('catalog', $request->get('edu_type'));
        return $url;
    }
}
