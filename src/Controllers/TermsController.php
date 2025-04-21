<?php

namespace App\Controllers;

use Core\Controller;

class TermsController extends Controller
{
    public function index()
    {
        $this->view([
            'view' => 'terms',
            'title' => 'Terms of Service - Essential Reads'
        ]);
    }
}