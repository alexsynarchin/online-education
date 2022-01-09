<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

    }

    public function update()
    {

    }

    public function selectProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $profile_type = $request->get('profile_type');

        if($profile_type === 'teacher') {
            $user->assignRole('teacher');
            $user ->teacherAccount() -> create();
        }
        if($profile_type === 'student') {
            $user->assignRole('student');
            $user -> studentAccount() -> create();
        }
        return 'success';
    }

    public function updateEmail($id, Request $request)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'email' => 'required|email|unique:users',
        ]);
        $user -> email = $request->get('email');
        $user -> email_verified_at = null;
        $user -> save();
       // $user->sendEmailVerificationNotification();
        return $user -> email;
    }
}
