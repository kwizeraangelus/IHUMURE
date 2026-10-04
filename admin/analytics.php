<?php
require_once dirname(__DIR__) . '/includes/init.php';
$user = require_login('admin');

$zones = ['low' => 0, 'hazardous' => 0, 'harmful' => 0, 'dependence' => 0];
foreach (fetch_all('SELECT risk_zone, COUNT(*) AS n FROM screenings GROUP BY risk_zone') as $row) {
    $zones[$row['risk_zone']] = (int) $row['n'];
}
$maxZ = max(1, max($zones));
$outcomes = fetch_all('SELECT status, COUNT(*) AS n FROM referrals GROUP BY status');
$maxO = 1;
foreach ($outcomes as $o) {
    $maxO = max($maxO, (int) $o['n']);
}

$page_title = 'Analytics';
include dirname(__DIR__) . '/includes/app_header.php';
?>
<div class="page-title">
  <div>
    <h1>Platform Analytics</h1>
    <p class="muted">Live operational metrics: screening volumes, risk mix distribution, and counsellor referral outcomes.</p>
  </div>
</div>
<div class="grid-2">
  <section class="card">
    <h2>Screenings by risk zone</h2>
    <?php foreach ($zones as $z => $n): $m = risk_meta($z); ?>
      <p><?= e($m['label']) ?> · <?= $n ?></p>
      <div class="bar"><i style="width: <?= round($n / $maxZ * 100) ?>%;background: <?= $z === 'dependence' ? 'var(--danger)' : 'var(--teal)' ?>"></i></div>
    <?php endforeach; ?>
  </section>
  <section class="card">
    <h2>Referral outcomes</h2>
    <?php foreach ($outcomes as $o): ?>
      <p><?= e(status_label($o['status'])) ?> · <?= (int) $o['n'] ?></p>
      <div class="bar"><i style="width: <?= round((int)$o['n'] / $maxO * 100) ?>%"></i></div>
    <?php endforeach; ?>
    <?php if (!$outcomes): ?><p class="muted">No referrals yet.</p><?php endif; ?>
  </section>
</div>
<?php include dirname(__DIR__) . '/includes/app_footer.php'; ?>
