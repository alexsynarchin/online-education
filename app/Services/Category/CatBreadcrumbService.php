<?php


namespace App\Services\Category;


class CatBreadcrumbService
{
    public function make($title,$url){
        $breadcrumb = [
            'title' => $title,
            'url' => $url
        ];
        return $breadcrumb;
    }
}
