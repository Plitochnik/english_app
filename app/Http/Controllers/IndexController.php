<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function parameters()
    {
        return inertia('Form/ParamForm');
    }

    public function signin()
    {
        return inertia('Register/Sign-In');
    }

    public function testProcess()
    {
        return inertia('Test/Test');
    }


}
