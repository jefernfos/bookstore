<?php

namespace App\Controllers;

use Core\Controller;

use Core\Helpers;
use App\Models\AuthModel;

class SignupController extends Controller
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
            'view' => 'signup',
            'title' => 'Sign Up'
        ]);
    }

    public function signup()
    {
        $name = trim($_POST['name']) ?? null;
        $username = trim($_POST['username']) ?? null;
        $email = trim($_POST['email']) ?? null;
        $password = $_POST['password'] ?? null;
        $confirm_password = $_POST['confirm_password'] ?? null;
        $agree = isset($_POST['agree']);

        $signup = $this->authModel->signup($name, $username, $email, $password, $confirm_password, $agree) ?? null;

        if (isset($signup['error'])) {
            $this->view([
                'view' => 'signup',
                'title' => 'Sign Up',
                'error' => $signup['error'],
                'name' => $name,
                'username' => $username,
                'email' => $email
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