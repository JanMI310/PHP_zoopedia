<?php
require_once __DIR__ . '/functions.php';
require_login();

$user = current_user();
$topicId = (int) ($_GET['id'] ?? 0);
$topic = find_forum_topic($topicId);
$errors = [];

if (!$topic) {
    http_response_code(404);
}

if ($topic && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content'] ?? '');

    if ($content === '') {
        $errors[] = 'Komentarz nie może być pusty.';
    } elseif (add_forum_comment((string) $topicId, $content, $user)) {
        header('Location: ' . forum_topic_url($topicId));
        exit;
    } else {
        $errors[] = 'Nie znaleziono wybranego tematu.';
    }

    $topic = find_forum_topic($topicId);
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $topic ? h($topic['title']) : 'Nie znaleziono tematu' ?> - Forum Zoopedii</title>
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body class="forum-page">
    <?php render_nav(); ?>

    <main class="page">
        <section class="section">
            <a class="text-link" href="<?= h(url_for('forum')) ?>">Wróć do forum</a>

            <?php if (!$topic): ?>
                <div class="forum-topic-detail">
                    <h1>Nie znaleziono tematu</h1>
                    <p class="empty">Wybrana dyskusja nie istnieje albo została usunięta.</p>
                </div>
            <?php else: ?>
                <article class="forum-topic-detail">
                    <p class="meta">
                        Autor: <?= h($topic['author_login'] ?? 'Admin') ?> · <?= h($topic['created_at'] ?? '') ?>
                    </p>

                    <h1><?= h($topic['title'] ?? '') ?></h1>
                    <p><?= nl2br(h($topic['content'] ?? '')) ?></p>
                </article>

                <section class="comments forum-comments-panel">
                    <div class="section-title">
                        <h2>Komentarze</h2>
                        <span class="home-tag"><?= count($topic['comments'] ?? []) ?></span>
                    </div>

                    <?php if (empty($topic['comments'])): ?>
                        <p class="empty">Brak komentarzy. Dodaj pierwszą odpowiedź.</p>
                    <?php else: ?>
                        <?php foreach ($topic['comments'] as $comment): ?>
                            <div class="comment forum-comment">
                                <p class="meta">
                                    <?= h($comment['author_login'] ?? 'Anonim') ?> · <?= h($comment['created_at'] ?? '') ?>
                                </p>

                                <p><?= nl2br(h($comment['content'] ?? '')) ?></p>

                                <?php if (is_admin()): ?>
                                    <form 
                                        action="<?= h(asset_url('delete_comment.php')) ?>" 
                                        method="post"
                                        onsubmit="return confirm('Czy na pewno usunąć ten komentarz?');"
                                    >
                                        <input type="hidden" name="comment_id" value="<?= (int) ($comment['id'] ?? 0) ?>">
                                        <input type="hidden" name="topic_id" value="<?= (int) $topicId ?>">
                                        <button class="danger-button" type="submit">Usuń komentarz</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </section>

                <?php if (!empty($errors)): ?>
                    <div class="notice error">
                        <?php foreach ($errors as $error): ?>
                            <p><?= h($error) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form class="forum-form forum-reply-form" action="<?= h(forum_topic_url($topicId)) ?>" method="post">
                    <h2>Dodaj komentarz</h2>

                    <label>
                        Treść komentarza
                        <textarea name="content" rows="5" required></textarea>
                    </label>

                    <button type="submit">Dodaj komentarz</button>
                </form>
            <?php endif; ?>
        </section>
    </main>

    <?php render_footer(); ?>
</body>
</html>