<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function withdraw(Request $request)
    {
        $user = User::findOrFail($request->get('user_id'));
        $withdraw = $request->get('withdraw_sum');
        $withdraw_percent = ($withdraw / 100) * 25;
        $withdraw_sum = $withdraw - $withdraw_percent;
        $teacher_account= $user->teacherAccount;
        $teacher_account->card_number = $request->get('card_number');
        $balance = 0;
        $promo_balance = 0;
        if($teacher_account->promo_balance > $withdraw * 0.25) {
            $promo_balance = $withdraw * 0.25;
        } else {
            $promo_balance = $teacher_account->promo_balance;
        }
        $balance = $withdraw - (int) $promo_balance;
       // $teacher_account->save();
        $withdraw = Withdraw::create([
            'teacher_id' => $user->id,
            'sum' => $withdraw_sum,
            'balance' => $balance,
            'promo_balance' => $promo_balance,
        ]);
        return $request->all();
    }
    public function list()
    {
        $user = \Auth::user();
        $withdraws = Withdraw::where('teacher_id', $user->id) -> get();
        return $withdraws;
    }
}
