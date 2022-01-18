<?php

namespace Database\Seeders;

use App\Models\Reference\City;
use App\Models\Reference\EduInstitution;
use Illuminate\Database\Seeder;

class EduInstitutionSeeder extends Seeder
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
                'title' => 'УГНТУ',
                'type' => 'university',
                'city_id' => 1,
            ],
            [
                'title' => 'БашГУ',
                'type' => 'university',
                'city_id' => 1,
            ],
            [
                'title' => 'Гимназия №3',
                'type' => 'school',
                'city_id' => 1,
            ],
            [
                'title' => 'Гимназия №39',
                'type' => 'school',
                'city_id' => 1,
            ],
            [
                'title' => 'школа № 61',
                'type' => 'school',
                'city_id' => 1,
            ],
            [
                'title' => 'школа № 109',
                'type' => 'school',
                'city_id' => 1,
            ],
            [
                'title' => 'Лицей №58',
                'type' => 'school',
                'city_id' => 1,
            ],
            [
                'title' => 'Лицей №106',
                'type' => 'school',
                'city_id' => 1,
            ],
            [
                'title' => 'Лицей №153',
                'type' => 'school',
                'city_id' => 1,
            ],
        ];
        foreach ($edu_institutions as $item) {
            EduInstitution::create($item);
        }
    }
}
