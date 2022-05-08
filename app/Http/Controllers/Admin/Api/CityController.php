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

}
