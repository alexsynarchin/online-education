<?php


namespace App\Services\Admin;
use App\Models\Category\Category;
use Illuminate\Http\Request;

class AdminCategoryService
{
    public function prepareList($data){
        $edu_types = $data;
        $edu_types -> toArray();
        foreach ($edu_types as $edu_type) {
            $state = [
                'selectable' => false,

            ];
            $edu_type['state'] = $state;
            $data = [
                'folder'=>true
            ];
            $edu_type['data'] = $data;
            if($edu_type['categories'] -> count() > 0){
                $categories = $edu_type['categories'];
                $children = $this->buildTree($categories);
                $edu_type['children'] = $children;
            }
            unset($edu_type['categories']);
        }
        return $edu_types;
    }
    private function buildTree( &$elements, $parentId = null) {
        $branch = array();

        foreach ($elements as $element) {
            if($element['categorize_type'] == 'course_theme'){
                $state = [
                    'selectable' => true,
                ];
                $data =[
                    'folder' => false,
                    'id' => $element['categorize_id']
                ];
            } else{
                $state = [
                    'selectable' => false,
                ];
                $data =[
                    'folder' => true,
                    'id' => $element['id']
                ];
            }

            $element['data'] = $data;
            $element['state'] = $state;
            if ($element['parent_id'] == $parentId) {
                $element['title'] = $element['categorize']['title'];
                if($element['categorize_type'] == 'course_theme'){
                    $lessons = $element['categorize']['lessons'];
                    foreach ($lessons as $lesson){
                        $data = [
                            'id' => $lesson['id'],
                        ];
                        $lesson['data'] = $data;
                    }
                    $children = $lessons;
                }
                else{
                    $children = $this-> buildTree($elements, $element['id']);
                }
                if ($children) {
                    $element['children'] = $children;
                }
                unset($element['categorize']);
                array_push($branch, $element);
                unset($elements[$element['id']]);
            }
        }
        return $branch;
    }
    public function storeLevel($parent, $entity_id, $edu_type){
        $level_cat = new Category();
        $level_cat -> categorize_type = 'edu_level';
        $level_cat -> categorize_id = $entity_id;
        $level_cat -> parent_id = $parent;
        $level_cat -> edu_type_id = $edu_type;
        $level_cat -> save();
        return $level_cat;
    }
    public function storeSubject($entity_id,$edu_type)
    {
        $subject = new Category();
        $subject -> categorize_type = 'subject';
        $subject -> categorize_id = $entity_id;
        $subject -> edu_type_id = $edu_type;
        $subject -> save();
        return $subject;
    }
    public function storeCategory($parent, $entity_type, $entity_id, $edu_type)
    {
        $category = new Category();
        $category -> parent_id = $parent;
        $category -> categorize_type = $entity_type;
        $category -> categorize_id = $entity_id;
        $category ->  edu_type_id = $edu_type;
        $category -> save();
        return $category;
    }
}
