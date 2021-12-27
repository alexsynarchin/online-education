<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Филипп',
                'surname'=>'Преображенский',
                'last_name'=>'Филиппович',
                'gender' => '2',
                'email' => 'teacher@edu.ru',
                'password' => Hash::make('123'),
                'email_verified_at' => Carbon::now()
            ],
            [
                'name' => 'Иван',
                'surname'=>'Борменталь',
                'last_name'=>'Арнольдович',
                'gender' => '2',
                'email' => 'student@edu.ru',
                'password' => Hash::make('123'),
                'email_verified_at' => Carbon::now()
            ],
        ];
        DB::table('users') ->insert($users);
        $teacher= User::find(2);
        $student = User::find(3);
        $teacher->assignRole('teacher');
        $student->assignRole('student');
        $teacher -> teacherAccount() -> create();
        $student -> studentAccount() -> create();
    }
}
