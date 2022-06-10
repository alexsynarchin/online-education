<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        $withdraws = Withdraw::where('done', $request->get('done'))->with('teacher', function ($query){
            $query->with('teacherAccount');
        }) ->get();
        return $withdraws;
    }

    public function done(Request $request)
    {
        $moderator = \Auth::user();
        $withdraw = Withdraw::findOrFail($request->get('id'));
        $teacher = User::findOrFail($withdraw->teacher_id);
        $account = $teacher -> teacherAccount;
        $account->balance = $account->balance - $withdraw-> balance;
        $account-> promo_balance= $account->promo_balance - $withdraw->promo_balance;
        $account->save();
        $withdraw->moderator_id = $moderator->id;
        $withdraw->done = 1;
        $withdraw->save();
        return $moderator;
    }
}
