<?php

namespace App\Providers;

use App\Models\Category\CategoryType;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        View::composer('site.base._partials.sidebar', function($view) use($request) {
            $view_data= $view->getData();
            $category_type = CategoryType::where('slug', $view_data['slug']) -> firstOrFail();
            $subjects = [];
            if($request->has('subjects')) {
                foreach ($request->get('subjects') as $subject) {
                    $subject = (int) $subject;
                    $subjects[] = $subject;
                }
            }
            $levels = [];
            if($request->has('levels')) {
                foreach ($request->get('levels') as $level) {
                    $level = (int) $level;
                    $levels[] = $level;
                }
            }
            $direction = '';
            if($request->has('direction')) {
                $direction = CategoryType::where('slug', $request->get('direction'))->firstOrFail(['id']);
                $direction = $direction->id;
            }
            $filter = [
                'yege' => [],
                'subjects' =>$subjects,
                'levels' => $levels,
                'edu_type' => $category_type -> id,
                'themes' => $request->get('themes') ?  $request->get('themes') : [],
                'direction' => $direction,
                'specialties' => $request->get('specialties') ? $request->get('specialties') : [],
            ];

            $view->with(['filter' => $filter]);
        });
    }
}
