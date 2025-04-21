<?php

namespace App\Controllers;

use Core\Controller;

use App\Models\EbookModel;

class EbooksController extends Controller
{
    public function __construct(private EbookModel $ebookModel)
    {
    }

    public function index()
    {
        $ebooks = $this->ebookModel->getAllEbooks();

        $this->view([
            'view' => 'ebooks',
            'title' => 'Ebooks - Essential Reads',
            'ebooks' => $ebooks,
        ]);
    }
}