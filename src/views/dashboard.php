<h1>Admin Dashboard</h1>

<div class="dashboard">
    <div class="create">
        <h2>Create a new ebook:</h2>
        <form method="post" action="/create" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input id="title" type="text" name="title" placeholder="Title" value="<?= $html($ebook['title'] ?? null) ?>" required>
    
            <label for="subtitle">Subtitle:</label>
            <input id="subtitle" type="text" name="subtitle" placeholder="Subtitle (optional)" value="<?= $html($ebook['subtitle'] ?? null) ?>">
    
            <label for="slug">Slug (URL):</label>
            <input id="slug" type="text" name="slug" placeholder="ebook-title" value="<?= $html($ebook['slug'] ?? null) ?>" required>
        
            <label for="author">Author:</label>
            <input id="author" type="text" name="author" placeholder="Author" value="<?= $html($ebook['author'] ?? null) ?>" required>
    
            <label for="publisher">Publisher:</label>
            <input id="publisher" type="text" name="publisher" placeholder="Publisher (optional)" value="<?= $html($ebook['publisher'] ?? null) ?>">

            <label for="price">Price:</label>
            <input id="price" type="number" name="price" placeholder="00.00" min="0.00" max="99999999.99" step="0.01" value="<?= $html($ebook['price'] ?? null) ?>" required>

            <label for="pages">Pages:</label>
            <input id="pages" type="number" name="pages" placeholder="0" min="1" max="9999" step="1" value="<?= $html($ebook['pages'] ?? null) ?>" required>

            <label for="year">Year:</label>
            <input id="year" type="number" name="year" placeholder="<?= date('Y') ?>" min="1" max="9999" step="1" value="<?= $html($ebook['year'] ?? date('Y')) ?>" required>
        
            <label for="language">Language:</label>
            <input id="language" type="text" name="language" placeholder="English" value="<?= $html($ebook['language'] ?? null) ?>" required>
    
            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi aperiam ipsam, quaerat vero unde quod." rows=10 cols=50 maxlength=9999 required><?= $html($ebook['description'] ?? null) ?></textarea>

            <label for="file">File: <span class="supported-files">(pdf, epub, mobi) 150MB max</span></label>
            <input id="file" type="file" name="file" required>
    
            <label for="cover">Cover: <span class="supported-files">(jpg, jpeg, png, webp) 5MB max</span></label>
            <input id="cover" type="file" name="cover" required>
    
            <input type="submit" value="Submit">
        </form>
    </div>
    <div class="sales">
        <h2>Sales</h2>
    </div>
</div>

<?php if (isset($error)): ?>
<p class="error"><?= $html($error) ?></p>
<?php endif; ?>
<?php if (isset($success)): ?>
<p class="success"><?= $html($success) ?></p>
<?php endif; ?>