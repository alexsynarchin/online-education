<?php


namespace App\Services\Category;


use PhpParser\Node\Expr\Array_;

class CatSidebarService
{
    public function makePanel($items, $title, $parent_url, $active_slug = null)
    {
        $sidebar_panel = ['title' => $title, 'items'=> []];

        foreach ($items as $item)
        {
            $url = $parent_url . $item['slug'];
            if($active_slug && $active_slug === $item['slug'] ){
                $active = true;
            }
            else {
                $active = false;
            }
            $link_title = $item['title'];
            $panel_item=[];
            $panel_item['title'] = $link_title;
            $panel_item['url'] = $url;
            $panel_item['active'] = $active;
            array_push($sidebar_panel['items'], $panel_item );
        }
        return $sidebar_panel;
    }
    public function makeCatPanel($items, $title, $parent_url, $active_slug = null)
    {

    }
}
