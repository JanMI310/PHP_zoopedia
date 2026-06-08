<?php
require_once __DIR__ . '/functions.php';
require_login();

$hangmanWords = array_values(array_unique(array_filter(array_map(
    fn(array $article): string => mb_strtolower(trim($article['title'] ?? '')),
    load_articles()
))));

if (empty($hangmanWords)) {
    $hangmanWords = ['lew'];
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wisielec - Zoopedia</title>
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body class="games-page">
    <?php render_nav(); ?>

    <main class="page">
        <section class="section">
            <a class="text-link" href="<?= h(url_for('games')) ?>">Wróć do wyboru gier</a>
            <section class="game-panel active standalone-game">
                <h1>Wisielec</h1>
                <p class="game-question">Odgadnij nazwę zwierzęcia.</p>
                <div class="hangman-stage" aria-label="Rysunek wisielca">
                    <svg viewBox="0 0 220 220" role="img">
                        <line class="gallows" x1="24" y1="200" x2="184" y2="200" />
                        <line class="gallows" x1="58" y1="200" x2="58" y2="24" />
                        <line class="gallows" x1="58" y1="24" x2="148" y2="24" />
                        <line class="gallows" x1="148" y1="24" x2="148" y2="52" />
                        <circle class="hangman-part" data-part="1" cx="148" cy="72" r="20" />
                        <line class="hangman-part" data-part="2" x1="148" y1="92" x2="148" y2="140" />
                        <line class="hangman-part" data-part="3" x1="148" y1="108" x2="120" y2="128" />
                        <line class="hangman-part" data-part="4" x1="148" y1="108" x2="176" y2="128" />
                        <line class="hangman-part" data-part="5" x1="148" y1="140" x2="124" y2="176" />
                        <line class="hangman-part" data-part="6" x1="148" y1="140" x2="172" y2="176" />
                    </svg>
                </div>
                <p id="hangman-word" class="hangman-word"></p>
                <p id="hangman-status" class="game-result"></p>
                <div id="hangman-letters" class="letters-grid"></div>
                <button type="button" id="new-hangman">Nowe słowo</button>
            </section>
        </section>
    </main>

    <?php render_footer(); ?>

    <script>
        const hangmanWords = <?= json_encode($hangmanWords, JSON_UNESCAPED_UNICODE) ?>;
        let hangmanWord = '';
        let guessed = [];
        let mistakes = 0;

        function startHangman() {
            hangmanWord = hangmanWords[Math.floor(Math.random() * hangmanWords.length)];
            guessed = [];
            mistakes = 0;
            renderHangman();
        }

        function renderHangman() {
            const displayItems = hangmanWord.split('').map((letter) => {
                if (letter === ' ') {
                    return '<span class="hangman-space" aria-label="spacja"></span>';
                }

                if (!letter.match(/[a-ząćęłńóśźż]/i)) {
                    return `<span class="hangman-separator">${letter}</span>`;
                }

                return `<span class="hangman-letter">${guessed.includes(letter) ? letter : '_'}</span>`;
            });
            const display = displayItems.join('');
            const wordElement = document.getElementById('hangman-word');
            wordElement.innerHTML = display;
            document.getElementById('hangman-status').textContent = `Błędy: ${mistakes}/6`;
            document.getElementById('hangman-letters').innerHTML = '';
            document.querySelectorAll('.hangman-part').forEach((part) => {
                part.classList.toggle('visible', Number(part.dataset.part) <= mistakes);
            });

            const hasHiddenLetters = hangmanWord.split('').some((letter) => letter.match(/[a-ząćęłńóśźż]/i) && !guessed.includes(letter));

            'aąbcćdeęfghijklłmnńoóprsśtuwyzźż'.split('').forEach((letter) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = letter;
                button.disabled = guessed.includes(letter) || mistakes >= 6 || !hasHiddenLetters;
                button.addEventListener('click', () => {
                    guessed.push(letter);
                    if (!hangmanWord.includes(letter)) {
                        mistakes++;
                    }
                    renderHangman();
                    const current = hangmanWord.split('').every((item) => !item.match(/[a-ząćęłńóśźż]/i) || guessed.includes(item));
                    if (current) {
                        document.getElementById('hangman-status').textContent = 'Wygrana!';
                    } else if (mistakes >= 6) {
                        document.getElementById('hangman-status').textContent = `Koniec gry. Hasło: ${hangmanWord}.`;
                    }
                });
                document.getElementById('hangman-letters').appendChild(button);
            });
        }

        document.getElementById('new-hangman').addEventListener('click', startHangman);
        startHangman();
    </script>
</body>
</html>
