<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
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
