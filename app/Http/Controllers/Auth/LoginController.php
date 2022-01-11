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
                return route('dashboard');
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
