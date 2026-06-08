<?php
require_once __DIR__ . '/functions.php';

if (is_logged_in()) {
    header('Location: ' . url_for('home'));
    exit;
}

$error = '';
$login = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if (login_user($login, $password)) {
        header('Location: ' . url_for('home'));
        exit;
    }

    $error = 'Nieprawidłowy login lub hasło.';
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logowanie - Zoopedia</title>
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body>
    <?php render_nav(); ?>

    <main class="page">
        <section class="form-shell">
            <h1>Zaloguj się</h1>

            <?php if ($error !== ''): ?>
                <div class="notice error"><p><?= h($error) ?></p></div>
            <?php endif; ?>

            <form class="article-form" action="<?= h(url_for('login')) ?>" method="post">
                <label>
                    Login
                    <input type="text" name="login" value="<?= h($login) ?>" required>
                </label>

                <label>
                    Hasło
                    <input type="password" name="password" required>
                </label>

                <button type="submit">Zaloguj</button>
            </form>

            <p class="auth-note">Nie masz konta? <a href="<?= h(url_for('register')) ?>">Zarejestruj się</a>.</p>
        </section>
    </main>

    <?php render_footer(); ?>
</body>
</html>