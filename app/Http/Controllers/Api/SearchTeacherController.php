<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reference\City;
use App\Models\Reference\EduInstitution;
use App\Models\User;
use Illuminate\Http\Request;

class SearchTeacherController extends Controller
{
    public function search(Request $request)
    {
        $teachers = User::whereHas('eduInstitutions', function ($query) use($request){
            $query -> where('edu_institution_id', $request->get('edu_institution'));
        }) -> with('eduInstitutions') ->get();
        return $teachers;
    }
    public function filter(Request $request)
    {
        $response = null;
        if($request -> get('type') === 'city') {
            $response = City::all();
        } elseif ($request->get('type') === 'edu_institution') {
            $response = EduInstitution::where('type', $request ->get('edu_type'))
                ->where('city_id', $request->get('city')) ->get();
        }
        return $response;
    }
}
