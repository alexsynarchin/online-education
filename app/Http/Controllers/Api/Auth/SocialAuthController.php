<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider, Request $request)
    {
        $resposne = Socialite::driver($provider) -> scopes(['email']);
        // with(['state' => 'test'])->
        $resposne = $resposne->redirect();
        return $resposne;
    }

    public function handleProviderCallback($provider, Request $request)
    {
        if ($request->session()->has('building_id')) {
            $building_id = $request->session()->get('building_id');
        }
        if ($provider == 'vkontakte') {
            $socialiteUser = Socialite::driver($provider)->fields([
                'photo', 'photo_big',
            ])->user();
            $email = $socialiteUser->accessTokenResponseBody['email'] ?? $socialiteUser->email;
            $socialiteUser->email = $email;
            $socialiteUser -> avatar = $socialiteUser->user['photo_big'];
        } else  if($provider == 'odnoklassniki') {
            $socialiteUser = Socialite::driver($provider)->stateless()->user();
            $email = $socialiteUser->accessTokenResponseBody['email'] ?? $socialiteUser->email;
            $socialiteUser->email = $email;
        } else if ($provider == 'facebook') {
            $socialiteUser = Socialite::driver($provider)->stateless()->user();
            $email = $socialiteUser->accessTokenResponseBody['email'] ?? $socialiteUser->email;
            $socialiteUser->email = $email;
        }
        //dd($socialiteUser);
        $user = $this->findOrCreateUser($provider, $socialiteUser);
        auth()->login($user, true);
        return redirect(route('dashboard'));
    }
    private function findOrCreateUser($provider, $socialiteUser)
    {
        if ($user = $this->findUserBySocialId($provider, $socialiteUser->getId())) {
            $user -> name = $socialiteUser -> name;
            $user -> save();
            $user -> addMediaFromUrl($socialiteUser -> avatar)->toMediaCollection('users');
            return $user;
        }
        if ($user = $this->findUserByEmail($provider, $socialiteUser->getEmail())) {
            $this->addSocialAccount($provider, $user, $socialiteUser);
            $user -> name = $socialiteUser -> name;
            $user -> save();
            $user -> addMediaFromUrl($socialiteUser -> avatar)->toMediaCollection('users');
            return $user;
        }
        if ($provider =='vkontakte' || 'odnoklassniki'){
            $user = User::create([
                'name' => $socialiteUser->name,
                'email' => $socialiteUser->email,
                'password' => bcrypt(Str::random(25)),
            ]);
            $user -> addMediaFromUrl($socialiteUser -> avatar)->toMediaCollection('users');
        } else {
            $user = User::create([
                'name' => $socialiteUser->name,
                'email' => $socialiteUser->email,
                'password' => bcrypt(Str::random(25)),
            ]);
        }
        $this->addSocialAccount($provider, $user, $socialiteUser);
        return $user;
    }
    private function findUserBySocialId($provider, $id)
    {
        $socialAccount = SocialAccount::where('provider', $provider)
            ->where('provider_id', $id)
            ->first();
        return $socialAccount ? $socialAccount->user : false;
    }
    private function findUserByEmail($provider, $email)
    {
        return !$email ? null : User::where('email', $email)->first();
    }
    private function addSocialAccount($provider, $user, $socialiteUser)
    {
        SocialAccount::create([
            'user_id' => $user->id,
            'provider' => $provider,
            'provider_id' => $socialiteUser->getId(),
            'token' => $socialiteUser->token,
        ]);
    }
}
