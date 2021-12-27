<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
            'profile_type' => ['required','in:student,teacher'],
        ]);
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'surname' => $data['surname'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole($data['profile_type']);
        if($data['profile_type'] === 'teacher'){
            $teacher = $user->teacherAccount()->create();
        }
        if($data['profile_type'] === 'student') {
            $student = $user->studentAccount()->create();
        }
        Auth::login($user, true);
        //dd(Auth::user());
        $request->session()->regenerate();
        return $user;
    }
}
