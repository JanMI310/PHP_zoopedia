<?php
declare(strict_types=1);

require_once __DIR__ . '/db_connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function app_base_url(): string
{
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $base = rtrim(dirname($scriptName), '/');

    return $base === '' || $base === '.' ? '' : $base;
}

function asset_url(string $path): string
{
    return app_base_url() . '/' . ltrim($path, '/');
}

function url_for(string $page): string
{
    $routes = [
        'home' => 'strona-glowna',
        'search' => 'wyszukaj-artykul',
        'create' => 'utworz-artykul',
        'games' => 'gry',
        'quiz' => 'gry/quiz',
        'hangman' => 'gry/wisielec',
        'memory' => 'gry/memory',
        'forum' => 'forum',
        'login' => 'logowanie',
        'register' => 'rejestracja',
        'logout' => 'wyloguj',
        'admin_panel' => 'panel-admina',
    ];

    $path = $routes[$page] ?? $page . '.php';
    return asset_url($path);
}

function edit_article_url(string $slug): string
{
    return asset_url('edytuj-artykul/' . rawurlencode($slug));
}

function delete_article_url(string $slug): string
{
    return asset_url('usun-artykul/' . rawurlencode($slug));
}

function forum_topic_url(int $topicId): string
{
    return asset_url('forum/temat/' . $topicId);
}

function db(): mysqli
{
    global $conn;
    return $conn;
}

function render_nav(): void
{
    $user = current_user();
    ?>
    <header class="site-header">
        <nav class="nav">
            <a class="brand" href="<?= h(url_for('home')) ?>">Zoopedia</a>

            <div class="nav-links">
                <a href="<?= h(url_for('home')) ?>">Strona główna</a>
                <a href="<?= h(url_for('search')) ?>">Wyszukaj artykuł</a>

                <?php if ($user): ?>
                    <a href="<?= h(url_for('create')) ?>">Utwórz artykuł</a>
                    <a href="<?= h(url_for('games')) ?>">Gry</a>
                    <a href="<?= h(url_for('forum')) ?>">Forum</a>

                    <?php if (is_admin()): ?>
                        <a href="<?= h(url_for('admin_panel')) ?>">Panel admina</a>
                    <?php endif; ?>

                    <span class="user-badge"><?= h($user['login']) ?></span>
                    <a class="button secondary" href="<?= h(url_for('logout')) ?>">Wyloguj</a>
                <?php else: ?>
                    <a href="<?= h(url_for('register')) ?>">Rejestracja</a>
                    <a class="button" href="<?= h(url_for('login')) ?>">Logowanie</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <?php
}

function render_footer(): void
{
    ?>
    <footer class="site-footer">
        <div class="footer-inner">
            <div>
                <a class="footer-brand" href="<?= h(url_for('home')) ?>">Zoopedia</a>
                <p>Internetowa encyklopedia zwierząt, ciekawostek i działań na rzecz ochrony przyrody.</p>
            </div>

            <div class="footer-links">
                <a href="<?= h(url_for('search')) ?>">Artykuły</a>

                <?php if (is_logged_in()): ?>
                    <a href="<?= h(url_for('games')) ?>">Gry</a>
                    <a href="<?= h(url_for('forum')) ?>">Forum</a>
                <?php else: ?>
                    <a href="<?= h(url_for('login')) ?>">Logowanie</a>
                    <a href="<?= h(url_for('register')) ?>">Rejestracja</a>
                <?php endif; ?>
            </div>

            <p class="footer-copy">© <?= date('Y') ?> Zoopedia</p>
        </div>
    </footer>
    <?php
}

function animal_type_options(): array
{
    return [
        'ssak' => 'Ssak',
        'ptak' => 'Ptak',
        'ryba' => 'Ryba',
        'gad' => 'Gad',
        'plaz' => 'Płaz',
        'owad' => 'Owad',
    ];
}

function normalize_animal_type(string $type): string
{
    return array_key_exists($type, animal_type_options()) ? $type : 'ssak';
}

function animal_type_label(string $type): string
{
    return animal_type_options()[normalize_animal_type($type)];
}

function animal_template(string $type): array
{
    $templates = [
        'ssak' => [
            'class' => 'template-mammal',
            'label' => 'Ssak',
            'lead' => 'Ciepłokrwisty kręgowiec, zwykle karmiący młode mlekiem.',
            'accent' => 'Cechy ssaków',
        ],
        'ptak' => [
            'class' => 'template-bird',
            'label' => 'Ptak',
            'lead' => 'Zwierzę pokryte piórami, przystosowane do lotu lub życia naziemnego i wodnego.',
            'accent' => 'Cechy ptaków',
        ],
        'ryba' => [
            'class' => 'template-fish',
            'label' => 'Ryba',
            'lead' => 'Kręgowiec wodny oddychający skrzelami i poruszający się głównie za pomocą płetw.',
            'accent' => 'Cechy ryb',
        ],
        'gad' => [
            'class' => 'template-reptile',
            'label' => 'Gad',
            'lead' => 'Zmiennocieplny kręgowiec o łuskowatej skórze.',
            'accent' => 'Cechy gadów',
        ],
        'plaz' => [
            'class' => 'template-amphibian',
            'label' => 'Płaz',
            'lead' => 'Zwierzę związane z wodą i lądem.',
            'accent' => 'Cechy płazów',
        ],
        'owad' => [
            'class' => 'template-insect',
            'label' => 'Owad',
            'lead' => 'Bezkręgowiec o segmentowanym ciele i sześciu odnóżach.',
            'accent' => 'Cechy owadów',
        ],
    ];

    return $templates[normalize_animal_type($type)];
}

function template_description(string $type): string
{
    $descriptions = [
        'ssak' => 'Ssaki mają zwykle sierść lub włosy, oddychają płucami i opiekują się młodymi.',
        'ptak' => 'Ptaki wyróżniają pióra, dziób oraz składanie jaj.',
        'ryba' => 'Ryby żyją w wodzie, oddychają skrzelami i poruszają się za pomocą płetw.',
        'gad' => 'Gady są zmiennocieplne i często mają skórę pokrytą łuskami.',
        'plaz' => 'Płazy są silnie związane z wodą i często przechodzą przeobrażenie.',
        'owad' => 'Owady mają ciało podzielone na głowę, tułów i odwłok oraz trzy pary odnóży.',
    ];

    return $descriptions[normalize_animal_type($type)];
}

function load_articles(): array
{
    $result = mysqli_query(db(), "
        SELECT slug, title, animal_type, species, habitat, diet, content, image, created_at
        FROM articles
        ORDER BY created_at DESC, id DESC
    ");

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function add_article(array $article): void
{
    $articles = load_articles();
    $slug = unique_slug($article['title'], $articles);

    $title = (string) $article['title'];
    $animalType = normalize_animal_type((string) ($article['animal_type'] ?? 'ssak'));
    $species = (string) $article['species'];
    $habitat = (string) $article['habitat'];
    $diet = (string) $article['diet'];
    $content = (string) $article['content'];
    $image = $article['image'] ?? null;
    $createdAt = $article['created_at'] ?? date('Y-m-d');

    $stmt = mysqli_prepare(db(), "
        INSERT INTO articles 
        (slug, title, animal_type, species, habitat, diet, content, image, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param(
        $stmt,
        'sssssssss',
        $slug,
        $title,
        $animalType,
        $species,
        $habitat,
        $diet,
        $content,
        $image,
        $createdAt
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function create_slug(string $title): string
{
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $title);
    $slug = strtolower((string) $slug);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim((string) $slug, '-');

    return $slug !== '' ? $slug : 'artykul';
}

function unique_slug(string $title, array $articles): string
{
    $baseSlug = create_slug($title);
    $slug = $baseSlug;
    $counter = 2;
    $existing = array_column($articles, 'slug');

    while (in_array($slug, $existing, true)) {
        $slug = $baseSlug . '-' . $counter;
        $counter++;
    }

    return $slug;
}

function find_article(string $slug): ?array
{
    $stmt = mysqli_prepare(db(), "
        SELECT slug, title, animal_type, species, habitat, diet, content, image, created_at
        FROM articles
        WHERE slug = ?
    ");

    mysqli_stmt_bind_param($stmt, 's', $slug);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $article = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $article ?: null;
}

function update_article(string $currentSlug, array $article): ?string
{
    $existing = find_article($currentSlug);

    if (!$existing) {
        return null;
    }

    $title = (string) $article['title'];
    $animalType = normalize_animal_type((string) ($article['animal_type'] ?? 'ssak'));
    $species = (string) $article['species'];
    $habitat = (string) $article['habitat'];
    $diet = (string) $article['diet'];
    $content = (string) $article['content'];
    $image = $article['image'] ?? ($existing['image'] ?? null);

    $newSlug = create_slug($title);

    if ($newSlug !== $currentSlug) {
        $articles = array_filter(
            load_articles(),
            fn(array $item): bool => ($item['slug'] ?? '') !== $currentSlug
        );

        $newSlug = unique_slug($title, array_values($articles));
    }

    $stmt = mysqli_prepare(db(), "
        UPDATE articles
        SET slug = ?, title = ?, animal_type = ?, species = ?, habitat = ?, diet = ?, content = ?, image = ?
        WHERE slug = ?
    ");

    mysqli_stmt_bind_param(
        $stmt,
        'sssssssss',
        $newSlug,
        $title,
        $animalType,
        $species,
        $habitat,
        $diet,
        $content,
        $image,
        $currentSlug
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $newSlug;
}

function delete_article(string $slug): bool
{
    $article = find_article($slug);

    $stmt = mysqli_prepare(db(), "DELETE FROM articles WHERE slug = ?");
    mysqli_stmt_bind_param($stmt, 's', $slug);
    mysqli_stmt_execute($stmt);

    $deleted = mysqli_stmt_affected_rows($stmt) > 0;
    mysqli_stmt_close($stmt);

    if ($deleted && !empty($article['image'])) {
        $path = __DIR__ . '/uploads/' . $article['image'];

        if (file_exists($path)) {
            unlink($path);
        }
    }

    return $deleted;
}

function search_articles(string $query): array
{
    $query = trim($query);

    if ($query === '') {
        return load_articles();
    }

    $like = '%' . $query . '%';

    $stmt = mysqli_prepare(db(), "
        SELECT slug, title, animal_type, species, habitat, diet, content, image, created_at
        FROM articles
        WHERE title LIKE ?
           OR animal_type LIKE ?
           OR species LIKE ?
           OR habitat LIKE ?
           OR diet LIKE ?
           OR content LIKE ?
        ORDER BY created_at DESC, id DESC
    ");

    mysqli_stmt_bind_param($stmt, 'ssssss', $like, $like, $like, $like, $like, $like);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $articles = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);

    return $articles;
}

function article_excerpt(string $content, int $length = 160): string
{
    $content = trim(strip_tags($content));

    if (mb_strlen($content) <= $length) {
        return $content;
    }

    return mb_substr($content, 0, $length) . '...';
}

function current_user(): ?array
{
    if (!isset($_SESSION['user_id'])) {
        return null;
    }

    return [
        'id' => (int) $_SESSION['user_id'],
        'login' => (string) ($_SESSION['login'] ?? ''),
        'role' => (int) ($_SESSION['role'] ?? 0),
    ];
}

function is_logged_in(): bool
{
    return current_user() !== null;
}

function is_admin(): bool
{
    return (int) ($_SESSION['role'] ?? 0) === 1;
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: ' . url_for('login'));
        exit;
    }
}

function require_admin(): void
{
    require_login();

    if (!is_admin()) {
        header('Location: ' . url_for('home'));
        exit;
    }
}

function find_user_by_login(string $login): ?array
{
    $stmt = mysqli_prepare(db(), "
        SELECT id, login, password_hash, role, created_at
        FROM users
        WHERE login = ?
    ");

    mysqli_stmt_bind_param($stmt, 's', $login);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $user ?: null;
}

function register_user(string $login, string $password): array
{
    $login = trim($login);

    if (mb_strlen($login) < 3) {
        return ['success' => false, 'message' => 'Login musi mieć co najmniej 3 znaki.'];
    }

    if (mb_strlen($password) < 4) {
        return ['success' => false, 'message' => 'Hasło musi mieć co najmniej 4 znaki.'];
    }

    if (find_user_by_login($login)) {
        return ['success' => false, 'message' => 'Użytkownik o takim loginie już istnieje.'];
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = 0;

    $stmt = mysqli_prepare(db(), "
        INSERT INTO users (login, password_hash, role)
        VALUES (?, ?, ?)
    ");

    mysqli_stmt_bind_param($stmt, 'ssi', $login, $hash, $role);
    mysqli_stmt_execute($stmt);

    $id = mysqli_insert_id(db());
    mysqli_stmt_close($stmt);

    $_SESSION['user_id'] = $id;
    $_SESSION['login'] = $login;
    $_SESSION['role'] = $role;

    return ['success' => true, 'message' => 'Konto zostało utworzone.'];
}

function login_user(string $login, string $password): bool
{
    $user = find_user_by_login(trim($login));

    if (!$user || !password_verify($password, $user['password_hash'] ?? '')) {
        return false;
    }

    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['login'] = $user['login'];
    $_SESSION['role'] = (int) $user['role'];

    return true;
}

function load_users(): array
{
    $result = mysqli_query(db(), "
        SELECT id, login, role, created_at
        FROM users
        ORDER BY created_at DESC, id DESC
    ");

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function role_label(int $role): string
{
    return $role === 1 ? 'Administrator' : 'Użytkownik';
}

function load_forum_topics(): array
{
    $result = mysqli_query(db(), "
        SELECT id, title, content, author_login, created_at
        FROM forum_topics
        ORDER BY created_at DESC, id DESC
    ");

    $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($topics as &$topic) {
        $topic['comments'] = load_forum_comments((int) $topic['id']);
    }

    return $topics;
}

function find_forum_topic(int $topicId): ?array
{
    $stmt = mysqli_prepare(db(), "
        SELECT id, title, content, author_login, created_at
        FROM forum_topics
        WHERE id = ?
    ");

    mysqli_stmt_bind_param($stmt, 'i', $topicId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $topic = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    if (!$topic) {
        return null;
    }

    $topic['comments'] = load_forum_comments((int) $topic['id']);

    return $topic;
}

function load_forum_comments(int $topicId): array
{
    $stmt = mysqli_prepare(db(), "
        SELECT id, author_login, content, created_at
        FROM forum_comments
        WHERE topic_id = ?
        ORDER BY created_at ASC, id ASC
    ");

    mysqli_stmt_bind_param($stmt, 'i', $topicId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);

    return $comments;
}

function add_forum_topic(string $title, string $content, array $user): void
{
    $userId = (int) $user['id'];
    $login = (string) $user['login'];

    $stmt = mysqli_prepare(db(), "
        INSERT INTO forum_topics (title, content, author_id, author_login)
        VALUES (?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param($stmt, 'ssis', $title, $content, $userId, $login);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function add_forum_comment(string $topicId, string $content, array $user): bool
{
    $topicIdInt = (int) $topicId;

    $stmt = mysqli_prepare(db(), "
        SELECT id
        FROM forum_topics
        WHERE id = ?
    ");

    mysqli_stmt_bind_param($stmt, 'i', $topicIdInt);
    mysqli_stmt_execute($stmt);

    $exists = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if (!$exists) {
        return false;
    }

    $userId = (int) $user['id'];
    $login = (string) $user['login'];

    $stmt = mysqli_prepare(db(), "
        INSERT INTO forum_comments (topic_id, author_id, author_login, content)
        VALUES (?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param($stmt, 'iiss', $topicIdInt, $userId, $login, $content);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return true;
}

function delete_forum_comment(int $commentId): bool
{
    $stmt = mysqli_prepare(db(), "
        DELETE FROM forum_comments
        WHERE id = ?
    ");

    mysqli_stmt_bind_param($stmt, 'i', $commentId);
    mysqli_stmt_execute($stmt);

    $deleted = mysqli_stmt_affected_rows($stmt) > 0;
    mysqli_stmt_close($stmt);

    return $deleted;
}

function delete_user(int $userId): bool
{
    $currentUser = current_user();

    if ($currentUser && (int) $currentUser['id'] === $userId) {
        return false;
    }

    $stmt = mysqli_prepare(db(), "
        DELETE FROM users
        WHERE id = ?
    ");

    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);

    $deleted = mysqli_stmt_affected_rows($stmt) > 0;
    mysqli_stmt_close($stmt);

    return $deleted;
}