<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Reference\EduInstitution;
use Illuminate\Http\Request;

class EduInstitutionController extends Controller
{
    public function index()
    {
        $edu_institutions = EduInstitution::with(['city'])->get();
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
        $city = EduInstitution::create($request->all());
        return $city;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:edu_institutions,title,' . $id,
            'city_id' => 'required',
            'type' => 'required'
        ], [
            'city_id.required' => 'Выберите город',
            'title.required' => 'Введите название учебного заведения',
            'title.unique' => 'Учебное заведение с таким названием уже существует',
            'type.required' => 'Выберите тип учебного заведения'
        ]);
        $city = EduInstitution::findOrFail($id);
        $city = $city-> update($request->all());
        return $city;
    }

    public function show($id)
    {
        $city = EduInstitution::findOrFail($id);
        return $city;
    }

    public function remove($id)
    {
        $edu_institution = EduInstitution::findOrFail($id);
        $edu_institution->delete();
        return 'success';
    }
}
