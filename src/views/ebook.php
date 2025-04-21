<h1>
    <a href="/ebooks" data-internal><-</a> <?= htmlspecialchars($ebook['title']) ?? null ?>
</h1>
<div class="ebook">
    <div class="cover">
        <img src="/cover/<?= htmlspecialchars($ebook['cover_path']) ?? null ?>" alt="Ebook cover.">
    </div>
    <div class="info">
        <?= htmlspecialchars($ebook['title']) ?? null ?><br>
        <?= htmlspecialchars($ebook['subtitle']) ?? null ?><br>
        <?= htmlspecialchars($ebook['description']) ?? null ?><br>
        <br>
        <?= htmlspecialchars($ebook['price']) ?? null ?><br>
        <br>
        <?= htmlspecialchars($ebook['author']) ?? null ?>
        <?= htmlspecialchars($ebook['publisher']) ?? null ?>
        <?= htmlspecialchars($ebook['pages']) ?? null ?>
        <?= htmlspecialchars($ebook['year']) ?? null ?>
        <?= htmlspecialchars($ebook['language']) ?? null ?>
        <?= htmlspecialchars(number_format($ebook['file_size'] / 1024 / 1024, 1)) ?? null ?>MB
    </div>
</div>