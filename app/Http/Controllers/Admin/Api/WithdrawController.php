<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function index()
    {
        $withdraws = Withdraw::where('done', 0)->with('teacher', function ($query){
            $query->with('teacherAccount');
        }) ->get();
        return $withdraws;
    }

    public function done(Request $request)
    {
        $moderator = \Auth::user();
        $withdraw = Withdraw::findOrFail($request->get('id'));
        $withdraw->moderator_id = $moderator->id;
        $withdraw->done = 1;
        $withdraw->save();
        return $moderator;
    }
}
