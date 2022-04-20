<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $user= \Auth::user();
        $student = $user->studentAccount;
        $orders = Order::where('student_id', $student->id) -> get();
        return $orders;
    }
}
