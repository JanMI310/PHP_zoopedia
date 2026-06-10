<?php
require_once __DIR__ . '/functions.php';
require_admin();

$commentId = (int) ($_POST['comment_id'] ?? 0);
$topicId = (int) ($_POST['topic_id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $commentId > 0) {
    delete_forum_comment($commentId);
}

$redirectUrl = $topicId > 0 ? forum_topic_url($topicId) : url_for('forum');

header('Location: ' . $redirectUrl);
exit;
