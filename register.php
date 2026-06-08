<?php
require_once __DIR__ . '/functions.php';

if (is_logged_in()) {
    header('Location: ' . url_for('home'));
    exit;
}

$message = '';
$login = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $result = register_user($login, $password);

    if ($result['success']) {
        header('Location: ' . url_for('home'));
        exit;
    }

    $message = $result['message'];
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rejestracja - Zoopedia</title>
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body>
    <?php render_nav(); ?>

    <main class="page">
        <section class="form-shell">
            <h1>Załóż konto</h1>

            <?php if ($message !== ''): ?>
                <div class="notice error"><p><?= h($message) ?></p></div>
            <?php endif; ?>

            <form class="article-form" action="<?= h(url_for('register')) ?>" method="post">
                <label>
                    Login
                    <input type="text" name="login" value="<?= h($login) ?>" minlength="3" required>
                </label>

                <label>
                    Hasło
                    <input type="password" name="password" minlength="4" required>
                </label>

                <button type="submit">Utwórz konto</button>
            </form>

            <p class="auth-note">Masz już konto? <a href="<?= h(url_for('login')) ?>">Zaloguj się</a>.</p>
        </section>
    </main>

    <?php render_footer(); ?>
</body>
</html>