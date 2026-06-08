<?php
require_once __DIR__ . '/functions.php';
require_admin();

$users = load_users();
$articlesCount = count(load_articles());
$topicsCount = count(load_forum_topics());
$currentUser = current_user();
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel admina - Zoopedia</title>
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body>
    <?php render_nav(); ?>

    <main class="page">
        <section class="section">
            <h1>Panel admina</h1>
            <p class="results-count">Zarządzanie użytkownikami, artykułami i forum.</p>

            <div class="dashboard-grid">
                <article class="dashboard-card">
                    <p class="meta">Użytkownicy</p>
                    <strong><?= count($users) ?></strong>
                </article>

                <article class="dashboard-card">
                    <p class="meta">Artykuły</p>
                    <strong><?= $articlesCount ?></strong>
                </article>

                <article class="dashboard-card">
                    <p class="meta">Tematy forum</p>
                    <strong><?= $topicsCount ?></strong>
                </article>
            </div>

            <div class="section-title">
                <h2>Użytkownicy</h2>
            </div>

            <div class="table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Login</th>
                            <th>Rola</th>
                            <th>Utworzono</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="5">Brak użytkowników.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $listedUser): ?>
                                <tr>
                                    <td><?= (int) $listedUser['id'] ?></td>
                                    <td><?= h($listedUser['login']) ?></td>
                                    <td><?= h(role_label((int) $listedUser['role'])) ?></td>
                                    <td><?= h($listedUser['created_at']) ?></td>
                                    <td>
                                        <?php if ($currentUser && (int) $listedUser['id'] === (int) $currentUser['id']): ?>
                                            —
                                        <?php else: ?>
                                            <a
                                                class="danger-button"
                                                href="<?= h(asset_url('admin_user_delete.php?id=' . (int) $listedUser['id'])) ?>"
                                                onclick="return confirm('Czy na pewno usunąć tego użytkownika z bazy danych?');"
                                            >
                                                Usuń
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <?php render_footer(); ?>
</body>
</html>