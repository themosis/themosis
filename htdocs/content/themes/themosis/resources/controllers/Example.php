<?php

namespace Theme\Controllers;

use Themosis\Route\BaseController;

class Example extends BaseController
{
    public function index()
    {
        return view('welcome');
    }
}
