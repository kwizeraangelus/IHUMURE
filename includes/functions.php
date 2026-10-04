<?php

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    $path = ltrim($path, '/');
    $doc = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/'));
    $root = str_replace('\\', '/', ROOT);
    $base = '';
    if ($doc !== '' && str_starts_with($root, $doc)) {
        $base = substr($root, strlen($doc));
    }
    $base = rtrim($base, '/');
    return ($base === '' ? '' : $base) . '/' . $path;
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function redirect(string $path): void
{
    header('Location: ' . (str_starts_with($path, 'http') ? $path : url($path)));
    exit;
}

function flash(?string $key = null, ?string $message = null): ?array
{
    if ($key && $message !== null) {
        $_SESSION['flash'] = ['type' => $key, 'message' => $message];
        return null;
    }
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void
{
    $token = $_POST['csrf'] ?? '';
    if (!hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(400);
        exit('Invalid session. Please go back and try again.');
    }
}

function now(): string
{
    return date('Y-m-d H:i:s');
}

function generate_anon_code(): string
{
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    do {
        $code = 'IH-';
        for ($i = 0; $i < 6; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }
        $exists = db()->prepare('SELECT id FROM users WHERE anon_code = ?');
        $exists->execute([$code]);
    } while ($exists->fetch());
    return $code;
}

function generate_pin(): string
{
    return str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
}

function rwanda_districts(): array
{
    return [
        'Kigali City' => ['Gasabo', 'Kicukiro', 'Nyarugenge'],
        'Northern' => ['Burera', 'Gakenke', 'Gicumbi', 'Musanze', 'Rulindo'],
        'Southern' => ['Gisagara', 'Huye', 'Kamonyi', 'Muhanga', 'Nyamagabe', 'Nyanza', 'Nyaruguru', 'Ruhango'],
        'Eastern' => ['Bugesera', 'Gatsibo', 'Kayonza', 'Kirehe', 'Ngoma', 'Nyagatare', 'Rwamagana'],
        'Western' => ['Karongi', 'Ngororero', 'Nyabihu', 'Nyamasheke', 'Rubavu', 'Rusizi', 'Rutsiro'],
    ];
}

function district_options(?string $selected = null): string
{
    $html = '<option value="">Select district</option>';
    foreach (rwanda_districts() as $province => $districts) {
        $html .= '<optgroup label="' . e($province) . '">';
        foreach ($districts as $d) {
            $sel = $selected === $d ? ' selected' : '';
            $html .= '<option value="' . e($d) . '"' . $sel . '>' . e($d) . '</option>';
        }
        $html .= '</optgroup>';
    }
    return $html;
}

function audit_questions(): array
{
    $freq = [
        0 => 'Never',
        1 => 'Monthly or less',
        2 => '2–4 times a month',
        3 => '2–3 times a week',
        4 => '4 or more times a week',
    ];
    $freqYear = [
        0 => 'Never',
        1 => 'Less than monthly',
        2 => 'Monthly',
        3 => 'Weekly',
        4 => 'Daily or almost daily',
    ];
    $injury = [
        0 => 'No',
        2 => 'Yes, but not in the last year',
        4 => 'Yes, during the last year',
    ];

    return [
        1 => [
            'q' => 'How often do you have a drink containing alcohol?',
            'options' => $freq,
        ],
        2 => [
            'q' => 'How many drinks containing alcohol do you have on a typical day when you are drinking?',
            'options' => [
                0 => '1 or 2',
                1 => '3 or 4',
                2 => '5 or 6',
                3 => '7 to 9',
                4 => '10 or more',
            ],
        ],
        3 => [
            'q' => 'How often do you have six or more drinks on one occasion?',
            'options' => $freqYear,
        ],
        4 => [
            'q' => 'How often during the last year have you found that you were not able to stop drinking once you had started?',
            'options' => $freqYear,
        ],
        5 => [
            'q' => 'How often during the last year have you failed to do what was normally expected of you because of drinking?',
            'options' => $freqYear,
        ],
        6 => [
            'q' => 'How often during the last year have you needed a first drink in the morning to get yourself going after a heavy drinking session?',
            'options' => $freqYear,
        ],
        7 => [
            'q' => 'How often during the last year have you had a feeling of guilt or remorse after drinking?',
            'options' => $freqYear,
        ],
        8 => [
            'q' => 'How often during the last year have you been unable to remember what happened the night before because you had been drinking?',
            'options' => $freqYear,
        ],
        9 => [
            'q' => 'Have you or someone else been injured as a result of your drinking?',
            'options' => $injury,
        ],
        10 => [
            'q' => 'Has a relative, friend, doctor or other health worker been concerned about your drinking or suggested you cut down?',
            'options' => $injury,
        ],
    ];
}

function risk_zone(int $score): string
{
    if ($score <= 7) {
        return 'low';
    }
    if ($score <= 15) {
        return 'hazardous';
    }
    if ($score <= 19) {
        return 'harmful';
    }
    return 'dependence';
}

function risk_meta(string $zone): array
{
    return match ($zone) {
        'low' => [
            'label' => 'Low risk',
            'zone' => 'Zone I',
            'range' => '0–7',
            'class' => 'low',
            'headline' => 'Your score is in the low-risk range.',
            'advice' => 'Stay informed. Keep using awareness resources, and re-screen if your drinking pattern changes. No counsellor referral is required.',
        ],
        'hazardous' => [
            'label' => 'Hazardous',
            'zone' => 'Zone II',
            'range' => '8–15',
            'class' => 'hazardous',
            'headline' => 'Your drinking is in the hazardous range.',
            'advice' => 'Simple changes can reduce harm. Review the self-help tips below, and consider connecting with a counsellor if you want guided support.',
        ],
        'harmful' => [
            'label' => 'Harmful',
            'zone' => 'Zone III',
            'range' => '16–19',
            'class' => 'harmful',
            'headline' => 'Your score suggests harmful use of alcohol.',
            'advice' => 'We recommend speaking with a counsellor. You can choose a public, private or independent counsellor — your identity stays private until you share it.',
        ],
        default => [
            'label' => 'Likely dependence',
            'zone' => 'Zone IV',
            'range' => '20–40',
            'class' => 'dependence',
            'headline' => 'Your score suggests possible alcohol dependence.',
            'advice' => 'Please connect with a counsellor. Public facilities are listed first so you can access support without a fee. This is a screening result, not a diagnosis.',
        ],
    };
}

function self_help_tips(): array
{
    return [
        'Set a clear limit before you start drinking, and keep alcohol-free days each week.',
        'Tell one trusted person you are cutting down — accountability helps.',
        'Replace the first drink after work with tea, a walk, or a call to a friend.',
        'Avoid keeping alcohol at home if that makes it harder to stop.',
        'If you feel you cannot cut down alone, connect with a counsellor here — privately.',
        'In a crisis, go to the nearest health facility or call a trusted family member.',
    ];
}

function fetch_all(string $sql, array $params = []): array
{
    $st = db()->prepare($sql);
    $st->execute($params);
    return $st->fetchAll();
}

function fetch_one(string $sql, array $params = []): ?array
{
    $st = db()->prepare($sql);
    $st->execute($params);
    $row = $st->fetch();
    return $row ?: null;
}

function q(string $sql, array $params = []): PDOStatement
{
    $st = db()->prepare($sql);
    $st->execute($params);
    return $st;
}

function last_id(): string
{
    return db()->lastInsertId();
}

function format_date(?string $dt): string
{
    if (!$dt) {
        return '—';
    }
    $t = strtotime($dt);
    return $t ? date('d M Y, H:i', $t) : $dt;
}

function status_label(string $status): string
{
    return match ($status) {
        'submitted' => 'Submitted',
        'acknowledged' => 'Acknowledged',
        'contacted' => 'Contacted',
        'ongoing' => 'Ongoing',
        'closed' => 'Closed',
        'declined' => 'Declined',
        default => ucfirst($status),
    };
}

function category_label(string $cat): string
{
    return match ($cat) {
        'public' => 'Public facility',
        'private' => 'Private practice',
        'personal' => 'Independent counsellor',
        default => ucfirst($cat),
    };
}

function match_counsellors(string $riskZone, ?string $district = null): array
{
    $rows = fetch_all(
        "SELECT c.*, u.display_name, u.anon_code
         FROM counsellors c
         JOIN users u ON u.id = c.user_id
         WHERE c.verified = 1 AND c.active = 1
         ORDER BY c.id ASC"
    );

    foreach ($rows as &$r) {
        $score = 0;
        if ($district && strcasecmp($r['district'], $district) === 0) {
            $score += 25;
        }
        if ($riskZone === 'dependence' && $r['category'] === 'public') {
            $score += 20;
        }
        if (in_array($riskZone, ['harmful', 'hazardous'], true) && $r['category'] === 'personal') {
            $score += 8;
        }
        if ((float) $r['session_fee'] == 0) {
            $score += 5;
        }
        $r['match_score'] = $score;
    }
    unset($r);

    usort($rows, function ($a, $b) {
        return $b['match_score'] <=> $a['match_score'];
    });

    return $rows;
}

function consumer_referral_count(int $userId): int
{
    $st = db()->prepare("SELECT COUNT(*) FROM referrals WHERE consumer_id = ? AND status NOT IN ('declined','closed')");
    $st->execute([$userId]);
    return (int) $st->fetchColumn();
}

function ensure_upload_dirs(): void
{
    foreach (['certificates', 'videos'] as $sub) {
        $path = UPLOAD_DIR . DIRECTORY_SEPARATOR . $sub;
        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }
    }
}

function save_upload(array $file, string $subdir, array $allowed, int $maxBytes): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload failed. Please try a smaller file.');
    }
    if ($file['size'] > $maxBytes) {
        throw new RuntimeException('File is too large.');
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) {
        throw new RuntimeException('File type not allowed.');
    }
    ensure_upload_dirs();
    $name = bin2hex(random_bytes(8)) . '.' . $ext;
    $dest = UPLOAD_DIR . DIRECTORY_SEPARATOR . $subdir . DIRECTORY_SEPARATOR . $name;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        throw new RuntimeException('Could not store the uploaded file.');
    }
    return $subdir . '/' . $name;
}

function is_connected_to_counsellor(int $consumerId, int $counsellorId): bool
{
    $row = fetch_one(
        "SELECT id FROM referrals
         WHERE consumer_id = ? AND counsellor_id = ?
           AND status IN ('acknowledged','contacted','ongoing')",
        [$consumerId, $counsellorId]
    );
    return (bool) $row;
}

function active_nav(string $needle): string
{
    $uri = $_SERVER['SCRIPT_NAME'] ?? '';
    return str_contains($uri, $needle) ? ' active' : '';
}

function excerpt(string $text, int $len = 140): string
{
    $text = trim($text);
    if (strlen($text) <= $len) {
        return $text;
    }
    return rtrim(substr($text, 0, $len - 1)) . '...';
}
