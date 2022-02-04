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
            $title = $course -> title;
            $price = $course->price;
            $id = $course->id;
        } else {
            $lesson = Lesson::findOrFail($request->get('id'));
            $title = $lesson -> title;
            $price = $lesson->price? $lesson->price : $lesson->price_user;
            $id = $lesson->id;
        }
        return [
            'id' => $id,
            'type' => $request->get('type'),
            'price' => $price,
            'title' => $title,
            'account_id' => $student_account->id,
            'promo_balance' => $student_account->promo_balance ? $student_account->promo_balance : 0,
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
            $order->sum = $request->get('discount_price');
            $order ->save();
            $mrh_login = "educall";
            $mrh_pass1 = "a69DD4YRP5tkcZ0zrcRf";
            $inv_id = $order->id;
            $inv_desc = "Оплата за обучение";
            $out_summ = $order->sum;
            $IsTest = 1;
            $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");
            $url = 'https://auth.robokassa.ru/Merchant/Index.aspx?';
            redirect()->to($url .'MerchantLogin='.$mrh_login .'&OutSum='.$out_summ.'&InvoiceID='.$inv_id.'&Description='.$inv_desc.'&SignatureValue='.$crc.'&IsTest='.$IsTest);
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
