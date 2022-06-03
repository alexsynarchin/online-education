<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Reference\EduInstitution;
use Illuminate\Http\Request;

class EduInstitutionController extends Controller
{
    public function index(Request $request)
    {
        $edu_institutions = EduInstitution::where('type', $request->get('type')) ->where('city_id', $request->get('city_id'))->get();
        return $edu_institutions;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:edu_institutions',
            'city_id' => 'required',
            'type' => 'required'
        ], [
            'city_id.required' => 'Выберите город',
            'title.required' => 'Введите название учебного заведения',
            'title.unique' => 'Учебное заведение с таким названием уже существует',
            'type.required' => 'Выберите тип учебного заведения'
        ]);
        $edu_institution = EduInstitution::create($request->all());
        return $edu_institution;
    }

    public function findOrCreateRepetitor(Request $request)
    {

        $repetitor = EduInstitution::firstOrCreate([
            'city_id' =>$request->get('city'),
            'repititor'=> true,
            'title' => 'Репититор',
            'type' => $request->get('edu_type')
        ]);
        return $repetitor;
    }
}
