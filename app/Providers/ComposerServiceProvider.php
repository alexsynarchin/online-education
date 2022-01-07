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
            $filter = [
                'subject' => $request->get('subjects'),
                'level' => $request->get('levels'),
                'edu_type' => $category_type -> id,
                'theme' => $request->get('themes')
            ];
            $view->with(['filter' => $filter]);
        });
    }
}
