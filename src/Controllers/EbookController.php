<?php

namespace App\Controllers;

use Core\Controller;

use App\Models\EbookModel;

class EbookController extends Controller
{
    public function __construct(private EbookModel $ebookModel)
    {
    }

    public function index($args)
    {
        $slug = urldecode($args['id']) ?? null;

        if (!$slug || !$this->ebookModel->isValidSlug($slug)) {
            header('Location: /404');
            return;
        }

        $ebook = $this->ebookModel->getEbook($slug);

        if (!$ebook) {
            header('Location: /404');
            return;
        }

        $this->view([
            'view' => 'ebook',
            'title' => "{$ebook['title']} - Essential Reads",
            'ebook' => $ebook
        ]);
    }
}