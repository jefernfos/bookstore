<h1>
    <a href="/ebooks" data-internal><-</a> <?= $html($ebook['title']) ?? null ?>
</h1>
<div class="ebook">
    <div class="cover">
        <img src="/cover/<?= $html($ebook['cover_path']) ?? null ?>" alt="Ebook cover.">
    </div>
    <div class="info">
        <?= $html($ebook['title']) ?? null ?><br>
        <?= $html($ebook['subtitle']) ?? null ?><br>
        <?= $html($ebook['description']) ?? null ?><br>
        <br>
        <?= $html($ebook['price']) ?? null ?><br>
        <br>
        <?= $html($ebook['author']) ?? null ?>
        <?= $html($ebook['publisher']) ?? null ?>
        <?= $html($ebook['pages']) ?? null ?>
        <?= $html($ebook['year']) ?? null ?>
        <?= $html($ebook['language']) ?? null ?>
        <?= $html(number_format($ebook['file_size'] / 1024 / 1024, 1)) ?? null ?>MB
    </div>
</div>