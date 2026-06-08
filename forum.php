<?php
require_once __DIR__ . '/functions.php';
require_login();

$user = current_user();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_admin()) {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $errors[] = 'Podaj tytuł i treść tematu.';
    } else {
        add_forum_topic($title, $content, $user);
        header('Location: ' . url_for('forum'));
        exit;
    }
}

$topics = load_forum_topics();
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forum - Zoopedia</title>
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body class="forum-page">
    <?php render_nav(); ?>

    <main class="page">
        <section class="forum-hero">
            <div>
                <p class="eyebrow">Społeczność Zoopedii</p>
                <h1>Forum o zwierzętach, przyrodzie i ochronie gatunków.</h1>
                <p>Wątki tworzy administrator, a zalogowani użytkownicy mogą komentować dyskusje.</p>
            </div>
        </section>

        <section class="section forum-layout">
            <div class="forum-main">
                <div class="section-title">
                    <h2>Dyskusje</h2>
                    <span class="home-tag"><?= count($topics) ?> tematów</span>
                </div>

                <?php if (empty($topics)): ?>
                    <p class="empty">Brak tematów.</p>
                <?php else: ?>
                    <div class="forum-topic-list">
                        <?php foreach ($topics as $topic): ?>
                            <?php $commentsCount = count($topic['comments'] ?? []); ?>

                            <article class="forum-topic-card">
                                <div class="forum-topic-icon">
                                    <?= h(mb_substr($topic['title'] ?? '?', 0, 1)) ?>
                                </div>

                                <div class="forum-topic-content">
                                    <p class="meta">
                                        Autor: <?= h($topic['author_login'] ?? 'Admin') ?> · <?= h($topic['created_at'] ?? '') ?>
                                    </p>

                                    <h3>
                                        <a href="<?= h(forum_topic_url((int) $topic['id'])) ?>">
                                            <?= h($topic['title'] ?? '') ?>
                                        </a>
                                    </h3>

                                    <p><?= h(article_excerpt($topic['content'] ?? '', 150)) ?></p>
                                </div>

                                <div class="forum-topic-stats">
                                    <strong><?= $commentsCount ?></strong>
                                    <span><?= $commentsCount === 1 ? 'komentarz' : 'komentarzy' ?></span>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <aside class="forum-sidebar">
                <?php if (!empty($errors)): ?>
                    <div class="notice error">
                        <?php foreach ($errors as $error): ?>
                            <p><?= h($error) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (is_admin()): ?>
                    <form class="forum-form" action="<?= h(url_for('forum')) ?>" method="post">
                        <h2>Nowy temat</h2>

                        <label>
                            Tytuł
                            <input type="text" name="title" required>
                        </label>

                        <label>
                            Treść
                            <textarea name="content" rows="6" required></textarea>
                        </label>

                        <button type="submit">Dodaj temat</button>
                    </form>
                <?php else: ?>
                    <div class="forum-tip">
                        <p>Tylko administrator może tworzyć nowe wątki. Możesz odpowiadać w istniejących dyskusjach.</p>
                    </div>
                <?php endif; ?>
            </aside>
        </section>
    </main>

    <?php render_footer(); ?>
</body>
</html>