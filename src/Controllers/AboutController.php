<?php

namespace App\Controllers;

use Core\Controller;

class AboutController extends Controller
{
    public function index()
    {
        $this->view([
            'view' => 'about',
            'title' => 'About Us - Essential Reads'
        ]);
    }
}