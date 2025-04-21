<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view([
            'view' => 'home',
            'title' => 'Home - Essential Reads'
        ]);
    }
}