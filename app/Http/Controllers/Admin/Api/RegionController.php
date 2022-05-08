<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Reference\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::all();
        return $regions;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:regions'
        ], [
            'title.required' => 'Введите название региона',
            'title.unique' => 'Регион с таким названием уже существует'
        ]);
        $region = Region::create($request->all());
        return $region;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:regions,title,' . $id
        ], [
            'title.required' => 'Введите название региона',
            'title.unique' => 'Регион с таким названием уже существует'
        ]);
        $region = Region::findOrFail($id);
        $region = $region-> update($request->all());
        return $region;
    }

    public function show($id)
    {
        $region = Region::findOrFail($id);
        return $region;
    }

    public function remove($id)
    {
        $region = Region::findOrFail($id);
        $region->delete();
        return 'success';
    }
}
