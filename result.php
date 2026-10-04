<?php
require_once __DIR__ . '/includes/init.php';
$user = require_login('consumer');

$id = (int) ($_GET['id'] ?? 0);
$screening = fetch_one('SELECT * FROM screenings WHERE id = ? AND user_id = ?', [$id, $user['id']]);
if (!$screening) {
    $screening = fetch_one('SELECT * FROM screenings WHERE user_id = ? ORDER BY id DESC', [$user['id']]);
}
if (!$screening) {
    flash('info', 'Take the screening first.');
    redirect('screening.php');
}

$meta = risk_meta($screening['risk_zone']);
$pct = min(100, (int) $screening['score'] / 40 * 100);
$showReferral = $screening['risk_zone'] !== 'low';

$page_title = 'Your result';
include __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="wrap" style="max-width:860px">
    <div class="kicker">Saved to <?= e($user['anon_code']) ?></div>
    <h1><?= e($meta['headline']) ?></h1>
    <div class="card result-score" style="margin-bottom:1.2rem">
      <div class="score-ring" style="--p: <?= (int) $pct ?>">
        <b><?= (int) $screening['score'] ?></b>
      </div>
      <div>
        <span class="badge badge-<?= e($meta['class']) ?>"><?= e($meta['label']) ?> · <?= e($meta['zone']) ?></span>
        <p style="margin:.7rem 0 0"><?= e($meta['advice']) ?></p>
        <p class="small muted">AUDIT score <?= (int) $screening['score'] ?> / 40 (range <?= e($meta['range']) ?>). This is a screening result, not a diagnosis.</p>
      </div>
    </div>

    <?php if ($showReferral): ?>
      <div class="card" style="margin-bottom:1.2rem">
        <h2>Self-help while you decide</h2>
        <ul>
          <?php foreach (self_help_tips() as $tip): ?>
            <li><?= e($tip) ?></li>
          <?php endforeach; ?>
        </ul>
        <a class="btn btn-clay" href="<?= e(url('counsellors.php?zone=' . urlencode($screening['risk_zone']) . '&sid=' . $screening['id'])) ?>">
          <?= $screening['risk_zone'] === 'dependence' ? 'See recommended counsellors' : 'Optional: view counsellors' ?>
        </a>
      </div>
    <?php else: ?>
      <div class="card">
        <h2>Stay with awareness resources</h2>
        <p>No referral is pushed at this level. Re-screen if your pattern changes, and read the FAQ if you are supporting someone else.</p>
        <a class="btn btn-primary" href="<?= e(url('awareness.php')) ?>">Open awareness &amp; FAQ</a>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
