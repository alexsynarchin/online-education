<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = (new User) -> newQuery();
        if($request->has('type')) {
            $users = $users -> whereHas('roles', function ($query) use ($request){
                $query->where('name',$request->get('type'));
            });
        }
        $users = $users ->get();
        return $users;
    }
}
