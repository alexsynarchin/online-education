<?php

namespace App\Services;
use App\Models\Category\Course;
use App\Models\Lesson\Lesson;
use Illuminate\Support\Str;

class SlugService
{
    public $models = [
        'Course' => Course::class,
        'Lesson' => Lesson::class,
    ];
    public function createSlug($title,$modelName, $id = 0)
    {
        // Normalize the title
        $slug = Str::slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug,$modelName, $id);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10000; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }
    protected function getRelatedSlugs($slug, $modelName, $id = 0 )
    {
        $class = $this->getModel($modelName);

        $model = new $class;
        return $model::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
    public function getModel($model)
    {
        return $this->models[$model];
    }
}
