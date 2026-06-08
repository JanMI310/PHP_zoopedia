<?php
require_once __DIR__ . '/functions.php';

$_SESSION = [];
session_destroy();

header('Location: ' . url_for('home'));
exit;
