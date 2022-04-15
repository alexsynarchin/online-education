<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestResultController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        return $user;
    }
}
