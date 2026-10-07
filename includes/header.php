<?php
$user = current_user();
$flash = flash();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($page_title ?? APP_NAME) ?> · <?= e(APP_NAME) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,650&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
</head>

<body>
  <!-- Clean & Professional Unified Utility Bar -->
  <div class="top-utility-bar">
    <div class="wrap utility-wrap">
      <div class="utility-left">
        <span class="privacy-pill">
          <svg class="u-icon" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          <span>Confidential Healthcare</span>
        </span>
        <span class="utility-sep">&middot;</span>
        <span class="utility-note">Verified Support in Rwanda</span>
      </div>
      <div class="utility-right">
        <span class="hotline-title">24/7 Crisis:</span>
        <a class="hotline-pill hotline-alert" href="tel:112" title="Rwanda Emergency Medical Services">
          <span class="hotline-pulse"></span>
          <span><strong>112</strong> Emergency</span>
        </a>
        <a class="hotline-pill" href="tel:114" title="Mental Health Helpline">
          <span><strong>114</strong> Mental Health</span>
        </a>
        <a class="hotline-pill" href="tel:3588" title="Child & Family Protection Helpline">
          <span><strong>3588</strong> Family Care</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Main Site Header -->
  <header class="site-header" id="siteHeader">
    <div class="wrap nav-wrap">
      <a class="brand" href="<?= e(url('index.php')) ?>" aria-label="<?= e(APP_NAME) ?> Home">
        <div class="brand-mark">
          <svg class="brand-svg" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" fill="rgba(255,255,255,0.18)" stroke="#ffffff"/>
            <path d="M12 8v8M8 12h8" stroke="#ffffff" stroke-width="2.4"/>
          </svg>
        </div>
        <div class="brand-info">
          <div class="brand-name-wrap">
            <span class="brand-name"><?= e(APP_NAME) ?></span>
            <span class="brand-badge-live" title="Platform online & secure"></span>
          </div>
          <span class="brand-sub">Alcohol Prevention &amp; Recovery</span>
        </div>
      </a>

      <button class="nav-toggle-btn" type="button" data-nav-toggle aria-label="Toggle navigation menu" aria-expanded="false">
        <span class="nav-bar"></span>
        <span class="nav-bar"></span>
        <span class="nav-bar"></span>
      </button>

      <nav class="nav-menu" data-nav-links>
        <div class="nav-links-list">
          <a class="nav-link<?= active_nav('index.php') ?>" href="<?= e(url('index.php')) ?>">
            <svg class="nav-link-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span class="nav-link-text">Home</span>
          </a>
          <a class="nav-link<?= active_nav('awareness.php') ?>" href="<?= e(url('awareness.php')) ?>">
            <svg class="nav-link-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            <span class="nav-link-text">Awareness</span>
          </a>
          <a class="nav-link nav-link-audit<?= active_nav('screening.php') ?>" href="<?= e(url('screening.php')) ?>">
            <svg class="nav-link-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            <span class="nav-link-text">AUDIT Screening</span>
            <span class="nav-badge-pill">Free</span>
          </a>
          <a class="nav-link" href="<?= e(url('index.php#recovery')) ?>">
            <svg class="nav-link-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            <span class="nav-link-text">Recovery Guide</span>
          </a>
          <a class="nav-link<?= active_nav('stories.php') ?>" href="<?= e(url('stories.php')) ?>">
            <svg class="nav-link-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <span class="nav-link-text">Stories</span>
          </a>
        </div>

        <div class="nav-actions">
          <?php if ($user): ?>
            <a class="nav-btn-dash" href="<?= e(url(home_for($user))) ?>">
              <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
              <span>Dashboard</span>
            </a>
            <a class="nav-btn-logout" href="<?= e(url('logout.php')) ?>" title="Sign out">
              <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
              <span>Sign out</span>
            </a>
          <?php else: ?>
            <a class="nav-link-login<?= active_nav('login.php') ?>" href="<?= e(url('login.php')) ?>">
              <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              <span>Sign In</span>
            </a>
            <a class="btn btn-primary btn-sm btn-nav-cta" href="<?= e(url('start.php')) ?>">
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
              <span>Start Privately</span>
            </a>
          <?php endif; ?>
        </div>
      </nav>
    </div>
  </header>
  <?php if ($flash): ?>
    <div class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
  <?php endif; ?>