<?php
require_once __DIR__ . '/functions.php';
require_login();
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz - Zoopedia</title>
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body class="games-page">
    <?php render_nav(); ?>

    <main class="page">
        <section class="section">
            <a class="text-link" href="<?= h(url_for('games')) ?>">Wróć do wyboru gier</a>
            <section class="game-panel active standalone-game">
                <h1>Quiz</h1>
                <div class="quiz-scorebar">
                    <span id="quiz-progress">Pytanie 1/10</span>
                    <span id="quiz-score">Punkty: 0</span>
                </div>
                <p id="quiz-question" class="game-question"></p>
                <div id="quiz-options" class="option-grid"></div>
                <p id="quiz-result" class="game-result"></p>
                <button type="button" id="next-question">Następne pytanie</button>
                <button type="button" id="restart-quiz" class="secondary quiz-hidden">Zagraj ponownie</button>
            </section>
        </section>
    </main>

    <?php render_footer(); ?>

    <script>
        const quiz = [
            {
                question: 'Które zwierzę jest największym pingwinem?',
                answers: ['Pingwin cesarski', 'Pingwin białobrewy', 'Pingwin mały'],
                correct: 'Pingwin cesarski'
            },
            {
                question: 'Jak nazywa się naukowo lew afrykański?',
                answers: ['Panthera leo', 'Aptenodytes forsteri', 'Chelonoidis niger'],
                correct: 'Panthera leo'
            },
            {
                question: 'Które zwierzę żyje na Wyspach Galapagos?',
                answers: ['Żółw galapagoski', 'Wilk szary', 'Tygrys bengalski'],
                correct: 'Żółw galapagoski'
            },
            {
                question: 'Które zwierzę jest najszybszym lądowym sprinterem?',
                answers: ['Gepard', 'Wilk szary', 'Hipopotam'],
                correct: 'Gepard'
            },
            {
                question: 'Czym głównie żywi się panda wielka?',
                answers: ['Bambusem', 'Rybami', 'Owocami morza'],
                correct: 'Bambusem'
            },
            {
                question: 'Które zwierzę jest owadem społecznym?',
                answers: ['Pszczoła miodna', 'Kameleon jemeński', 'Rekin biały'],
                correct: 'Pszczoła miodna'
            },
            {
                question: 'Które zwierzę oddycha skrzelami?',
                answers: ['Konik morski', 'Koala', 'Sowa płomykówka'],
                correct: 'Konik morski'
            },
            {
                question: 'Który gatunek jest płazem?',
                answers: ['Żaba trawna', 'Orzeł przedni', 'Nosorożec biały'],
                correct: 'Żaba trawna'
            },
            {
                question: 'Które zwierzę słynie z bardzo długiej szyi?',
                answers: ['Żyrafa', 'Lis rudy', 'Krokodyl nilowy'],
                correct: 'Żyrafa'
            },
            {
                question: 'Które zwierzę jest największym przedstawicielem delfinowatych?',
                answers: ['Orka', 'Delfin butlonosy', 'Rekin biały'],
                correct: 'Orka'
            }
        ];
        let quizIndex = 0;
        let score = 0;
        let answered = false;

        const progress = document.getElementById('quiz-progress');
        const scoreLabel = document.getElementById('quiz-score');
        const questionEl = document.getElementById('quiz-question');
        const optionsEl = document.getElementById('quiz-options');
        const resultEl = document.getElementById('quiz-result');
        const nextButton = document.getElementById('next-question');
        const restartButton = document.getElementById('restart-quiz');

        function renderQuiz() {
            const item = quiz[quizIndex];
            answered = false;
            progress.textContent = `Pytanie ${quizIndex + 1}/${quiz.length}`;
            scoreLabel.textContent = `Punkty: ${score}`;
            questionEl.textContent = item.question;
            resultEl.textContent = 'Wybierz jedną odpowiedź.';
            optionsEl.innerHTML = '';
            nextButton.disabled = true;
            nextButton.textContent = quizIndex === quiz.length - 1 ? 'Zobacz wynik' : 'Następne pytanie';
            nextButton.classList.remove('quiz-hidden');
            restartButton.classList.add('quiz-hidden');

            item.answers.forEach((answer) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = answer;
                button.addEventListener('click', () => {
                    if (answered) {
                        return;
                    }

                    answered = true;
                    const correct = answer === item.correct;

                    if (correct) {
                        score++;
                    }

                    scoreLabel.textContent = `Punkty: ${score}`;
                    resultEl.textContent = correct
                        ? 'Dobra odpowiedź! +1 punkt'
                        : `Nie tym razem. Poprawna odpowiedź: ${item.correct}.`;

                    [...optionsEl.children].forEach((option) => {
                        option.disabled = true;
                        if (option.textContent === item.correct) {
                            option.classList.add('answer-correct');
                        }
                    });

                    if (!correct) {
                        button.classList.add('answer-wrong');
                    }

                    nextButton.disabled = false;
                });
                optionsEl.appendChild(button);
            });
        }

        function renderSummary() {
            progress.textContent = 'Koniec quizu';
            scoreLabel.textContent = `Punkty: ${score}/${quiz.length}`;
            questionEl.textContent = `Twój wynik: ${score} z ${quiz.length}`;
            optionsEl.innerHTML = '';
            resultEl.textContent = score >= 8
                ? 'Świetny wynik, Zoopedia może być dumna.'
                : score >= 5
                    ? 'Całkiem dobrze. Jeszcze kilka artykułów i będzie mocno.'
                    : 'Warto zajrzeć do artykułów i spróbować ponownie.';
            nextButton.classList.add('quiz-hidden');
            restartButton.classList.remove('quiz-hidden');
        }

        nextButton.addEventListener('click', () => {
            if (quizIndex >= quiz.length - 1) {
                renderSummary();
                return;
            }

            quizIndex++;
            renderQuiz();
        });

        restartButton.addEventListener('click', () => {
            quizIndex = 0;
            score = 0;
            renderQuiz();
        });

        renderQuiz();
    </script>
</body>
</html>
