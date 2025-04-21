<?php

namespace App\Controllers;

use Core\Controller;

use Core\Helpers;
use App\Models\AuthModel;

class LoginController extends Controller
{
    public function __construct(private AuthModel $authModel)
    {
    }

    public function index()
    {
        if (Helpers::isLoggedIn()) {
            header('Location: /');
            return;
        }
        
        $this->view([
            'view' => 'login',
            'title' => 'Log In'
        ]);
    }

    public function login()
    {
        $email_or_username = trim($_POST['email_or_username']) ?? null;
        $password = $_POST['password'] ?? null;
        $remember = isset($_POST['remember']);

        $login = $this->authModel->login($email_or_username, $password, $remember) ?? null;

        if (isset($login['error'])) {
            $this->view([
                'view' => 'login',
                'title' => 'Log In',
                'error' => $login['error'],
                'email_or_username' => $email_or_username
            ]);

            return;
        }

        $this->view([
            'view' => 'home',
            'title' => 'Home - Essential Reads'
        ], ['menu', 'content']
        );
    }
}