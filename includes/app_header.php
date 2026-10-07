<?php
$user = current_user();
$flash = flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($page_title ?? 'Dashboard') ?> · <?= e(APP_NAME) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,650&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
</head>
<body>
<header class="site-header site-header-app" id="siteHeader">
  <div class="wrap nav-wrap">
    <a class="brand" href="<?= e(url('index.php')) ?>" aria-label="<?= e(APP_NAME) ?> Home">
      <div class="brand-mark">
        <svg class="brand-svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" fill="rgba(255,255,255,0.18)" stroke="#ffffff"/>
          <path d="M12 8v8M8 12h8" stroke="#ffffff" stroke-width="2.4"/>
        </svg>
      </div>
      <div class="brand-info">
        <div class="brand-name-wrap">
          <span class="brand-name"><?= e(APP_NAME) ?></span>
          <span class="app-role-pill"><?= e(ucfirst($user['role'] ?? 'portal')) ?></span>
        </div>
        <span class="brand-sub">Clinical &amp; Recovery Workspace</span>
      </div>
    </a>
    <div class="app-header-actions">
      <?php if (!empty($user['anon_code'])): ?>
        <div class="app-id-badge" title="Your Anonymous Healthcare ID (Protected)">
          <span class="app-id-pulse"></span>
          <span class="app-id-tag">ID:</span>
          <strong class="app-id-val"><?= e($user['anon_code']) ?></strong>
        </div>
      <?php endif; ?>
      <a class="btn-app-logout" href="<?= e(url('logout.php')) ?>" title="Sign out of workspace">
        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        <span>Sign out</span>
      </a>
    </div>
  </div>
</header>
<?php if ($flash): ?>
  <div class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>
<div class="app-shell">
  <aside class="side">
    <?php if (($user['role'] ?? '') === 'consumer'): ?>
      <a class="<?= active_nav('consumer/dashboard') ?>" href="<?= e(url('consumer/dashboard.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        <span>Overview</span>
      </a>
      <a class="<?= active_nav('screening') ?>" href="<?= e(url('screening.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        <span>New screening</span>
      </a>
      <a class="<?= active_nav('counsellors') ?>" href="<?= e(url('counsellors.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        <span>Find support</span>
      </a>
      <a class="<?= active_nav('consumer/chat') ?>" href="<?= e(url('consumer/chat.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        <span>Messages</span>
      </a>
      <a class="<?= active_nav('consumer/story') ?>" href="<?= e(url('consumer/story.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        <span>Recovery story</span>
      </a>
      <a class="<?= active_nav('consumer/group') ?>" href="<?= e(url('consumer/group.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
        <span>Group room</span>
      </a>
      <a class="<?= active_nav('awareness') ?>" href="<?= e(url('awareness.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
        <span>Awareness</span>
      </a>
    <?php elseif (($user['role'] ?? '') === 'counsellor'): ?>
      <a class="<?= active_nav('counsellor/dashboard') ?>" href="<?= e(url('counsellor/dashboard.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
        <span>Requests</span>
      </a>
      <a class="<?= active_nav('counsellor/chat') ?>" href="<?= e(url('counsellor/chat.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        <span>Messages</span>
      </a>
      <a class="<?= active_nav('counsellor/videos') ?>" href="<?= e(url('counsellor/videos.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
        <span>Guidance videos</span>
      </a>
      <a class="<?= active_nav('counsellor/profile') ?>" href="<?= e(url('counsellor/profile.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        <span>Profile</span>
      </a>
    <?php else: ?>
      <a class="<?= active_nav('admin/index') ?>" href="<?= e(url('admin/index.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        <span>Overview</span>
      </a>
      <a class="<?= active_nav('admin/counsellors') ?>" href="<?= e(url('admin/counsellors.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/></svg>
        <span>Verify counsellors</span>
      </a>
      <a class="<?= active_nav('admin/content') ?>" href="<?= e(url('admin/content.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        <span>Awareness content</span>
      </a>
      <a class="<?= active_nav('admin/referrals') ?>" href="<?= e(url('admin/referrals.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
        <span>Referrals</span>
      </a>
      <a class="<?= active_nav('admin/stories') ?>" href="<?= e(url('admin/stories.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        <span>Moderate stories</span>
      </a>
      <a class="<?= active_nav('admin/analytics') ?>" href="<?= e(url('admin/analytics.php')) ?>">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        <span>Analytics</span>
      </a>
    <?php endif; ?>
  </aside>
  <div class="main">
