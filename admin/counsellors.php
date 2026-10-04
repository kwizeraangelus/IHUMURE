<?php
require_once dirname(__DIR__) . '/includes/init.php';
$user = require_login('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';
    if ($action === 'verify') {
        q('UPDATE counsellors SET verified = 1, verified_at = ?, reject_reason = NULL WHERE id = ?', [now(), $id]);
        flash('success', 'Counsellor verified.');
    } elseif ($action === 'reject') {
        $reason = trim($_POST['reason'] ?? 'Certificate not accepted');
        q('UPDATE counsellors SET verified = 0, active = 0, reject_reason = ? WHERE id = ?', [$reason, $id]);
        flash('info', 'Counsellor rejected.');
    }
    redirect('admin/counsellors.php');
}

$rows = fetch_all(
    "SELECT c.*, u.display_name, u.email FROM counsellors c
     JOIN users u ON u.id = c.user_id ORDER BY c.verified ASC, c.id DESC"
);
$page_title = 'Verify counsellors';
include dirname(__DIR__) . '/includes/app_header.php';
?>
<div class="page-title"><h1>Counsellor verification</h1></div>
<div class="table-wrap card" style="padding:0">
<table>
  <thead><tr><th>Name</th><th>Category</th><th>District</th><th>Certificate</th><th>Status</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><strong><?= e($r['display_name']) ?></strong><br><span class="small"><?= e($r['email']) ?></span></td>
      <td><?= e(category_label($r['category'])) ?></td>
      <td><?= e($r['district']) ?></td>
      <td>
        <?php if ($r['certificate_file']): ?>
          <a href="<?= e(url('media.php?cert=' . $r['id'])) ?>" target="_blank">View file</a>
        <?php else: ?>Seeded demo — no file<?php endif; ?>
      </td>
      <td><?= (int) $r['verified'] ? '<span class="badge badge-low">Verified</span>' : '<span class="badge badge-pending">Pending</span>' ?></td>
      <td>
        <?php if (!(int) $r['verified']): ?>
          <form method="post" style="display:flex;gap:.35rem;flex-wrap:wrap">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
            <button class="btn btn-primary btn-sm" name="action" value="verify">Verify</button>
            <input name="reason" placeholder="Reject reason" style="max-width:140px;border:1px solid var(--line);border-radius:8px;padding:.3rem">
            <button class="btn btn-danger btn-sm" name="action" value="reject">Reject</button>
          </form>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php include dirname(__DIR__) . '/includes/app_footer.php'; ?>
