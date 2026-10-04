<?php
require_once __DIR__ . '/includes/init.php';

$user = current_user();

if (isset($_GET['cert'])) {
    require_login('admin');
    $c = fetch_one('SELECT * FROM counsellors WHERE id = ?', [(int) $_GET['cert']]);
    if (!$c || !$c['certificate_file']) {
        http_response_code(404);
        exit('Not found');
    }
    $path = UPLOAD_DIR . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $c['certificate_file']);
    serve_file($path);
}

if (isset($_GET['v'])) {
    $v = fetch_one('SELECT * FROM videos WHERE id = ?', [(int) $_GET['v']]);
    if (!$v) {
        http_response_code(404);
        exit('Not found');
    }
    $ok = (int) $v['is_public'] === 1;
    if ($user) {
        if ($user['role'] === 'admin') {
            $ok = true;
        }
        if ($user['role'] === 'counsellor' && $user['counsellor'] && (int) $user['counsellor']['id'] === (int) $v['counsellor_id']) {
            $ok = true;
        }
        if ($user['role'] === 'consumer' && is_connected_to_counsellor((int) $user['id'], (int) $v['counsellor_id'])) {
            $ok = true;
        }
    }
    if (!$ok) {
        http_response_code(403);
        exit('Private video');
    }
    $path = UPLOAD_DIR . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $v['file_path']);
    serve_file($path);
}

http_response_code(400);
exit('Bad request');

function serve_file(string $path): void
{
    $realBase = realpath(UPLOAD_DIR);
    $real = realpath($path);
    if (!$realBase || !$real || !str_starts_with($real, $realBase) || !is_file($real)) {
        http_response_code(404);
        exit('Not found');
    }
    $ext = strtolower(pathinfo($real, PATHINFO_EXTENSION));
    $types = [
        'pdf' => 'application/pdf',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'mp4' => 'video/mp4',
        'webm' => 'video/webm',
    ];
    header('Content-Type: ' . ($types[$ext] ?? 'application/octet-stream'));
    header('X-Content-Type-Options: nosniff');
    readfile($real);
    exit;
}
