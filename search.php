<?php
require_once __DIR__ . '/functions.php';

$query = trim($_GET['q'] ?? '');
$results = search_articles($query);
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wyszukaj artykuł - Zoopedia</title>
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
        <section class="section">
            <h1>Wyszukaj artykuł</h1>
            <form class="search-bar compact" action="search.php" method="get">
                <input type="search" name="q" value="<?= h($query) ?>" placeholder="Np. lew, Antarktyda, roślinożerny">
                <button type="submit">Szukaj</button>
            </form>

            <p class="results-count">
                <?php if ($query === ''): ?>
                    Wszystkie artykuły: <?= count($results) ?>
                <?php else: ?>
                    Wyniki dla „<?= h($query) ?>”: <?= count($results) ?>
                <?php endif; ?>
            </p>

            <?php if (empty($results)): ?>
                <p class="empty">Nie znaleziono artykułów pasujących do wyszukiwania.</p>
            <?php else: ?>
                <div class="article-list">
                    <?php foreach ($results as $article): ?>
                        <article class="article-row">
                            <div>
                                <p class="meta"><?= h($article['species'] ?? 'Nieznany gatunek') ?></p>
                                <h2><a href="article.php?slug=<?= urlencode($article['slug']) ?>"><?= h($article['title']) ?></a></h2>
                                <p><?= h(article_excerpt($article['content'] ?? '', 220)) ?></p>
                            </div>
                            <a class="text-link" href="article.php?slug=<?= urlencode($article['slug']) ?>">Czytaj</a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
