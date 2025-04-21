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

    public static function getImage($label, $filename)
    {
        $error_msg = 'Invalid image request.';

        $filename = basename(urldecode($filename));

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array(strtolower($extension), $allowed_extensions)) {
            http_response_code(400);
            echo $error_msg;
            return;
        }

        if ($label === 'avatar') {
            $base_dir = realpath(__DIR__ . '/../uploads/avatar');
        } elseif ($label === 'cover') {
            $base_dir = realpath(__DIR__ . '/../uploads/cover');
        } else {
            http_response_code(400);
            echo $error_msg;
            return;
        }

        $path = realpath($base_dir . '/' . $filename);
        if (!$path || strpos($path, $base_dir) !== 0 || !file_exists($path)) {
            http_response_code(404);
            echo $error_msg;
            return;
        }

        $mime_type = mime_content_type($path);
        $valid_mime_types = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($mime_type, $valid_mime_types)) {
            http_response_code(400);
            echo $error_msg;
            return;
        }

        header('Content-Type: ' . $mime_type);
        header('Cache-Control: public, max-age=3600');
        readfile($path);
    }
}