<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Account\StudentAccount;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PromoCodeController extends Controller
{
    public function handlePromoCode(Request $request)
    {

        $request->validate([
            'name'=>['required', 'exists:promo_codes',
                function ($attribute, $value, $fail) use ($request) {
                $exists = PromoCode::where('name', $request->get('name')) -> whereHas('studentAccounts', function ($q) use ($request) {
                    $q->where('student_id', $request->get('id'));
                })->exists();

                if($exists) {
                    $fail('Данный промокод уже использован');
                }
        },function ($attribute, $value, $fail) use ($request) {
                   $promo_code  = PromoCode::where('name', $request->get('name')) ->first();

                    if($promo_code->max_count < 1) {
                        $fail('Данный промокод не может больше  использоваться');
                    }
                }, function ($attribute, $value, $fail) use ($request) {
                    $promo_code  = PromoCode::where('name', $request->get('name')) ->first();
                    $date1 = Carbon::parse(date('Y-m-d'));
                    $date2 = Carbon::parse(date('Y-m-d', strtotime($promo_code->end_time)));
                    if($date1< $date2) {
                        $fail('Данный промокод не может больше  использоваться');
                    }
                }, function ($attribute, $value, $fail) use ($request) {
                    $promo_code  = PromoCode::where('name', $request->get('name')) ->first();
                    $date1 = Carbon::parse(date('Y-m-d'));
                    $date2 = Carbon::parse(date('Y-m-d', strtotime($promo_code->start_time)));
                    if($date2 > $date1) {
                        $fail('Данный промокод не может   использоваться');
                    }
                },  ]],  [
            'name.required' => 'Введите промокод',
            'name.exists' => 'Промокод не найден'
        ]);
       $student_account = StudentAccount::findOrFail($request->get('id'));
       $promo_code = PromoCode::where('name', $request->get('name'))->firstOrFail();
       $student_account -> promoCodes() -> attach($promo_code);
       $promo_code -> max_count =  $promo_code -> max_count - 1;
       $promo_code -> save();
       $student_account  -> promo_balance = $student_account  -> promo_balance + $promo_code->sum;
       $student_account -> save();
       return $student_account->promo_balance;
    }

}
