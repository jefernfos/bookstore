<?php

namespace App\Controllers;

use Core\Controller;

class MyLibraryController extends Controller
{
    public function index()
    {
        $this->view([
            'view' => 'mylibrary',
            'title' => 'My Library - Essential Reads'
        ]);
    }
}