<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use Illuminate\Http\Request;

class CategoryTypeController extends Controller
{
    public function getList($type)
    {
        $list = CategoryType::where('type', $type) -> get(['id', 'title']);
        return $list;
    }
}
