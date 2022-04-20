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
        $teacher_account= $user->teacherAccount;
        $teacher_account->card_number = $request->get('card_number');
        $teacher_account->save();
        $withdraw = Withdraw::create([
            'teacher_id' => $user->id,
            'sum' => $request->get('sum')
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
