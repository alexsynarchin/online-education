<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $articles = Article::where('active', 1) -> orderBy('menuindex','asc') ->orderBy('created_at','desc') ->get();
        return view('site.blog.index', [
            'articles' => $articles
        ]);
    }

    public function show($slug)
    {
        $page =  Article::where('slug', $slug) -> firstOrFail();
        return view('site.blog.show', [
            'page'=>$page
        ]);
    }
}
