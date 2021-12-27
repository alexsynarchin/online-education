<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function account()
    {
        $account='';
        if(Auth::user() -> profile_type == 'teacher') {
               $account = Auth::user() -> teacherAccount;
        }
        if(Auth::user() -> profile_type == 'student') {
            $account = Auth::user() -> studentAccount;
        }
        return $account;
    }
}
