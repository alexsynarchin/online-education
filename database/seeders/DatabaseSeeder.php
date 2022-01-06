<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            EduTypesSeeder::class,
            SubjectsSeeder::class,
            EduLevelsSeeder::class,
            RolesSeeder::class,
            UsersSeeder::class,
            EduInstitutionSeeder::class,
            TeacherEduInstutionAttach::class,
        ]);
    }
}
