<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function index()
    {

    }

    public function show()
    {
        if(Auth::user() -> hasRole('teacher')) {
            $user = User::with(['eduInstitutions', 'teacherAccount']) ->find(Auth::id());
            foreach ($user -> eduInstitutions as $item) {
                $item->main = $item->pivot->main;
            }
        }
        else if(Auth::user() -> hasRole('student')) {
            $user = User::with('studentAccount') ->find(Auth::id());
        } else {
            $user = User::find(Auth::id());
        }

        return $user;
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user ->update($request->except('teacher_account', 'student_account', 'edu_institutions'));
        if($user->city()->exists()) {
            $city = $user->city()->first();
            $user -> city = $city->title;
            $user->save();
        }
        if($request -> has('imageName')) {
            $user ->addMediaFromBase64($request->get('avatar'))
                ->toMediaCollection('users');
        }
        if($request->has('edu_institutions')) {
            $edu_institutions_ids=[];
            foreach ($request->get('edu_institutions') as $item) {
                $edu_institutions_ids[$item['id']] = ['main' =>$item['main'] ?? false, 'type' =>'work'];
            }

            $user -> eduInstitutions() -> sync($edu_institutions_ids);
        }
        return $user -> id;

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
