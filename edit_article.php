<?php
require_once __DIR__ . '/functions.php';
require_admin();

$slug = $_GET['slug'] ?? '';
$article = find_article($slug);
$errors = [];

if (!$article) {
    http_response_code(404);
}

$values = [
    'title' => $article['title'] ?? '',
    'animal_type' => normalize_animal_type($article['animal_type'] ?? 'ssak'),
    'species' => $article['species'] ?? '',
    'habitat' => $article['habitat'] ?? '',
    'diet' => $article['diet'] ?? '',
    'content' => $article['content'] ?? '',
];

if ($article && $_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($values as $field => $_) {
        $values[$field] = trim($_POST[$field] ?? '');
    }

    if ($values['title'] === '') {
        $errors[] = 'Podaj tytuł artykułu.';
    }

    if ($values['content'] === '') {
        $errors[] = 'Dodaj treść artykułu.';
    }

    $imageName = $article['image'] ?? null;

    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . '/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
        ];

        $fileType = mime_content_type($_FILES['image']['tmp_name']);

        if (!array_key_exists($fileType, $allowedTypes)) {
            $errors[] = 'Zdjęcie musi być w formacie JPG, PNG, WEBP albo GIF.';
        } else {
            $extension = $allowedTypes[$fileType];
            $newImageName = uniqid('animal_', true) . '.' . $extension;
            $targetPath = $uploadDir . $newImageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                if (!empty($imageName)) {
                    $oldPath = $uploadDir . $imageName;

                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $imageName = $newImageName;
            } else {
                $errors[] = 'Nie udało się zapisać nowego zdjęcia.';
            }
        }
    }

    if (empty($errors)) {
        $newSlug = update_article($slug, [
            'title' => $values['title'],
            'animal_type' => normalize_animal_type($values['animal_type']),
            'species' => $values['species'] !== '' ? $values['species'] : 'Brak danych',
            'habitat' => $values['habitat'] !== '' ? $values['habitat'] : 'Brak danych',
            'diet' => $values['diet'] !== '' ? $values['diet'] : 'Brak danych',
            'content' => $values['content'],
            'image' => $imageName,
        ]);

        if ($newSlug) {
            header('Location: ' . url_for('search'));
            exit;
        }

        $errors[] = 'Nie udało się zapisać zmian.';
    }
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edytuj artykuł - Zoopedia</title>
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body>
    <?php render_nav(); ?>

    <main class="page">
        <section class="form-shell">
            <?php if (!$article): ?>
                <h1>Nie znaleziono artykułu</h1>
                <p class="empty">Nie można edytować artykułu, który nie istnieje.</p>
                <a class="text-link" href="<?= h(url_for('search')) ?>">Wróć do listy artykułów</a>
            <?php else: ?>
                <h1>Edytuj artykuł</h1>

                <?php if (!empty($errors)): ?>
                    <div class="notice error">
                        <?php foreach ($errors as $error): ?>
                            <p><?= h($error) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form class="article-form" action="<?= h(edit_article_url($slug)) ?>" method="post" enctype="multipart/form-data">
                    <label>
                        Tytuł artykułu
                        <input type="text" name="title" value="<?= h($values['title']) ?>" required>
                    </label>

                    <label>
                        Typ zwierzęcia
                        <select name="animal_type" required>
                            <?php foreach (animal_type_options() as $typeValue => $typeLabel): ?>
                                <option value="<?= h($typeValue) ?>" <?= $values['animal_type'] === $typeValue ? 'selected' : '' ?>>
                                    <?= h($typeLabel) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        Gatunek
                        <input type="text" name="species" value="<?= h($values['species']) ?>">
                    </label>

                    <label>
                        Środowisko życia
                        <input type="text" name="habitat" value="<?= h($values['habitat']) ?>">
                    </label>

                    <label>
                        Dieta
                        <input type="text" name="diet" value="<?= h($values['diet']) ?>">
                    </label>

                    <?php if (!empty($article['image'])): ?>
                        <div>
                            <p class="meta">Obecne zdjęcie</p>
                            <img
                                class="article-thumb"
                                src="<?= h(asset_url('uploads/' . $article['image'])) ?>"
                                alt="<?= h($article['title']) ?>"
                            >
                        </div>
                    <?php endif; ?>

                    <label>
                        Nowe zdjęcie, opcjonalnie
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif">
                    </label>

                    <label>
                        Treść artykułu
                        <textarea name="content" rows="9" required><?= h($values['content']) ?></textarea>
                    </label>

                    <button type="submit">Zapisz zmiany</button>
                </form>
            <?php endif; ?>
        </section>
    </main>

    <?php render_footer(); ?>
</body>
</html>