<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherEduInstutionAttach extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacher = User::find(2);
        $teacher -> eduInstitutions() -> attach(1, ['type' => 'work']);
    }
}
