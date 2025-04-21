<?php

namespace App\Models;

use Core\Model;

use PDO;

class AuthModel extends Model
{
    // Add a new user to the database.
    public function addUser($user_id, $name, $username, $email, $password_hash)
    {
        $stmt = $this->db->prepare("INSERT INTO users (user_id, name, username, email, password_hash)
        VALUES (:user_id, :name, :username, :email, :password_hash)");
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password_hash', $password_hash);
        $stmt->execute();
    }

    // Search for user in the database using user_id.
    public function searchUser($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :user_id LIMIT 1");
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?? null;
    }

    // Search for user in the database using username.
    public function searchUserByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindValue(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?? null;
    }

    // Search for user in the database using email.
    public function searchUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?? null;
    }

    // Save user_id, name, username avatar and type in a new session.
    public function startSession($user)
    {
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'user_id' => $user['user_id'] ?? null,
            'name' => $user['name'] ?? null,
            'username' => $user['username'] ?? null,
            'avatar' => $user['avatar'] ?? '/assets/default_avatar.jpg'
        ];
    }

    // Keep user logged in even after the browser is closed.
    public function rememberSession($user_id)
    {
        // Will be added soon
    }

    // Check if the input is 3 to 100 characters long and contains only letters (from any language) or spaces.
    public function isValidName($name): bool
    {
        $regex = '/^[\p{L}\s]{3,100}$/u';
        return preg_match($regex, $name);
    }

    // Check if the input is 3 to 30 characters long and contains only lowercase letters, numbers or underscores.
    public function isValidUsername($username): bool
    {
        $reserved = require __DIR__ . '/../../config/reserved_usernames.php';
        $regex = '/^[a-z0-9_]{3,30}$/';
        return preg_match($regex, $username) && !in_array(strtolower($username), $reserved);
    }

    // Check if the input is a valid email address.
    public function isValidEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // Check if the username is already in the database.
    public function isUsernameAlreadyInUse($username): bool
    {
        return (bool) $this->searchUserByUsername($username);
    }

    // Check if the email is already in the database.
    public function isEmailAlreadyInUse($email): bool
    {
        return (bool) $this->searchUserByEmail($email);
    }

    // Check if it the input has at least 8 characters, one uppercase letter, one lowercase letter, one number and one special character.
    public function isValidPassword($password): bool
    {
        $regex = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
        return preg_match($regex, $password);
    }

    // Check if the password matches with the password_hash.
    public function matchPassword($password, $password_hash)
    {
        return password_verify($password, $password_hash);
    }

    // Validate the login form and start a session if the credentials are correct.
    public function login($email_or_username, $password, $remember)
    {
        if (!$email_or_username || !$password)
        {
            return ['error' => 'Email/Username and password are required.'];
        }

        if ($this->isValidEmail($email_or_username))
        {
            $user = $this->searchUserByEmail($email_or_username) ?? null;

            if (!$user)
            {
                return ['error' => "Email \"$email_or_username\" not found."];
            }
        } elseif ($this->isValidUsername($email_or_username))
        {
            $user = $this->searchUserByUsername($email_or_username) ?? null;

            if (!$user)
            {
                return ['error' => "Username \"$email_or_username\" not found."];
            }
        } else
        {
            return ['error' => 'Invalid credentials.'];
        }

        if ($this->matchPassword($password, $user['password_hash']))
        {
            $this->startSession($user);

            if ($remember)
            {
                $this->rememberSession($user['user_id']);
            }

            return;
        }

        return['error' => 'Invalid credentials.'];
    }

    // Validate the signup form and save the user in the database.
    public function signup($name, $username, $email, $password, $confirm_password, $agree)
    {
        if (!$name || !$username || !$email || !$password || !$confirm_password || !$agree) {
            return ['error' => 'All fields are required and terms must be accepted.'];
        }

        if ($password !== $confirm_password) {
            return ['error' => 'Passwords do not match.'];
        }

        if (!$this->isValidName($name)) {
            return ['error' => 'Invalid name.'];
        }

        if (!$this->isValidUsername($username)) {
            return ['error' => 'Invalid username.'];
        }

        if (!$this->isValidEmail($email)) {
            return ['error' => 'Invalid email.'];
        }

        if (!$this->isValidPassword($password)) {
            return ['error' => 'Weak password.'];
        }

        if ($this->isUsernameAlreadyInUse($username)) {
                return ['error' => 'Username already in use.'];
        }

        if ($this->isEmailAlreadyInUse($email)) {
            return ['error' => 'Email already in use.'];
        }

        try
        {
            $user_id = random_bytes(16);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $this->addUser($user_id, $name, $username, $email, $password_hash);

            $user = $this->searchUser($user_id);

            $this->startSession($user);
            $this->rememberSession($user['user_id']);

            return;
        }
        catch (\Exception $e)
        {
            return ['error' => 'An error occurred while creating your account.'];
        }
    }

    // End the session.
    public function logout()
    {
        session_destroy();
    }
}