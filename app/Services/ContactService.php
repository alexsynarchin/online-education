<?php


namespace App\Services;
use Validator;
use Mail;

class ContactService
{

    public function index($data){
        $validator = $this->validator($data);
        $validator->validate();

        return response()->json(['success'=>'Сообщение отправлено. Мы обязательно с вами свяжемся' ]);

    }
    public function validator($data){
        $rules = [
            'email'     => 'required|email|max:255',
            'name' => 'required|max:255',
            'message'  => 'required',
        ];
        return Validator::make($data, $rules);
    }
}
