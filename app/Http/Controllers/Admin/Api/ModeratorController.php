<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ModeratorController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $moderator =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'surname' => $data['surname'],
            'last_name' => $data['last_name'],
            'password' => Hash::make($data['password']),
        ]);
        $role = Role::findByName('admin');
        $moderator->assignRole($role);
        return 'Модератор создан';
    }
}
