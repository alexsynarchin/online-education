<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Reference\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('region')->get();
        return $cities;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:cities'
        ], [
            'title.required' => 'Введите название города',
            'title.unique' => 'Город с таким названием уже существует'
        ]);
        $city = City::create($request->all());
        return $city;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:cities,title,' . $id
        ], [
            'title.required' => 'Введите название города',
            'title.unique' => 'Город с таким названием уже существует'
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
}
