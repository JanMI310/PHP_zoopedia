<?php
require_once __DIR__ . '/functions.php';
require_login();
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Memory - Zoopedia</title>
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body class="games-page">
    <?php render_nav(); ?>

    <main class="page">
        <section class="section">
            <a class="text-link" href="<?= h(url_for('games')) ?>">Wróć do wyboru gier</a>
            <section class="game-panel active standalone-game">
                <h1>Memory</h1>
                <p class="game-question">Znajdź wszystkie pary zwierząt.</p>
                <div class="quiz-scorebar memory-scorebar">
                    <span id="memory-turns">Tury: 0</span>
                    <span id="memory-pairs">Pary: 0/6</span>
                </div>
                <p id="memory-status" class="game-result"></p>
                <div id="memory-board" class="memory-board"></div>
                <button type="button" id="new-memory">Nowa gra</button>
            </section>
        </section>
    </main>

    <?php render_footer(); ?>

    <script>
        const memoryAnimals = [
            {
                name: 'Lew',
                image: 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=420&q=80'
            },
            {
                name: 'Słoń',
                image: 'https://images.unsplash.com/photo-1557050543-4d5f4e07ef46?auto=format&fit=crop&w=420&q=80'
            },
            {
                name: 'Żółw',
                image: 'https://images.unsplash.com/photo-1437622368342-7a3d73a34c8f?auto=format&fit=crop&w=420&q=80'
            },
            {
                name: 'Delfin',
                image: 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=420&q=80'
            },
            {
                name: 'Lis',
                image: 'https://images.unsplash.com/photo-1474511320723-9a56873867b5?auto=format&fit=crop&w=420&q=80'
            },
            {
                name: 'Koala',
                image: 'https://images.unsplash.com/photo-1459262838948-3e2de6c1ec80?auto=format&fit=crop&w=420&q=80'
            }
        ];
        let firstCard = null;
        let locked = false;
        let matched = 0;
        let turns = 0;

        const turnsLabel = document.getElementById('memory-turns');
        const pairsLabel = document.getElementById('memory-pairs');

        function startMemory() {
            const cards = [...memoryAnimals, ...memoryAnimals]
                .map((animal) => ({ ...animal, sort: Math.random() }))
                .sort((a, b) => a.sort - b.sort);
            const board = document.getElementById('memory-board');
            board.innerHTML = '';
            firstCard = null;
            locked = false;
            matched = 0;
            turns = 0;
            updateMemoryStats();
            document.getElementById('memory-status').textContent = 'Odkryj pierwszą kartę.';

            cards.forEach((card) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'memory-card';
                button.dataset.animal = card.name;
                button.dataset.image = card.image;
                button.setAttribute('aria-label', `Karta ${card.name}`);
                button.innerHTML = '<span class="memory-cover">?</span>';
                button.addEventListener('click', () => flipCard(button));
                board.appendChild(button);
            });
        }

        function updateMemoryStats() {
            turnsLabel.textContent = `Tury: ${turns}`;
            pairsLabel.textContent = `Pary: ${matched / 2}/${memoryAnimals.length}`;
        }

        function revealCard(card) {
            card.innerHTML = `<img src="${card.dataset.image}" alt="${card.dataset.animal}"><span>${card.dataset.animal}</span>`;
            card.classList.add('revealed');
        }

        function hideCard(card) {
            card.innerHTML = '<span class="memory-cover">?</span>';
            card.classList.remove('revealed');
        }

        function flipCard(card) {
            if (locked || card.classList.contains('matched') || card === firstCard) {
                return;
            }

            revealCard(card);

            if (!firstCard) {
                firstCard = card;
                return;
            }

            turns++;
            updateMemoryStats();

            if (firstCard.dataset.animal === card.dataset.animal) {
                firstCard.classList.add('matched');
                card.classList.add('matched');
                firstCard = null;
                matched += 2;
                updateMemoryStats();
                document.getElementById('memory-status').textContent = matched === memoryAnimals.length * 2
                    ? `Wszystkie pary znalezione w ${turns} turach!`
                    : 'Para znaleziona.';
                return;
            }

            locked = true;
            document.getElementById('memory-status').textContent = 'To nie para.';
            setTimeout(() => {
                hideCard(firstCard);
                hideCard(card);
                firstCard = null;
                locked = false;
            }, 850);
        }

        document.getElementById('new-memory').addEventListener('click', startMemory);
        startMemory();
    </script>
</body>
</html>
