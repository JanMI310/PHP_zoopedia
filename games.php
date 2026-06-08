<?php
require_once __DIR__ . '/functions.php';
require_login();
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gry - Zoopedia</title>
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body class="games-page">
    <?php render_nav(); ?>

    <main class="page">
        <section class="section">
            <h1>Wybierz grę</h1>
            <p class="results-count">Kliknij kafelek, aby przejść do wybranej gry o zwierzętach.</p>

            <div class="game-choice-grid">
                <a class="game-choice-card quiz-card" href="<?= h(url_for('quiz')) ?>">
                    <span>Quiz</span>
                    <strong>Sprawdź wiedzę</strong>
                    <p>Odpowiadaj na pytania o gatunki, środowiska i ciekawostki.</p>
                </a>

                <a class="game-choice-card hangman-card" href="<?= h(url_for('hangman')) ?>">
                    <span>Wisielec</span>
                    <strong>Odgadnij hasło</strong>
                    <p>Wybieraj litery i odkryj nazwę zwierzęcia przed końcem prób.</p>
                </a>

                <a class="game-choice-card memory-card-link" href="<?= h(url_for('memory')) ?>">
                    <span>Memory</span>
                    <strong>Znajdź pary</strong>
                    <p>Odkrywaj karty i zapamiętuj, gdzie ukryły się zwierzęta.</p>
                </a>
            </div>
        </section>
    </main>
    <?php render_footer(); ?>
</body>
</html>
