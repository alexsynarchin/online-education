<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdditionalRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = Role::create(['name' => 'super-admin']);
        $moderator = Role::create(['name' => 'moderator']);
        $admin = User::findOrFail(1);
        $admin->assignRole($super_admin);
    }
}
