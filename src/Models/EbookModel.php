<?php

namespace App\Models;

use Core\Model;

use PDO;

class EbookModel extends Model
{
    public function addEbookDB($slug, $title, $subtitle, $author, $publisher, $price, $pages, $year, $language, $description, $file_name, $file_size, $file_path, $cover_path){
        $stmt = $this->db->prepare("INSERT INTO ebooks (slug, title, subtitle, author, publisher, price, pages, year, language, description, file_name, file_size, file_path, cover_path)
        VALUES (:slug, :title, :subtitle, :author, :publisher, :price, :pages, :year, :language, :description, :file_name, :file_size, :file_path, :cover_path)");
        $stmt->bindValue(':slug', $slug);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':subtitle', $subtitle);
        $stmt->bindValue(':author', $author);
        $stmt->bindValue(':publisher', $publisher);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':pages', $pages);
        $stmt->bindValue(':year', $year);
        $stmt->bindValue(':language', $language);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':file_name', $file_name);
        $stmt->bindValue(':file_size', $file_size);
        $stmt->bindValue(':file_path', $file_path);
        $stmt->bindValue(':cover_path', $cover_path);
        $stmt->execute();
    }

    public function getEbook($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM ebooks WHERE slug = :slug LIMIT 1");
        $stmt->bindValue(":slug", $slug);
        $stmt->execute();

        $ebook = $stmt->fetch(PDO::FETCH_ASSOC);

        return $ebook ?? null;
    }

    public function getAllEbooks()
    {
        $stmt = $this->db->prepare("SELECT * FROM ebooks");
        $stmt->execute();

        $ebooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $ebooks ?? null;
    }

    public function isValidSlug($slug)
    {
        $regex = '/^(?=.{3,100}$)[a-z0-9]+(?:-[a-z0-9]+)*$/';
        return preg_match($regex, $slug);
    }

    public function isSlugAlreadyInUse($slug)
    {
        return (bool) $this->getEbook($slug);
    }

    public function isValidTitle($title)
    {
        $regex = '/^[\p{L}\p{N}\s]{3,100}$/u';
        return preg_match($regex, $title);
    }

    public function isValidSubtitle($subtitle)
    {
        $regex = '/^[\p{L}\p{N}\s]{3,100}$/u';
        return preg_match($regex, $subtitle);
    }

    public function isValidPrice($price)
    {
        $regex = '/^\d{1,8}(\.\d{1,2})?$/';
        return preg_match($regex, $price) && $price >= 0 && $price <= 99999999.99;
    }

    public function isValidAuthor($author)
    {
        $regex = '/^[\p{L}\s]{3,100}$/u';
        return preg_match($regex, $author);
    }

    public function isValidPublisher($publisher)
    {
        $regex = '/^[\p{L}\s]{3,100}$/u';
        return preg_match($regex, $publisher);
    }

    public function isValidYear($year)
    {
        $regex = '/^\d{4}$/';
        return preg_match($regex, $year) && $year >= 1 && $year <= date('Y');
    }

    public function isValidPages($pages)
    {
        $regex = '/^\d{1,4}$/';
        return preg_match($regex, $pages) && $pages >= 1 && $pages <= 9999;
    }

    public function isValidLanguage($language)
    {
        $regex = '/^[\p{L}\s]{2,30}$/u';
        return preg_match($regex, $language);
    }

    public function isValidDescription($description)
    {
        $regex = '/^[\p{L}\p{N}\p{P}\p{S}\s\r\n]{100,9999}$/us';
        return preg_match($regex, $description);
    }

    public function isValidFile($file)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        
        $regex = '/^(?!\.)([\p{L}\p{N}\s_.-]{1,100})\.(pdf|epub|mobi)$/iu';
        if (!preg_match($regex, $file['name']))
        {
            return false;
        }

        $valid_file_size = 150 * 1024 * 1024;
        $file_size = $file['size'];
        if ($file_size > $valid_file_size)
        {
            return false;
        }

        $valid_mime_types = ['application/pdf', 'application/epub+zip', 'application/x-mobipocket-ebook'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if (!$file_mime_type || !in_array($file_mime_type, $valid_mime_types))
        {
            return false;
        }

        return true;
    }

    public function isValidCover($cover)
    {
        if ($cover['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $valid_cover_size = 5 * 1024 * 1024;
        $cover_size = $cover['size'];
        if ($cover_size > $valid_cover_size)
        {
            return false;
        }
        
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
        $cover_extension = strtolower(pathinfo($cover['name'], PATHINFO_EXTENSION));
        if (!in_array($cover_extension, $allowed_extensions))
        {
            return false;
        };

        $valid_mime_types = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $cover_mime_type = finfo_file($finfo, $cover['tmp_name']);
        finfo_close($finfo);
        if (!$cover_mime_type || !in_array($cover_mime_type, $valid_mime_types))
        {
            return false;
        }

        if (!@getimagesize($cover['tmp_name'])) {
            return false;
        }

        return true;
    }

    public function create($ebook)
    {
        if (!$ebook['slug'] || !$ebook['title'] || !$ebook['author'] || !$ebook['price'] || !$ebook['pages'] || !$ebook['year'] || !$ebook['language'] || !$ebook['description'] || !$ebook['file'] || !$ebook['cover'])
        {
            return ['error' => 'The fields title, slug, price, author, year, pages, language, description, file and cover are required.'];
        }

        if (!$this->isValidSlug($ebook['slug'])) {
            return ['error' => 'The slug must be between 3 and 100 characters long and can only contain lowercase letters, numbers, and hyphens.'];
        }

        if ($this->isSlugAlreadyInUse($ebook['slug'])) {
            return ['error' => 'The slug already exists.'];
        }

        if (!$this->isValidTitle($ebook['title'])) {
            return ['error' => 'The title must be between 3 and 100 characters long and can only contain letters, numbers and spaces.'];
        }

        if (!empty($ebook['subtitle']) && !$this->isValidSubtitle($ebook['subtitle'])) {
            return ['error' => 'The subtitle must be between 3 and 100 characters long and can only contain letters, numbers and spaces.'];
        }

        if (!$this->isValidAuthor($ebook['author'])) {
            return ['error' => 'The author must be between 3 and 100 characters long and can only contain letters and spaces.'];
        }

        if (!empty($ebook['publisher']) && !$this->isValidPublisher($ebook['publisher'])) {
            return ['error' => 'The publisher must be between 3 and 100 characters long and can only contain letters and spaces.'];
        }

        if (!$this->isValidPrice($ebook['price'])) {
            return ['error' => 'The price must be a number between 0.00 and 99999999.99.'];
        }

        if (!$this->isValidPages($ebook['pages'])) {
            return ['error' => 'The pages must be a number between 1 and 9999.'];
        }

        if (!$this->isValidYear($ebook['year'])) {
            return ['error' => 'The year must be a number between 1 and the current year.'];
        }    

        if (!$this->isValidLanguage($ebook['language'])) {
            return ['error' => 'The language must be between 2 and 30 characters long and can only contain letters and spaces.'];
        }

        if (!$this->isValidDescription($ebook['description'])) {
            return ['error' => 'The description must be between 100 and 9999 characters long and can contain letters, numbers, punctuation, and spaces.'];
        }

        if (!$this->isValidFile($ebook['file'])) {
            return ['error' => 'The file must be a valid ebook (pdf, epub, mobi) and less than 150MB.'];
        }

        if (!$this->isValidCover($ebook['cover'])) {
            return ['error' => 'The cover must be a valid image (jpg, jpeg, png, webp) and less than 5MB.'];
        }

        try {
            $file_dir = __DIR__ . '/../../uploads/file/';
            $cover_dir = __DIR__ . '/../../uploads/cover/';

            $cover_extension = strtolower(pathinfo($ebook['cover']['name'], PATHINFO_EXTENSION));

            $file_path = uniqid() . '-' . basename($ebook['file']['name']);
            $cover_path = uniqid() . '.' . $cover_extension;

            if (!move_uploaded_file($ebook['file']['tmp_name'], $file_dir . $file_path)) {
                return ['error' => 'Failed to upload the ebook file.'];
            }

            if (!move_uploaded_file($ebook['cover']['tmp_name'], $cover_dir . $cover_path)) {
                return ['error' => 'Failed to upload the cover image.'];
            }

            $this->addEbookDB(
                $ebook['slug'],
                $ebook['title'],
                $ebook['subtitle'],
                $ebook['author'],
                $ebook['publisher'],
                $ebook['price'],
                $ebook['pages'],
                $ebook['year'],
                $ebook['language'],
                $ebook['description'],
                $ebook['file']['name'],
                $ebook['file']['size'],
                $file_path,
                $cover_path
            );

            $ebook = $this->getEbook($ebook['slug']);
    
            if (!$ebook) {
                return ['error' => 'Failed to create the ebook.'];
            }
    
            return ['success' => "Ebook \"{$ebook['title']}\" created successfully."];

        } catch (\Exception $e) {
            return ['error' => 'An error occurred while creating the ebook.'];
        }
    }
}