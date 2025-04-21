<?php

namespace Core;

abstract class Controller
{
    protected function view($data = [], $ajax = ['content'])
    {
        // Handle the view for AJAX requests.
        if ($this->isAJAX()) {;
            $partials = [];

            if (in_array('content', $ajax))
            {
                ob_start();
                View::render($data, 'content');
                $content = ob_get_clean();
            }

            if (in_array('menu', $ajax))
            {
                ob_start();
                View::render($data, 'menu');
                $partials['menu'] = ob_get_clean();
            }

            header('Content-type:application/json');
            echo json_encode([
                'title' => $data['title'] ?? null,
                'content' => $content ?? null,
                'partials' => $partials ?? null,
            ]);

            return;
        }

        // Handle the view for normal requests.
        View::render($data);
    }

    // Check if the request is an AJAX request.
    private function isAJAX(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}