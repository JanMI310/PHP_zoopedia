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
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body>
    <?php render_nav(); ?>

    <main class="page">
        <section class="section">
            <h1>Wyszukaj artykuł</h1>

            <form class="search-bar compact" action="<?= h(url_for('search')) ?>" method="get">
                <input
                    type="search"
                    name="q"
                    value="<?= h($query) ?>"
                    placeholder="Np. lis, ssak, Tybet, mięsożerny"
                >
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
                        <article class="article-row article-row-with-image">
                            <?php if (!empty($article['image'])): ?>
                                <a 
                                    class="article-thumb-link" 
                                    href="article.php?slug=<?= urlencode($article['slug']) ?>"
                                >
                                    <img
                                        class="article-thumb"
                                        src="<?= h(asset_url('uploads/' . $article['image'])) ?>"
                                        alt="<?= h($article['title']) ?>"
                                    >
                                </a>
                            <?php else: ?>
                                <a 
                                    class="article-thumb-link" 
                                    href="article.php?slug=<?= urlencode($article['slug']) ?>"
                                >
                                    <div class="article-thumb article-thumb-placeholder">
                                        <?= h(mb_substr($article['title'] ?? '?', 0, 1)) ?>
                                    </div>
                                </a>
                            <?php endif; ?>

                            <div class="article-row-content">
                                <span class="type-pill type-<?= h(normalize_animal_type($article['animal_type'] ?? 'ssak')) ?>">
                                    <?= h(animal_type_label($article['animal_type'] ?? 'ssak')) ?>
                                </span>

                                <p class="meta"><?= h($article['species'] ?? 'Nieznany gatunek') ?></p>

                                <h2>
                                    <a href="article.php?slug=<?= urlencode($article['slug']) ?>">
                                        <?= h($article['title']) ?>
                                    </a>
                                </h2>

                                <p><?= h(article_excerpt($article['content'] ?? '', 220)) ?></p>

                                <dl class="mini-facts">
                                    <div>
                                        <dt>Środowisko</dt>
                                        <dd><?= h($article['habitat'] ?? 'Brak danych') ?></dd>
                                    </div>

                                    <div>
                                        <dt>Dieta</dt>
                                        <dd><?= h($article['diet'] ?? 'Brak danych') ?></dd>
                                    </div>
                                </dl>
                            </div>

                            <a class="text-link" href="article.php?slug=<?= urlencode($article['slug']) ?>">
                                Czytaj
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <?php render_footer(); ?>
</body>
</html>