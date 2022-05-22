<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Reference\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('region_id')) {
            $cities = City::where('region_id', $request->get('region_id'))->with('region')->get();
        } else {
            $cities = City::with('region')->get();
        }

        return $cities;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:regions'
        ], [
            'title.required' => 'Введите название региона',
            'title.unique' => 'Регион с таким названием уже существует'
        ]);
        $city = City::create($request->all());
        return $city;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:regions,title,' . $id
        ], [
            'title.required' => 'Введите название региона',
            'title.unique' => 'Регион с таким названием уже существует'
        ]);
        $city = City::findOrFail($id);
        $city = $city-> update($request->all());
        return $city;
    }

    public function show($id)
    {
        $city = City::findOrFail($id);
        return $city;
    }

    public function remove($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return 'success';
    }

}
