<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function show($slug)
    {
        $page = Page::with('seo') -> where('slug', $slug)->  firstOrFail();
        $seo = $page->seo;
        return view('site.static-page.show',[
            'page' => $page,
            'seo' => $seo,
        ]);
    }
}
