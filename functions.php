<?php
declare(strict_types=1);

const ARTICLES_FILE = __DIR__ . '/data/articles.json';

function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function load_articles(): array
{
    if (!file_exists(ARTICLES_FILE)) {
        return [];
    }

    $json = file_get_contents(ARTICLES_FILE);
    $articles = json_decode($json ?: '[]', true);

    return is_array($articles) ? $articles : [];
}

function save_articles(array $articles): void
{
    $directory = dirname(ARTICLES_FILE);

    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    file_put_contents(
        ARTICLES_FILE,
        json_encode(array_values($articles), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    );
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
    foreach (load_articles() as $article) {
        if (($article['slug'] ?? '') === $slug) {
            return $article;
        }
    }

    return null;
}

function search_articles(string $query): array
{
    $query = mb_strtolower(trim($query));

    if ($query === '') {
        return load_articles();
    }

    return array_values(array_filter(load_articles(), function (array $article) use ($query): bool {
        $haystack = mb_strtolower(implode(' ', [
            $article['title'] ?? '',
            $article['species'] ?? '',
            $article['habitat'] ?? '',
            $article['diet'] ?? '',
            $article['content'] ?? '',
        ]));

        return str_contains($haystack, $query);
    }));
}

function article_excerpt(string $content, int $length = 160): string
{
    $content = trim(strip_tags($content));

    if (mb_strlen($content) <= $length) {
        return $content;
    }

    return mb_substr($content, 0, $length) . '...';
}
