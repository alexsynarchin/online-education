<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class EduLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class = 'класс';
        $slug = 'class';
        $edu_type_id = 1;
        $level = 11;
        $levels = [];
        for ($i = 1; $i <= $level; $i++){
            $data = [
                'title' => $i . ' ' . $class,
                'slug' => $i . '-' .$slug,
                'type' => 'edu_level',
                'parent_id' => $edu_type_id
            ];
            array_push($levels, $data);
        }
        DB::table('category_types') ->insert($levels);
        $class = 'курс';
        $slug = 'course';
        $edu_type_id = 2;
        $level = 4;
        $levels = [];
        for ($i = 1; $i <= $level; $i++){
            $data = [
                'title' => $i . ' ' . $class,
                'slug' => $i . '-' .$slug,
                'type' => 'edu_level',
                'parent_id' => $edu_type_id
            ];
            array_push($levels, $data);
        }
        DB::table('category_types') ->insert($levels);
        $class = 'курс';
        $slug = 'course';
        $edu_type_id = 3;
        $level = 5;
        $levels = [];
        for ($i = 1; $i <= $level; $i++){
            $data = [
                'title' => $i . ' ' . $class,
                'slug' => $i . '-' .$slug,
                'type' => 'edu_level',
                'parent_id' => $edu_type_id
            ];
            array_push($levels, $data);
        }
        DB::table('category_types') ->insert($levels);
    }
}
