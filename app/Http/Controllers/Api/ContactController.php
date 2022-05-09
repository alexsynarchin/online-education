<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactEmail;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contact(Request $request)
    {
        $request->validate([
            'theme' => 'required',
            'name'=> 'required',
            'email' => 'required|email:rfc,dns',
            'type' => 'required',
            'text' => 'required',
        ],
        [
            'theme.required' => 'Заполните тему обращения',
            'type.required' => 'Выберите тип профиля',
            'name.required' => 'Введите ваше имя',
            'email.required' => 'Введите ваш e-mail',
            'text.required' => 'Введите текст обращения'
        ]
        );
        $form = $request->all();
        $exists= Setting::where('group', 'common')->where('name','email')->exists();
        if($exists) {
            $setting = Setting::where('group', 'common')->where('name','email') ->firstOrFail();
            $email = $setting -> value;
            $email = explode(',', $email);
        } else {
            $email = ['educall@mail.ru'];
        }
        foreach ($email as $recipient) {
            Mail::to($recipient)->send(new ContactEmail($form));
        }
        return $request->all();
    }
}
