<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Swoole\WebSocket\Server;


class IndexController extends Controller
{
    public function getUserStatus()
    {
        if (isset(Auth::user()->name)) {
            $user_name = Auth::user()->name;
        } else {
            $user_name = 0;
        }

        return $user_name;
    }

    public function home()
    {
        $user_name = $this->getUserStatus();

        return inertia('Form/ParamForm', compact('user_name'));
    }

    public function testProcess()
    {
        return inertia('Test/Test');
    }

    public function tableTest()
    {
        return Inertia::render('TableTest');
    }

}
