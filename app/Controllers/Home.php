<?php

namespace App\Controllers;
srsdhs
class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
}
