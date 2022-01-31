<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Validator;

class PromoCodeController extends Controller
{
    public function store(Request $request)
    {
        $messages = [
            'name.unique' => 'Промокод с таким значением уже существует',
        ];
        $rules = [
            'name' => 'required|unique:promo_codes',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();
        $start_date = date('Y-m-d H:i:s',  strtotime($request ->get('range')[0]));
        $end_date = date('Y-m-d H:i:s', strtotime($request ->get('range')[1]));
        $promo_code =new PromoCode();
        $promo_code -> name = $request->get('name');
        $promo_code -> start_time = $start_date;
        $promo_code -> end_time =$end_date;
        $promo_code -> max_count = $request -> get('max_count');
        $promo_code -> sum = $request -> get('sum');
        $promo_code -> save();
        return $start_date;
    }
    public function getList(){
        $list = PromoCode::all();
        return $list;
    }
}
