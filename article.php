<?php
require_once __DIR__ . '/functions.php';

$article = find_article($_GET['slug'] ?? '');
$template = $article ? animal_template($article['animal_type'] ?? 'ssak') : null;
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $article ? h($article['title']) : 'Nie znaleziono artykułu' ?> - Zoopedia</title>
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body class="<?= $template ? 'article-theme ' . h($template['class']) : '' ?>">
    <?php render_nav(); ?>

    <main class="page">
        <?php if (!$article): ?>
            <section class="section">
                <h1>Nie znaleziono artykułu</h1>
                <p class="empty">Wybrany artykuł nie istnieje albo został usunięty.</p>
                <a class="text-link" href="<?= h(url_for('search')) ?>">Wróć do wyszukiwarki</a>
            </section>
        <?php else: ?>

            <?php if (is_admin()): ?>
                <div class="article-actions">
                    <a class="button" href="<?= h(edit_article_url($article['slug'])) ?>">
                        Edytuj artykuł
                    </a>

                    <form
                        action="<?= h(delete_article_url($article['slug'])) ?>"
                        method="post"
                        onsubmit="return confirm('Czy na pewno usunąć ten artykuł?');"
                    >
                        <button class="danger-button" type="submit">Usuń artykuł</button>
                    </form>
                </div>
            <?php endif; ?>

            <article class="article-detail typed-article <?= h($template['class']) ?>" data-template="<?= h($template['label']) ?>">
                <div class="article-template-hero">
                    <div>
                        <span class="template-ribbon"><?= h($template['label']) ?></span>
                        <p class="eyebrow"><?= h($article['species'] ?? 'Brak danych') ?></p>
                        <h1><?= h($article['title']) ?></h1>
                        <p><?= h($template['lead']) ?></p>
                    </div>

                    <div class="template-symbol" aria-hidden="true">
                        <?= h(mb_substr($template['label'], 0, 1)) ?>
                    </div>
                </div>

                <?php if (!empty($article['image'])): ?>
                    <figure class="article-image-box">
                        <img
                            class="article-main-image"
                            src="<?= h(asset_url('uploads/' . $article['image'])) ?>"
                            alt="<?= h($article['title']) ?>"
                        >
                    </figure>
                <?php endif; ?>

                <dl class="facts">
                    <div>
                        <dt>Typ</dt>
                        <dd><?= h(animal_type_label($article['animal_type'] ?? 'ssak')) ?></dd>
                    </div>

                    <div>
                        <dt>Gatunek</dt>
                        <dd><?= h($article['species'] ?? 'Brak danych') ?></dd>
                    </div>

                    <div>
                        <dt>Środowisko</dt>
                        <dd><?= h($article['habitat'] ?? 'Brak danych') ?></dd>
                    </div>

                    <div>
                        <dt>Dieta</dt>
                        <dd><?= h($article['diet'] ?? 'Brak danych') ?></dd>
                    </div>
                </dl>

                <section class="template-note">
                    <h2><?= h($template['accent']) ?></h2>
                    <p><?= h(template_description($article['animal_type'] ?? 'ssak')) ?></p>
                </section>

                <section class="article-text">
                    <h2>Opis</h2>
                    <p><?= nl2br(h($article['content'] ?? '')) ?></p>
                </section>
            </article>
        <?php endif; ?>
    </main>

    <?php render_footer(); ?>
</body>
</html>