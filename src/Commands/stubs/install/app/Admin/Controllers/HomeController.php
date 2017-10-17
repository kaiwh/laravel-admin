<?php

namespace App\Admin\Controllers;

use Kaiwh\Admin\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin::home');
    }
}
