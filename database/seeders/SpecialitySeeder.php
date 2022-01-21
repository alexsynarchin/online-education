<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //specialty
        $specialities = [
            [
                'title' => 'Управление и экономика',
                'slug' => 'management-and-economics',
                'type' => 'specialty',
            ],
            [
                'title' => 'Гуманитарные и социальные науки',
                'slug' => 'humanities-and-social-sciences',
                'type' => 'specialty',
            ],
            [
                'title' => 'Информационные технологии',
                'slug' => 'information-technologies',
                'type' => 'specialty',
            ],
            [
                'title' => 'Техника и технологии',
                'slug' => 'technics-and-technologies',
                'type' => 'specialty',
            ],
        ];
        DB::table('category_types') ->insert($specialities);
    }
}
