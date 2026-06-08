<?php
require_once __DIR__ . '/functions.php';
require_admin();

$userId = (int) ($_GET['id'] ?? 0);

if ($userId > 0) {
    ban_user($userId);
}

header('Location: ' . url_for('admin_panel'));
exit;