<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function success(Request $request)
    {
        $order = Order::findOrFail($request->get('InvId'));
        dd($request->all());
    }

    public function fail(Request $request)
    {
        dd($request->all());
    }
}
