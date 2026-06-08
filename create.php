<?php
require_once __DIR__ . '/functions.php';
require_login();

$errors = [];
$success = false;

$values = [
    'title' => '',
    'animal_type' => 'ssak',
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

    $imageName = null;

    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . '/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Wystąpił błąd podczas przesyłania zdjęcia.';
        } else {
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
                $imageName = uniqid('animal_', true) . '.' . $extension;
                $targetPath = $uploadDir . $imageName;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $errors[] = 'Nie udało się zapisać zdjęcia w folderze uploads.';
                    $imageName = null;
                }
            }
        }
    }

    if (empty($errors)) {
        add_article([
            'title' => $values['title'],
            'animal_type' => normalize_animal_type($values['animal_type']),
            'species' => $values['species'] !== '' ? $values['species'] : 'Brak danych',
            'habitat' => $values['habitat'] !== '' ? $values['habitat'] : 'Brak danych',
            'diet' => $values['diet'] !== '' ? $values['diet'] : 'Brak danych',
            'content' => $values['content'],
            'image' => $imageName,
            'created_at' => date('Y-m-d'),
        ]);

        $success = true;

        $values = [
            'title' => '',
            'animal_type' => 'ssak',
            'species' => '',
            'habitat' => '',
            'diet' => '',
            'content' => '',
        ];
    }
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Utwórz artykuł - Zoopedia</title>
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body>
    <?php render_nav(); ?>

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

            <form class="article-form" action="create.php" method="post" enctype="multipart/form-data">
                <label>
                    Tytuł artykułu
                    <input type="text" name="title" value="<?= h($values['title']) ?>" required>
                </label>

                <label>
                    Typ zwierzęcia
                    <select name="animal_type">
                        <?php foreach (animal_type_options() as $value => $label): ?>
                            <option value="<?= h($value) ?>" <?= $values['animal_type'] === $value ? 'selected' : '' ?>>
                                <?= h($label) ?>
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

                <label>
                    Zdjęcie zwierzęcia
                    <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif">
                </label>

                <label>
                    Treść artykułu
                    <textarea name="content" rows="9" required><?= h($values['content']) ?></textarea>
                </label>

                <button type="submit">Dodaj artykuł</button>
            </form>
        </section>
    </main>

    <?php render_footer(); ?>
</body>
</html>