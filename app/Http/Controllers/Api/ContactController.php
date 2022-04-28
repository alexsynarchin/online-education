<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return $request->all();
    }
}
