<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if($request->get('url')) {
                return $request->get('url') . '?comment=show';
            } else {
                if(!(Auth::user()->phone_confirmation)) {
                    return route('dashboard');
                } else if(Auth::user()->profile_type === 'teacher') {
                    return route('profile.course.index', ['type' => 'moderate']);
                } else if (Auth::user()->profile_type === 'student') {
                    return route('profile.education');
                }
            }

            //return redirect()->intended('dashboard');
        }
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return route('home');
    }
}
