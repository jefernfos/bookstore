<h1>Ebooks</h1>

<?php foreach ($ebooks as $ebook): ?>
    <a href="/ebook/<?= urlencode($ebook['slug']) ?>" data-internal><?= $html($ebook['title']) ?></a><br>
<?php endforeach; ?>