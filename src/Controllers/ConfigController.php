<?php

namespace App\Controllers;

use Core\Controller;

use Core\Helpers;

class ConfigController extends Controller
{
    public function index()
    {
        $name = Helpers::name();

        $this->view([
            'view' => 'config',
            'title' => "$name - Configuration"
        ]);
    }
}