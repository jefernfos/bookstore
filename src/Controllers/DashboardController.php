<?php

namespace App\Controllers;

use Core\Controller;

use Core\Helpers;
use App\Models\EbookModel;

class DashboardController extends Controller
{
    public function __construct(private EbookModel $ebookModel)
    {
    }

    public function index()
    {
        if (!Helpers::isAdmin())
        {
            header('Location: /404');
            return;
        }
        
        $this->view([
            'view' => 'dashboard',
            'title' => 'Admin Dashboard'
        ]);
    }

    public function create()
    {
        if (!Helpers::isAdmin())
        {
            header('Location: /404');
            return;
        }

        $ebook['slug'] = trim($_POST['slug']) ?? null;
        $ebook['title'] = trim($_POST['title']) ?? null;
        $ebook['subtitle'] = trim($_POST['subtitle']) ?? null;
        $ebook['author'] = trim($_POST['author']) ?? null;
        $ebook['publisher'] = trim($_POST['publisher']) ?? null;
        $ebook['price'] = trim($_POST['price']) ?? null;
        $ebook['pages'] = trim($_POST['pages']) ?? null;
        $ebook['year'] = trim($_POST['year']) ?? null;
        $ebook['language'] = trim($_POST['language']) ?? null;
        $ebook['description'] = trim($_POST['description']) ?? null;
        $ebook['file'] = $_FILES['file'] ?? null;
        $ebook['cover'] = $_FILES['cover'] ?? null;

        $create = $this->ebookModel->create($ebook) ?? null;

        if (isset($create['error'])) {
            $this->view([
                'view' => 'dashboard',
                'title' => 'Admin Dashboard',
                'error' => $create['error'],
                'ebook' => $ebook
            ]);

            return;
        }

        if (isset($create['success'])) {
            $this->view([
                'view' => 'dashboard',
                'title' => 'Admin Dashboard',
                'success' => $create['success']
            ]);

            return;
        }
    }
}