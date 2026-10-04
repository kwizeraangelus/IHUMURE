<?php
require_once dirname(__DIR__) . '/includes/init.php';
$user = require_login('admin');
$rows = fetch_all(
    "SELECT r.*, cu.anon_code, co.facility_name, uu.display_name AS counsellor_name
     FROM referrals r
     JOIN users cu ON cu.id = r.consumer_id
     JOIN counsellors co ON co.id = r.counsellor_id
     JOIN users uu ON uu.id = co.user_id
     ORDER BY r.id DESC"
);
$page_title = 'Referrals';
include dirname(__DIR__) . '/includes/app_header.php';
?>
<div class="page-title">
  <div>
    <h1>Referral activity</h1>
    <p class="muted">Aggregate view only. Message contents are not listed here.</p>
  </div>
</div>
<div class="table-wrap card" style="padding:0">
<table>
  <thead><tr><th>When</th><th>Consumer ID</th><th>Counsellor</th><th>Risk</th><th>Status</th><th>Payment</th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): $m = risk_meta($r['risk_zone']); ?>
    <tr>
      <td><?= e(format_date($r['created_at'])) ?></td>
      <td><?= e($r['anon_code']) ?></td>
      <td><?= e($r['counsellor_name']) ?><br><span class="small muted"><?= e($r['facility_name']) ?></span></td>
      <td><span class="badge badge-<?= e($m['class']) ?>"><?= e($m['label']) ?></span></td>
      <td><?= e(status_label($r['status'])) ?></td>
      <td><?= e($r['payment_status'] ?: '—') ?></td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$rows): ?><tr><td colspan="6">No referrals yet.</td></tr><?php endif; ?>
  </tbody>
</table>
</div>
<?php include dirname(__DIR__) . '/includes/app_footer.php'; ?>
