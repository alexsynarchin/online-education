<?php


namespace App\Services;

use Auth;
class OrderService
{
    public function ordersList()
    {
        $orders = Auth::user()->orders() ->where('status','succeeded')->get();
        return $orders;
    }
}
