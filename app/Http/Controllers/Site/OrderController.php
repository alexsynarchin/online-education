<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function success(Request $request)
    {
        dd($request->all());
    }

    public function fail(Request $request)
    {
        dd($request->all());
    }
}
