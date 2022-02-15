<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use App\Services\RichTextService;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;


class StaticPageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return $pages;
    }
    public function item($id)
    {
        $page = Page::with('seo') ->findOrFail($id);
        return json_encode($page);
    }
    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'unique:pages'
        ]);


        $page = Page::create($request->except('seo','text'));
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
        $page = Page::findOrFail($id);
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
        if($page->type === 'about') {
            $blocks = $request->get('blocks');
            if(array_key_exists('imageName', $blocks['image'])) {
                $image = $page->addMediaFromBase64($blocks['image']['link'])
                    ->toMediaCollection('pages');
                $blocks['image']['link'] = $image->getUrl();
                $blocks['image']['id'] = $image -> id;
                unset($blocks['image']['imageName']);
            }
            if (count($blocks['about_list']) > 0) {
                foreach ($blocks['about_list'] as $key => $item) {
                    if(array_key_exists('imageName', $item['image'])) {
                        $image = $page->addMediaFromBase64($item['image']['link'])
                            ->toMediaCollection('icons');
                        $item['image']['link'] = $image->getUrl();
                        $item['image']['id'] = $image -> id;
                        unset($item['image']['imageName']);
                        $blocks['about_list'][$key] = $item;
                    }
                }
            }
            if(count($blocks['delete_img']) > 0) {
                foreach ($blocks['delete_img'] as $id) {
                    $media = Media::findOrFail($id);
                    $media ->delete();
                }
            }
            unset($blocks['delete_img']);
            $page->blocks = $blocks;
            $page->save();
        }

        return'success';
    }
    public function remove($id)
    {
        $page = Page::findOrFail($id);
        $page ->delete();
        return 'success';
    }
}
