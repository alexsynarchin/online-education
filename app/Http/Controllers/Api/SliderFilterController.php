<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SliderFilterController extends Controller
{
    public function filter(Request $request)
    {
        $keys = [
            'edu_level'
        ];
        $url = route('catalog', $request->get('edu_type'));
        $url = $url  .  '?levels=' . $request->get('edu_level');
        return $url;
    }
}
