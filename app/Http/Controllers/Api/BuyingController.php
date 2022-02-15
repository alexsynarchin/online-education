<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\BuyService;
use App\Models\Category\Course;
use App\Models\Lesson\Lesson;
use App\Models\Order;
use Illuminate\Http\Request;

class BuyingController extends Controller
{
    public function getData(Request $request)
    {
        $student_account = \Auth::user()->studentAccount;
        if($request->get('type') === 'course') {
            $course = Course::findOrFail($request->get('id'));
            $preview = $course->image;
            $title = $course -> title;
            $price = $course->price;
            $id = $course->id;
            $edu_type_id = $course -> edu_type_id;
            $edu_type_title = 'Курс ';
        } else {
            $lesson = Lesson::findOrFail($request->get('id'));
            $title = $lesson -> title;
            $preview = $lesson -> course -> image;
            $edu_type_id = $lesson ->course -> edu_type_id;
            $price = $lesson->price? $lesson->price : $lesson->price_user;
            $id = $lesson->id;
            $edu_type_title = 'Урок ';
        }
        if($edu_type_id === 1) {
            $edu_type_title = $edu_type_title . 'школьного образования';
        }
        if($edu_type_id === 2) {
            $edu_type_title = $edu_type_title . 'среднего образования';
        }
        if($edu_type_id === 3) {
            $edu_type_title = $edu_type_title . 'высшего образования';
        }
        if($edu_type_id === 4) {
            $edu_type_title = $edu_type_title . 'дошкольного образования';
        }
        return [
            'id' => $id,
            'type' => $request->get('type'),
            'price' => $price,
            'title' => $title,
            'account_id' => $student_account->id,
            'promo_balance' => $student_account->promo_balance ? $student_account->promo_balance : 0,
            'edu_type_title' => $edu_type_title,
            'preview' => $preview
        ];
    }
    public function handleDiscount(Request $request)
    {
        $request -> validate([
            'discount' => ['numeric',
            function ($attribute, $value, $fail) use ($request) {
                if($request->get('discount') > $request->get('balance')) {
                    $fail('Не может быть больше суммы промо баланса');
                }
            }]
        ], [
            'discount.numeric' => 'Скидка должна быть числовым значением',
        ]);
       $discount_price = $request->get('price') - $request->get('discount');
       $promo_balance = \Auth::user()->studentAccount->promo_balance;
       $promo_balance = $promo_balance - $request->get('discount');
       return [
           'discount_price' => $discount_price,
           'promo_balance' => $promo_balance,
       ];
    }
    public function buy(Request $request, BuyService $buyService)
    {
        $url='';
        if($request->get('discount_price') === 0) {
           $url = $buyService->finishBuy($request);

        } else {

            $order = new Order();
            $order->status = 'wait';
            $order->student_id = \Auth::user()->studentAccount->id;
            $order->buying_id = $request->get('id');
            $order->sum = $request->get('discount_price');
            $order->type = $request->get('type');
            $order ->save();
            $mrh_login = "Educall";
            $mrh_pass1 = "a69DD4YRP5tkcZ0zrcRf";
            $inv_id = $order->id;
            $inv_desc = "Оплата за обучение";
            $out_summ = $order->sum;
            $IsTest = 1;
            $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");
            $url = 'https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin=' . $mrh_login . '&OutSum='.$out_summ .'&InvId='.$inv_id.'&Description='.$inv_desc.'&SignatureValue='.$crc.'&IsTest='.$IsTest;
            //redirect()->to($url .'MerchantLogin='.$mrh_login .'&OutSum='.$out_summ.'&InvoiceID='.$inv_id.'&Description='.$inv_desc.'&SignatureValue='.$crc.'&IsTest='.$IsTest);
            redirect($url);
        }
        return $url;
    }

    public function calculateDiscount(Request $request)
    {
        $price = 0;
        $student_account = \Auth::user()->studentAccount;
        if($request->get('price') > $request->get('promo_balance')) {
            $price =  $request->get('price') - $request->get('promo_balance');
            $promo_balance = 0;
        } else {
            $promo_balance = $request->get('promo_balance') - $request->get('price');
            $price = 0;
        }
        return [
            'price' => $price,
            'promo_balance' => $promo_balance,
        ];
    }
}
