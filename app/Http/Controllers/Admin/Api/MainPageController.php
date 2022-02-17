<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class MainPageController extends Controller
{
    public function getData()
    {
        $main_page = Page::firstOrCreate(
            ['type'=>'main-page'],
            ['name' => 'Главная страница', 'slug' => 'main-page']
        );

        return $main_page -> blocks;
    }

    public function store(Request $request)
    {
        $blocks = $request->all();
        $page = Page::where('type', 'main-page')->first();
        if (count($blocks['slider']) > 0) {
            foreach ($blocks['slider'] as $key => $item) {
                if(array_key_exists('imageName', $item['image'])) {
                    $image = $page->addMediaFromBase64($item['image']['link'])
                        ->toMediaCollection('pages');
                    $item['image']['link'] = $image->getUrl();
                    $item['image']['id'] = $image -> id;
                    unset($item['image']['imageName']);
                    $blocks['slider'][$key] = $item;
                }
            }
        } else {
            $blocks['slider'] = [];
        }
        if (count($blocks['banners']) > 0) {
            foreach ($blocks['banners'] as $key => $item) {
                if(array_key_exists('imageName', $item['image'])) {
                    $image = $page->addMediaFromBase64($item['image']['link'])
                        ->toMediaCollection('pages');
                    $item['image']['link'] = $image->getUrl();
                    $item['image']['id'] = $image -> id;
                    unset($item['image']['imageName']);
                    $blocks['banners'][$key] = $item;
                }
            }
        } else {
            $blocks['banners'] = [];
        }
        if(count($blocks['for_whom']) > 0) {
            foreach ($blocks['for_whom'] as $key => $item) {
                if(array_key_exists('imageName', $item['image'])) {
                    $image = $page->addMediaFromBase64($item['image']['link'])
                        ->toMediaCollection('pages');
                    $item['image']['link'] = $image->getUrl();
                    $item['image']['id'] = $image -> id;
                    unset($item['image']['imageName']);
                    $blocks['for_whom'][$key] = $item;
                }
            }
        }else {
            $blocks['for_whom'] = [];
        }
        if(count($blocks['you_get']) > 0) {
            foreach ($blocks['you_get'] as $key => $item) {
                if(array_key_exists('imageName', $item['image'])) {
                    $image = $page->addMediaFromBase64($item['image']['link'])
                        ->toMediaCollection('pages');
                    $item['image']['link'] = $image->getUrl();
                    $item['image']['id'] = $image -> id;
                    unset($item['image']['imageName']);
                    $blocks['you_get'][$key] = $item;
                }
            }
        }else {
            $blocks['you_get'] = [];
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
        return 'success';
    }
}
