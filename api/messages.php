<?php
require_once dirname(__DIR__) . '/includes/init.php';

$user = require_login();
$rid = (int) ($_GET['rid'] ?? 0);
$ref = fetch_one('SELECT * FROM referrals WHERE id = ?', [$rid]);
if (!$ref) {
    http_response_code(404);
    exit;
}

$allowed = false;
if ($user['role'] === 'consumer' && (int) $user['id'] === (int) $ref['consumer_id']) {
    $allowed = true;
}
if ($user['role'] === 'counsellor' && $user['counsellor'] && (int) $user['counsellor']['id'] === (int) $ref['counsellor_id']) {
    $allowed = true;
}
if (!$allowed || !in_array($ref['status'], ['acknowledged', 'contacted', 'ongoing'], true)) {
    http_response_code(403);
    exit;
}

$messages = fetch_all('SELECT * FROM messages WHERE referral_id = ? ORDER BY id ASC', [$rid]);
foreach ($messages as $m) {
    $mine = (int) $m['sender_id'] === (int) $user['id'];
    echo '<div class="bubble ' . ($mine ? 'me' : '') . '">';
    echo nl2br(e($m['body']));
    echo '<div class="small" style="opacity:.75">' . e(format_date($m['created_at'])) . '</div></div>';
}
