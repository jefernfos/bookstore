<?php

namespace Core;

class Helpers
{
    // Returns user user_id (binary version).
    public static function user_id()
    {
        return $_SESSION['user']['user_id'] ?? null;
    }

    // Returns user user_id (hexadecimal version).
    public static function user_id_readable()
    {
        return bin2hex(self::user_id()) ?? null;
    }

    // Returns user name.
    public static function name()
    {
        return $_SESSION['user']['name'] ?? null;
    }

    // Returns user username.
    public static function username()
    {
        return $_SESSION['user']['username'] ?? null;
    }

    // Returns user avatar.
    public static function avatar()
    {
        return $_SESSION['user']['avatar'] ?? '/assets/default_avatar.jpg';
    }

    // Check if the user is logged in.
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    // Check if the current user is a administrator from the database.
    public static function isAdmin(): bool
    {
        global $container;
        return self::isLoggedIn() && $container->get(\App\Models\AuthModel::class)->searchUser(self::user_id())['type'] === 'admin';
    }
}