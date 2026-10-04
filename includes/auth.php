<?php

function current_user(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }
    static $cached = false;
    static $user = null;
    if ($cached) {
        return $user;
    }
    $user = fetch_one('SELECT * FROM users WHERE id = ?', [$_SESSION['user_id']]);
    $cached = true;
    if ($user && $user['role'] === 'counsellor') {
        $user['counsellor'] = fetch_one('SELECT * FROM counsellors WHERE user_id = ?', [$user['id']]);
    }
    return $user;
}

function require_login(?string $role = null): array
{
    $user = current_user();
    if (!$user) {
        flash('info', 'Please sign in or continue with your private ID.');
        redirect('login.php');
    }
    if ($role && $user['role'] !== $role) {
        flash('error', 'You do not have access to that page.');
        redirect(home_for($user));
    }
    return $user;
}

function home_for(array $user): string
{
    return match ($user['role']) {
        'admin' => 'admin/index.php',
        'counsellor' => 'counsellor/dashboard.php',
        default => 'consumer/dashboard.php',
    };
}

function login_user(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['role'] = $user['role'];
}

function logout_user(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}

function create_anonymous_consumer(?string $district = null): array
{
    $code = generate_anon_code();
    $pin = generate_pin();
    q(
        'INSERT INTO users (anon_code, role, pin_hash, district, display_name) VALUES (?,?,?,?,?)',
        [$code, 'consumer', password_hash($pin, PASSWORD_DEFAULT), $district, 'Anonymous']
    );
    $user = fetch_one('SELECT * FROM users WHERE id = ?', [last_id()]);
    login_user($user);
    $_SESSION['shown_pin'] = $pin;
    $_SESSION['shown_code'] = $code;
    return $user;
}

function ensure_consumer_identity(): array
{
    $user = current_user();
    if ($user && $user['role'] === 'consumer') {
        return $user;
    }
    if ($user) {
        flash('error', 'Counsellor and admin accounts cannot take the screening. Use a private ID instead.');
        redirect(home_for($user));
    }
    flash('info', 'Create a private ID first. We use it to save your score and assign a counsellor — without your name.');
    redirect('start.php');
}
