<?php

namespace App\Controllers;

use Core\Controller;

use App\Models\AuthModel;

class LogoutController extends Controller
{
    public function __construct(private AuthModel $authModel)
    {
    }

    public function logout()
    {
        $this->authModel->logout();;

        header('Location: /login');
    }
}