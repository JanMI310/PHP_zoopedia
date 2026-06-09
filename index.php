<?php
require_once __DIR__ . '/functions.php';

$articles = load_articles();
usort($articles, fn(array $a, array $b): int => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
$randomArticle = !empty($articles) ? $articles[array_rand($articles)] : null;
$featuredArticles = $articles;
shuffle($featuredArticles);
$featuredArticles = array_slice($featuredArticles, 0, 4);
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zoopedia - internetowa encyklopedia zwierząt</title>
    <link rel="stylesheet" href="<?= h(asset_url('style.css')) ?>">
</head>
<body>
    <?php render_nav(); ?>

    <main>
        <section class="hero home-hero">
            <div class="home-hero-inner">
                <div class="hero-copy">
                    <p class="eyebrow">Internetowa encyklopedia zwierząt</p>
                    <h1>Odkrywaj gatunki, siedliska i ciekawostki ze świata fauny.</h1>
                    <p>Przeglądaj artykuły o zwierzętach, wyszukuj informacje i dodawaj własne wpisy do Zoopedii.</p>
                    <form class="search-bar" action="<?= h(url_for('search')) ?>" method="get">
                        <input type="search" name="q" placeholder="Wpisz nazwę zwierzęcia, gatunek lub środowisko">
                        <button type="submit">Szukaj</button>
                    </form>
                </div>
                <div class="hero-photo-grid" aria-label="Zdjęcia zwierząt">
                    <img class="hero-photo hero-photo-large" src="https://images.unsplash.com/photo-1614027164847-1b28cfe1df60?auto=format&fit=crop&w=700&h=900&q=80" alt="Lew na sawannie">
                    <img class="hero-photo hero-photo-bird" src="https://images.unsplash.com/photo-1522926193341-e9ffd686c60f?auto=format&fit=crop&w=500&q=80" alt="Kolorowy ptak">
                    <img class="hero-photo" src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=500&q=80" alt="Podwodne życie">
                </div>
            </div>
        </section>

        <section class="section home-dashboard">
            <div class="home-feature-grid">
                <article class="home-feature-card fact-card">
                    <img class="feature-image" src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80" alt="Zielony krajobraz natury">
                    <p class="eyebrow">Losowa ciekawostka</p>
                    <?php if ($randomArticle): ?>
                        <h2><?= h($randomArticle['title']) ?></h2>
                        <p><?= h(article_excerpt($randomArticle['content'] ?? '', 210)) ?></p>
                        <a class="text-link" href="article.php?slug=<?= urlencode($randomArticle['slug']) ?>">Czytaj artykuł</a>
                    <?php else: ?>
                        <h2>Jeszcze bez ciekawostek</h2>
                        <p>Dodaj pierwszy artykuł, a Zoopedia zacznie losować ciekawostki ze zgromadzonych wpisów.</p>
                    <?php endif; ?>
                </article>

                <article class="home-feature-card">
                    <img class="feature-image feature-image-bird" src="https://images.unsplash.com/photo-1522926193341-e9ffd686c60f?auto=format&fit=crop&w=900&q=80" alt="Kolorowy ptak na gałęzi">
                    <p class="eyebrow">Aktualności</p>
                    <h2>Tydzień obserwacji ptaków</h2>
                    <p>W tym tygodniu zachęcamy do notowania gatunków zauważonych w parkach, ogrodach i przy szkolnych podwórkach.</p>
                    <span class="home-tag">Edukacja</span>
                </article>

                <article class="home-feature-card">
                    <img class="feature-image feature-image-nest" src="https://images.unsplash.com/photo-1520808663317-647b476a81b9?auto=format&fit=crop&w=900&q=80" alt="Ptak w budce lęgowej">
                    <p class="eyebrow">Ochrona zwierząt</p>
                    <h2>Zbiórka na budki lęgowe</h2>
                    <p>Trwa akcja wspierająca zakup materiałów na budki dla małych ptaków oraz domki dla owadów zapylających.</p>
                    <span class="home-tag">Zbiórka</span>
                </article>
            </div>

            <div class="news-strip">
                <div>
                    <strong>Mini alert</strong>
                    <span>Nie dokarmiaj dzikich zwierząt przypadkowym jedzeniem.</span>
                </div>
                <div>
                    <strong>Wolontariat</strong>
                    <span>Schroniska i fundacje często potrzebują karmy, koców oraz pomocy przy spacerach.</span>
                </div>
                <div>
                    <strong>Warto wiedzieć</strong>
                    <span>Owady zapylające odpowiadają za rozwój wielu roślin owocowych i warzywnych.</span>
                </div>
            </div>
        </section>

        <section class="section naturalists-section">
            <div class="section-title">
                <h2>Przyrodnicy, którzy inspirują</h2>
                <p class="results-count">Znani popularyzatorzy ochrony zwierząt i świata przyrody.</p>
            </div>

            <div class="naturalist-grid">
                <article class="naturalist-card">
                    <img src="https://commons.wikimedia.org/wiki/Special:FilePath/David_Attenborough.jpg?width=700" alt="Sir David Attenborough">
                    <div>
                        <p class="eyebrow">Dokumentalista</p>
                        <h3>Sir David Attenborough</h3>
                        <p>Jeden z najbardziej rozpoznawalnych narratorów filmów przyrodniczych. Od dekad pokazuje widzom bogactwo życia na Ziemi i potrzebę ochrony ekosystemów.</p>
                    </div>
                </article>

                <article class="naturalist-card">
                    <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Steve_Irwin.jpg?width=700" alt="Steve Irwin">
                    <div>
                        <p class="eyebrow">Obrońca dzikiej przyrody</p>
                        <h3>Steve Irwin</h3>
                        <p>Australijski popularyzator przyrody znany z ogromnej energii i pracy z gadami. Zachęcał do szacunku wobec zwierząt, także tych budzących strach.</p>
                    </div>
                </article>

                <article class="naturalist-card">
                    <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Jane_Goodall_2015.jpg?width=700" alt="Jane Goodall">
                    <div>
                        <p class="eyebrow">Prymatolożka</p>
                        <h3>Jane Goodall</h3>
                        <p>Badaczka szympansów, która zmieniła sposób myślenia o zachowaniach naczelnych. Jej działalność łączy naukę, edukację i ochronę przyrody.</p>
                    </div>
                </article>
            </div>
        </section>

        <section class="section">
            <div class="section-title">
                <h2>Losowe artykuły</h2>
                <?php if (is_logged_in()): ?>
                    <a href="<?= h(url_for('create')) ?>">Dodaj nowy wpis</a>
                <?php else: ?>
                    <a href="<?= h(url_for('login')) ?>">Zaloguj się, aby dodać wpis</a>
                <?php endif; ?>
            </div>

            <?php if (empty($featuredArticles)): ?>
                <p class="empty">Brak artykułów. Utwórz pierwszy wpis w encyklopedii.</p>
            <?php else: ?>
                <div class="article-grid">
                    <?php foreach ($featuredArticles as $article): ?>
                        <article class="article-card">
                            <span class="type-pill type-<?= h(normalize_animal_type($article['animal_type'] ?? 'ssak')) ?>">
                                <?= h(animal_type_label($article['animal_type'] ?? 'ssak')) ?>
                            </span>
                            <p class="meta"><?= h($article['species'] ?? 'Nieznany gatunek') ?></p>
                            <h3><a href="article.php?slug=<?= urlencode($article['slug']) ?>"><?= h($article['title']) ?></a></h3>
                            <p><?= h(article_excerpt($article['content'] ?? '')) ?></p>
                            <dl>
                                <div>
                                    <dt>Środowisko</dt>
                                    <dd><?= h($article['habitat'] ?? '-') ?></dd>
                                </div>
                                <div>
                                    <dt>Dieta</dt>
                                    <dd><?= h($article['diet'] ?? '-') ?></dd>
                                </div>
                            </dl>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
    <?php render_footer(); ?>
</body>
</html>
