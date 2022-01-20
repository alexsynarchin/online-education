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
        $subjects = $filterData['subjects'];
        $levels = $filterData['levels'];
        $tags = $filterData['themes'];
        $yege = $filterData['yege'];

        $courses = (new Course) -> newQuery();
        $courses = $courses->where('edu_type_id', $filterData['edu_type'])
            ->whereHas('lessons', function ($query){
            $query -> where('status', 2);
        });
        if(count($subjects) > 0) {
            $courses = $courses->whereIn('subject_id', $subjects);
        }
        if(count($levels) > 0) {
            $courses = $courses->whereIn('edu_level_id', $levels);
        }
        if(count($tags) > 0) {
            $courses = $courses->whereHas('themes', function ($query) use ($tags){
                $query->whereIn('theme_id', $tags);
            });
        }
        if(count($yege)> 0) {
            $courses = $courses->where('yege', 1);
        }
        $courses = $courses
            ->with(['author', 'edu_type']) -> with('lessons', function($query) {
            $query -> where('status', 2);
            $query -> take(3);
        })->get();

        return $courses;
    }
}
