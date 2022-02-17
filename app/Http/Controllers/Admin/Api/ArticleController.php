<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\RichTextService;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('menuindex') -> get();
        return $articles;
    }
    public function item($id)
    {
        $page = Article::with('seo') ->findOrFail($id);
        return json_encode($page);
    }
    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'unique:pages'
        ]);


        $page = Article::create($request->except('seo','text'));
        $page -> seo() ->create($request -> get('seo'));
        if($request -> get('text')) {
            $richTextService = new RichTextService();
            $text = $richTextService -> store($request->input('text'),'static-pages', $page->id);
            $page -> text = $text;
        } else {
            $page -> text = '';
        }
        $page -> save();

        return'success';
    }
    public function update(Request $request, $id)
    {
        $page = Article::findOrFail($id);
        $request->validate([
            'slug' => 'unique:pages,slug,' . $page->id
        ]);
        $page -> update($request -> except('seo', 'text' , 'blocks'));
        $page ->seo() -> update([
            'title' => $request->get('seo.title'),
            'description' =>  $request->get('seo.description'),
            'keywords' =>  $request->get('seo.keywords')
        ]);
        if($request -> get('text')) {
            $richTextService = new RichTextService();
            $text = $richTextService -> store($request->input('text'),'static-pages', $page->id);
            $page -> text = $text;
        } else {
            $page -> text = '';
        }
        $page->save();

        return'success';
    }
    public function remove($id)
    {
        $page = Article::findOrFail($id);
        $page ->delete();
        return 'success';
    }
}
