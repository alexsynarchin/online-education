<?php

namespace App\Http\Services;


use App\Models\Category\CategoryType;
use App\Models\Category\Course;

class CatalogFilterService
{
    private $edu_type;
    private $subjects;
    private $levels;
    private $themes;

    public function filter($filterData)
    {
        $edu_type = CategoryType::where('type', 'edu_type')->where('slug', $filterData['edu_type']) ->firstOrFail('id');

        return $edu_type;
    }
}
