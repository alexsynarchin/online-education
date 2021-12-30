<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function filter(Request $request)
    {

        $edu_type = CategoryType::findOrFail($request->get('edu_type'));

        $url = route('catalog', $edu_type->slug);
        $url = $url . '?';
        if($request->has('level')) {
            $url = $url . '&levels=' . $request->get('level');
        }
        if($request->has('subject')) {
            $url = $url . '&subjects=' . $request->get('subject');
        }
        return $url;
    }
}
