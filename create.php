<?php
require_once __DIR__ . '/functions.php';

$errors = [];
$success = false;
$values = [
    'title' => '',
    'species' => '',
    'habitat' => '',
    'diet' => '',
    'content' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($values as $field => $_) {
        $values[$field] = trim($_POST[$field] ?? '');
    }

    if ($values['title'] === '') {
        $errors[] = 'Podaj tytuł artykułu.';
    }

    if ($values['content'] === '') {
        $errors[] = 'Dodaj treść artykułu.';
    }

    if (empty($errors)) {
        $articles = load_articles();
        $articles[] = [
            'slug' => unique_slug($values['title'], $articles),
            'title' => $values['title'],
            'species' => $values['species'] !== '' ? $values['species'] : 'Brak danych',
            'habitat' => $values['habitat'] !== '' ? $values['habitat'] : 'Brak danych',
            'diet' => $values['diet'] !== '' ? $values['diet'] : 'Brak danych',
            'content' => $values['content'],
            'created_at' => date('Y-m-d'),
        ];

        save_articles($articles);
        $success = true;
        $values = array_fill_keys(array_keys($values), '');
    }
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Utwórz artykuł - Zoopedia</title>
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
        <section class="form-shell">
            <h1>Utwórz artykuł</h1>

            <?php if ($success): ?>
                <div class="notice success">Artykuł został dodany do Zoopedii.</div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="notice error">
                    <?php foreach ($errors as $error): ?>
                        <p><?= h($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form class="article-form" action="create.php" method="post">
                <label>
                    Tytuł artykułu
                    <input type="text" name="title" value="<?= h($values['title']) ?>" required>
                </label>

                <label>
                    Nazwa gatunkowa
                    <input type="text" name="species" value="<?= h($values['species']) ?>" placeholder="Np. Panthera leo">
                </label>

                <label>
                    Środowisko życia
                    <input type="text" name="habitat" value="<?= h($values['habitat']) ?>" placeholder="Np. sawanna, las tropikalny">
                </label>

                <label>
                    Dieta
                    <input type="text" name="diet" value="<?= h($values['diet']) ?>" placeholder="Np. mięsożerny, roślinożerny">
                </label>

                <label>
                    Treść artykułu
                    <textarea name="content" rows="9" required><?= h($values['content']) ?></textarea>
                </label>

                <button type="submit">Zapisz artykuł</button>
            </form>
        </section>
    </main>
</body>
</html>
