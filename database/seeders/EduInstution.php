<?php

namespace Database\Seeders;

use App\Models\Reference\City;
use App\Models\Reference\EduInstitution;
use Illuminate\Database\Seeder;

class EduInstution extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $city = [
            'title' => 'Уфа',
            'slug' => 'ufa'
        ];
        $city = City::create($city);
        $edu_institutions = [
            [
                'title' => 'УГАТУ',
                'type' => 'university',
                'city_id' => 1,
            ],
            [
                'title' => 'Гимназия №3',
                'type' => 'school',
                'city_id' => 1,
            ]
        ];
        foreach ($edu_institutions as $item) {
            EduInstitution::create($item);
        }
    }
}
