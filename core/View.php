<?php

namespace Core;

abstract class View
{
    public static function render($data = [], $ajax = null)
    {
        extract($data);

        // Render only the content for AJAX requests.
        if ($ajax === 'content') {
            include __DIR__ . '/../src/views/' . $view . '.php';
            return;
        }

        if ($ajax === 'menu') {
            include_once __DIR__ . '/../src/views/partials/menu.php';
            return;
        }

        // Render the full layout (header, content, footer) for normal requests.
        include_once __DIR__ . '/../src/views/partials/header.php';
        include_once __DIR__ . '/../src/views/' . $view . '.php';
        include_once __DIR__ . '/../src/views/partials/footer.php';
    }
}