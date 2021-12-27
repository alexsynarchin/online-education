<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class EduTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $edu_types = [
            [
                'title' => 'Школьное образование',
                'slug' => 'school-education',
                'type' => 'edu_type',
            ],
            [
                'title' => 'Среднее образование',
                'slug' => 'secondary-special',
                'type' => 'edu_type'
            ],
            [
                'title' => 'Высшее образование',
                'slug' => 'higher-education',
                'type' => 'edu_type'
            ],
            [
                'title' => 'Профильные курсы',
                'slug' => 'additional-education',
                'type' => 'edu_type'
            ],
        ];
        DB::table('category_types') ->insert($edu_types);
    }
}
