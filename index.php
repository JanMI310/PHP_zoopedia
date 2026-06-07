<?php
require_once __DIR__ . '/functions.php';

$articles = load_articles();
usort($articles, fn(array $a, array $b): int => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zoopedia - internetowa encyklopedia zwierząt</title>
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

    <main>
        <section class="hero">
            <div>
                <p class="eyebrow">Internetowa encyklopedia zwierząt</p>
                <h1>Odkrywaj gatunki, siedliska i ciekawostki ze świata fauny.</h1>
                <p>Przeglądaj artykuły o zwierzętach, wyszukuj informacje i dodawaj własne wpisy do Zoopedii.</p>
                <form class="search-bar" action="search.php" method="get">
                    <input type="search" name="q" placeholder="Wpisz nazwę zwierzęcia, gatunek lub środowisko">
                    <button type="submit">Szukaj</button>
                </form>
            </div>
        </section>

        <section class="section">
            <div class="section-title">
                <h2>Najnowsze artykuły</h2>
                <a href="create.php">Dodaj nowy wpis</a>
            </div>

            <?php if (empty($articles)): ?>
                <p class="empty">Brak artykułów. Utwórz pierwszy wpis w encyklopedii.</p>
            <?php else: ?>
                <div class="article-grid">
                    <?php foreach ($articles as $article): ?>
                        <article class="article-card">
                            <p class="meta"><?= h($article['species'] ?? 'Nieznany gatunek') ?></p>
                            <h3><a href="article.php?slug=<?= urlencode($article['slug']) ?>"><?= h($article['title']) ?></a></h3>
                            <p><?= h(article_excerpt($article['content'] ?? '')) ?></p>
                            <dl>
                                <div>
                                    <dt>Środowisko</dt>
                                    <dd><?= h($article['habitat'] ?? '-') ?></dd>
                                </div>
                                <div>
                                    <dt>Dieta</dt>
                                    <dd><?= h($article['diet'] ?? '-') ?></dd>
                                </div>
                            </dl>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
