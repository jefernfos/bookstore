<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">    
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/main.js"></script>
    <title><?= isset($title) ? htmlspecialchars($title) : htmlspecialchars('Essential Reads') ?></title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="/" data-internal><img src="/assets/logo.svg" height="80"></a>
        </div>
        <div class="navbar">
            <nav>
                <a href="/" data-internal>Home</a>
                <a href="/ebooks" data-internal>Ebooks</a>
                <a href="/about" data-internal>About Us</a>
            </nav>
        </div>
        <div id="menu">
            <?php include __DIR__ . '/menu.php'; ?>
        </div>
    </header>
    <main id="content">
        