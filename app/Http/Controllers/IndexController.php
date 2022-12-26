<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function parameters()
    {
        if (isset(Auth::user()->name)) {
            $user_name = Auth::user()->name;
        } else {
            $user_name = 0;
        }

        return inertia('Form/ParamForm', compact('user_name'));
    }

    public function profile()
    {
        return inertia('UserProfile/Profile');
    }

}
