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
      <a class="<?= active_nav('consumer/dashboard') ?>" href="<?= e(url('consumer/dashboard.php')) ?>">Overview</a>
      <a class="<?= active_nav('screening') ?>" href="<?= e(url('screening.php')) ?>">New screening</a>
      <a class="<?= active_nav('counsellors') ?>" href="<?= e(url('counsellors.php')) ?>">Find support</a>
      <a class="<?= active_nav('consumer/chat') ?>" href="<?= e(url('consumer/chat.php')) ?>">Messages</a>
      <a class="<?= active_nav('consumer/story') ?>" href="<?= e(url('consumer/story.php')) ?>">Recovery story</a>
      <a class="<?= active_nav('consumer/group') ?>" href="<?= e(url('consumer/group.php')) ?>">Group room</a>
      <a class="<?= active_nav('awareness') ?>" href="<?= e(url('awareness.php')) ?>">Awareness</a>
    <?php elseif (($user['role'] ?? '') === 'counsellor'): ?>
      <a class="<?= active_nav('counsellor/dashboard') ?>" href="<?= e(url('counsellor/dashboard.php')) ?>">Requests</a>
      <a class="<?= active_nav('counsellor/chat') ?>" href="<?= e(url('counsellor/chat.php')) ?>">Messages</a>
      <a class="<?= active_nav('counsellor/videos') ?>" href="<?= e(url('counsellor/videos.php')) ?>">Guidance videos</a>
      <a class="<?= active_nav('counsellor/profile') ?>" href="<?= e(url('counsellor/profile.php')) ?>">Profile</a>
    <?php else: ?>
      <a class="<?= active_nav('admin/index') ?>" href="<?= e(url('admin/index.php')) ?>">Overview</a>
      <a class="<?= active_nav('admin/counsellors') ?>" href="<?= e(url('admin/counsellors.php')) ?>">Verify counsellors</a>
      <a class="<?= active_nav('admin/content') ?>" href="<?= e(url('admin/content.php')) ?>">Awareness content</a>
      <a class="<?= active_nav('admin/referrals') ?>" href="<?= e(url('admin/referrals.php')) ?>">Referrals</a>
      <a class="<?= active_nav('admin/stories') ?>" href="<?= e(url('admin/stories.php')) ?>">Moderate stories</a>
      <a class="<?= active_nav('admin/analytics') ?>" href="<?= e(url('admin/analytics.php')) ?>">Analytics</a>
    <?php endif; ?>
  </aside>
  <div class="main">
