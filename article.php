<?php
require_once __DIR__ . '/functions.php';

$article = find_article($_GET['slug'] ?? '');
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $article ? h($article['title']) : 'Nie znaleziono artykułu' ?> - Zoopedia</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <nav class="nav">
            <a class="brand" href="index.php">Zoopedia</a>
            <div class="nav-links">
                <a href="index.php">Strona główna</a>
                <a href="search.php">Wyszukaj artykuł</a>
                <a class="button" href="create.php">Utwórz artykuł</a>
            </div>
        </nav>
    </header>

    <main class="page">
        <?php if (!$article): ?>
            <section class="section">
                <h1>Nie znaleziono artykułu</h1>
                <p class="empty">Wybrany artykuł nie istnieje albo został usunięty.</p>
                <a class="text-link" href="search.php">Wróć do wyszukiwarki</a>
            </section>
        <?php else: ?>
            <article class="article-detail">
                <p class="eyebrow"><?= h($article['species'] ?? 'Brak danych') ?></p>
                <h1><?= h($article['title']) ?></h1>

                <dl class="facts">
                    <div>
                        <dt>Środowisko</dt>
                        <dd><?= h($article['habitat'] ?? 'Brak danych') ?></dd>
                    </div>
                    <div>
                        <dt>Dieta</dt>
                        <dd><?= h($article['diet'] ?? 'Brak danych') ?></dd>
                    </div>
                    <div>
                        <dt>Dodano</dt>
                        <dd><?= h($article['created_at'] ?? 'Brak danych') ?></dd>
                    </div>
                </dl>

                <p class="article-content"><?= nl2br(h($article['content'] ?? '')) ?></p>
            </article>
        <?php endif; ?>
    </main>
</body>
</html>
