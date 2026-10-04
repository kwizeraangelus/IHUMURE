<?php
require_once dirname(__DIR__) . '/includes/init.php';
$user = require_login('consumer');

$screenings = fetch_all('SELECT * FROM screenings WHERE user_id = ? ORDER BY id DESC', [$user['id']]);
$referrals = fetch_all(
    "SELECT r.*, c.category, c.facility_name, c.district, u.display_name
     FROM referrals r
     JOIN counsellors c ON c.id = r.counsellor_id
     JOIN users u ON u.id = c.user_id
     WHERE r.consumer_id = ?
     ORDER BY r.id DESC",
    [$user['id']]
);

$page_title = 'My space';
include dirname(__DIR__) . '/includes/app_header.php';
?>
<div class="page-title">
  <div>
    <div class="kicker">Consumer</div>
    <h1>Hello. You are <?= e($user['anon_code']) ?>.</h1>
    <p class="muted">Counsellors see this ID when you request support. Your name is not required.</p>
  </div>
  <a class="btn btn-primary" href="<?= e(url('screening.php')) ?>">Take / retake AUDIT</a>
</div>

<div class="grid-3" style="margin-bottom:1.4rem">
  <div class="stat"><b><?= count($screenings) ?></b> Screenings saved</div>
  <div class="stat"><b><?= count($referrals) ?></b> Support requests</div>
  <div class="stat"><b><?= e($user['district'] ?: 'Not set') ?></b> District</div>
</div>

<div class="grid-2">
  <section class="card">
    <h2>Screening history</h2>
    <?php if (!$screenings): ?>
      <p class="muted">No screenings yet.</p>
    <?php else: ?>
      <div class="table-wrap">
        <table>
          <thead><tr><th>Date</th><th>Score</th><th>Zone</th><th></th></tr></thead>
          <tbody>
          <?php foreach ($screenings as $s): $m = risk_meta($s['risk_zone']); ?>
            <tr>
              <td><?= e(format_date($s['created_at'])) ?></td>
              <td><?= (int) $s['score'] ?></td>
              <td><span class="badge badge-<?= e($m['class']) ?>"><?= e($m['label']) ?></span></td>
              <td><a href="<?= e(url('result.php?id=' . $s['id'])) ?>">View</a></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>
  <section class="card">
    <h2>Assigned support</h2>
    <?php if (!$referrals): ?>
      <p class="muted">No counsellor assigned yet. After a hazardous-or-above score you can choose 1–2 counsellors.</p>
      <a class="btn btn-ghost btn-sm" href="<?= e(url('counsellors.php')) ?>">Find support</a>
    <?php else: ?>
      <?php foreach ($referrals as $r): ?>
        <p>
          <strong><?= e($r['display_name']) ?></strong>
          <span class="badge badge-<?= e($r['category']) ?>"><?= e(category_label($r['category'])) ?></span>
          <span class="badge badge-pending"><?= e(status_label($r['status'])) ?></span><br>
          <span class="small muted"><?= e($r['facility_name']) ?> · <?= e($r['district']) ?></span>
          <?php if (in_array($r['status'], ['acknowledged','contacted','ongoing'], true)): ?>
            · <a href="<?= e(url('consumer/chat.php?rid=' . $r['id'])) ?>">Open chat</a>
          <?php endif; ?>
        </p>
      <?php endforeach; ?>
    <?php endif; ?>
  </section>
</div>
<?php include dirname(__DIR__) . '/includes/app_footer.php'; ?>
