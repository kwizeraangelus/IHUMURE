<?php
require_once __DIR__ . '/includes/init.php';
$user = require_login('consumer');
$code = $_SESSION['shown_code'] ?? $user['anon_code'];
$pin = $_SESSION['shown_pin'] ?? null;
unset($_SESSION['shown_pin'], $_SESSION['shown_code']);

$page_title = 'Your private ID';
include __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="wrap">
    <div class="kicker">Keep this safe</div>
    <h1>This ID is how the system knows you.</h1>
    <p class="lede">Use it to return, to save screening history, and to be assigned to a counsellor. You do not have to give your real name.</p>
    <div class="identity-card">
      <div class="small">Private ID</div>
      <code><?= e($code) ?></code>
      <?php if ($pin): ?>
        <p style="margin:1rem 0 0">PIN: <strong style="font-size:1.4rem;letter-spacing:.2em"><?= e($pin) ?></strong></p>
        <p class="small">This PIN is shown once. If you lose it, start a new private ID.</p>
      <?php else: ?>
        <p class="small">You are signed in on this device. Use <strong>Return with my ID</strong> on another device.</p>
      <?php endif; ?>
    </div>
    <div class="hero-actions">
      <a class="btn btn-primary" href="<?= e(url('screening.php')) ?>">Start AUDIT screening</a>
      <a class="btn btn-ghost" href="<?= e(url('consumer/dashboard.php')) ?>">Go to my dashboard</a>
    </div>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
