<?php
require_once __DIR__ . '/functions.php';
require_admin();

$slug = $_GET['slug'] ?? '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: article.php?slug=' . urlencode($slug));
    exit;
}

delete_article($slug);

header('Location: ' . url_for('search'));
exit;