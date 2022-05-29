<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Hash;
class RestorePasswordController extends Controller
{
    public function sendCode(Request $request, $type)
    {
        if($type === 'phone') {

            $request->validate([
                'phone' => ['required',  function ($attribute, $value, $fail) use($request) {
                $exists = User::where('phone', $request->get('phone')) -> exists();
                    if (!$exists) {
                        $fail('Пользователь с таким номер телефона не существует');
                    }
                },],
            ], [
                'phone.required' => 'Введите номер телефона'
            ]);
            $user = User::where('phone', $request->get('phone')) -> firstOrFail();
            $phone = preg_replace('/[^0-9]/', '', $request->get('phone'));
            $LOGIN ="black656";
            $PASSWORD = "pioner1468006";
            //https://smsc.ru/sys/send.php?login=black656&psw=pioner1468006&phones=+79174939476&mes=code&call=1
            $client = new \GuzzleHttp\Client();
            if($request->get('voice') === 1) {
                $url = 'https://smsc.ru/sys/send.php?login=black656&psw=pioner1468006&phones=' . $phone . '&mes=' . $request->get('code'). '&call=1&fmt=3';
            } else {
                $url = 'https://smsc.ru/sys/send.php?login=black656&psw=pioner1468006&phones=' . $phone . '&mes=code&call=1&fmt=3';
            }
            $response = $client->request('POST', $url);
            return [
                'result' => json_decode($response->getBody()),
                'user_id' => $user ->id
            ];
        }
        if($type === 'email') {
            $request->validate([
                'email' => ['required',  function ($attribute, $value, $fail) use($request) {
                    $exists = User::where('email', $request->get('email')) -> exists();
                    if (!$exists) {
                        $fail('Пользователь с таким e-mail не существует');
                    }
                },],
            ], [
                'email.required' => 'Введите e-mail'
            ]);
            $user = User::where('phone', $request->get('phone')) -> firstOrFail();
            $numbers = array(
                '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
            );

            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $code .= $numbers[random_int(0, count($numbers) - 1)];
            }
            Mail::to($request->get('email'))->send(new SendCodeMail(['code' => $code]));
            return [
                'code' => $code,
                'user_id' => $user->id
            ];
        }
    }


    public function confirmCode(Request $request, $type)
    {
        if($type === 'phone') {
            $code = $request->get('phoneCode');
            $request->validate([
                'check_code' => ['required',
                    function ($attribute, $value, $fail) use ($code) {
                        if ($value != $code) {
                            $fail('Код подтверждения не совпадает');
                        }
                    },]
            ],
                [
                    'check_code.required' => 'Введите код подтверждения'
                ]);
            return  true;
        }
        if($type === 'email') {
            $code = $request->get('emailCode');
            $request->validate([
                'check_code' => ['required',
                    function ($attribute, $value, $fail) use ($code) {
                        if ($value != $code) {
                            $fail('Код подтверждения не совпадает');
                        }
                    },]
            ],
                [
                    'check_code.required' => 'Введите код подтверждения'
                ]);
            return true;
        }
        return false;
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password.required' => 'Введите пароль',
            'password.min' => 'Минимальная длина пароля 6 символов',
            'password.confirmed' => 'Пароль и подтверждение пароля не совпадают',
        ]);
        $user = User::findOrFail($request->get('user_id'));
        $user -> password = Hash::make($request->get('password'));
        $user->save();
        return 'success';
    }
}
