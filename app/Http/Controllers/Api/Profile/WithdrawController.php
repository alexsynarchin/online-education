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
        $withdraw_sum = $request->get('withdraw_sum');
        $teacher_account= $user->teacherAccount;
        $teacher_account->card_number = $request->get('card_number');
        if($teacher_account->balance < $withdraw_sum) {
            $withdraw_sum = $withdraw_sum - $teacher_account->balance;
            $teacher_account->balance = 0;
            $teacher_account->promo_balance = $teacher_account->promo_balance - $withdraw_sum;
        } else {
            $teacher_account->balance = $teacher_account->balance - $withdraw_sum;
        }
        $teacher_account->save();
        $withdraw = Withdraw::create([
            'teacher_id' => $user->id,
            'sum' => $request->get('withdraw_sum')
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
