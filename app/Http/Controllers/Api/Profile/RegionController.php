<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Reference\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        $regions = Region::all();
        return $regions;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:regions,title'
        ], [
            'title.required' => 'Введите название региона',
            'title.unique' => 'Регион с таким названием существует'
        ]);
        $region = Region::create($request->all());
        return $region;
    }
}
