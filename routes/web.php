<?php

use Core\Helpers;

use App\Controllers\{
    HomeController,
    EbooksController,
    EbookController,
    AboutController,
    DashboardController,
    MyLibraryController,
    ConfigController,
    LoginController,
    SignupController,
    LogoutController,
    TermsController,
    NotFoundController
};

$router->add('GET', '/', [HomeController::class, 'index']);
$router->add('GET', '/home', [HomeController::class, 'index']);
$router->add('GET', '/ebooks', [EbooksController::class, 'index']);
$router->add('GET', '/ebook/{id}', [EbookController::class, 'index']);
$router->add('GET', '/about', [AboutController::class, 'index']);
$router->add('GET', '/dashboard', [DashboardController::class, 'index']);
$router->add('POST', '/create', [DashboardController::class, 'create']);
$router->add('GET', '/mylibrary', [MyLibraryController::class, 'index']);
$router->add('GET', '/config', [ConfigController::class, 'index']);
$router->add('GET', '/login', [LoginController::class, 'index']);
$router->add('POST', '/login', [LoginController::class, 'login']);
$router->add('GET', '/signup', [SignupController::class, 'index']);
$router->add('POST', '/signup', [SignupController::class, 'signup']);
$router->add('GET', '/logout', [LogoutController::class, 'logout']);
$router->add('GET', '/terms', [TermsController::class, 'index']);
$router->add('GET', '/404', [NotFoundController::class, 'index']);

$router->add('GET', '/cover/{filename}', function ($args) {
    $label = 'cover';
    $filename = $args['filename'];
    Helpers::getImage($label, $filename);
});

$router->add('GET', '/avatar/{filename}', function ($args) {
    $label = 'avatar';
    $filename = $args['filename'];
    Helpers::getImage($label, $filename);
});