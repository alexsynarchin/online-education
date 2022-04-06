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
    public function sidebarBalance()
    {
        $balance = 0;
        if(Auth::user() -> profile_type == 'teacher') {
            $balance = Auth::user()->teacherAccount -> balance;
            $promo_balance = Auth::user()->teacherAccount -> promo_balance;
            return [
              'balance' =>  (int) $balance,
              'promo_balance' => (int) $promo_balance
            ];
        }
        if(Auth::user() -> profile_type == 'student') {
            $balance = Auth::user() -> studentAccount -> promo_balance;
            return (int) $balance;
        }

    }
}
