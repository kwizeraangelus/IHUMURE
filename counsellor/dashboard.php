<?php
require_once dirname(__DIR__) . '/includes/init.php';
$user = require_login('counsellor');
$c = $user['counsellor'] ?? null;
if (!$c) {
    flash('error', 'Counsellor profile missing.');
    redirect('logout.php');
}
if (!(int) $c['verified']) {
    $page_title = 'Pending verification';
    include dirname(__DIR__) . '/includes/app_header.php';
    echo '<div class="card"><h1>Waiting for admin review</h1><p>Your certificate is in the verification queue. You cannot receive consumer requests until an administrator activates this account.</p></div>';
    include dirname(__DIR__) . '/includes/app_footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = (int) ($_POST['referral_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    $ref = fetch_one('SELECT * FROM referrals WHERE id = ? AND counsellor_id = ?', [$id, $c['id']]);
    if ($ref) {
        $map = [
            'accept' => 'acknowledged',
            'decline' => 'declined',
            'contacted' => 'contacted',
            'ongoing' => 'ongoing',
            'closed' => 'closed',
        ];
        if (isset($map[$action])) {
            q('UPDATE referrals SET status = ?, updated_at = ? WHERE id = ?', [$map[$action], now(), $id]);
            flash('success', 'Request updated.');
        }
    }
    redirect('counsellor/dashboard.php');
}

$requests = fetch_all(
    "SELECT r.*, u.anon_code, u.phone, u.share_contact, s.score, s.risk_zone AS s_zone
     FROM referrals r
     JOIN users u ON u.id = r.consumer_id
     LEFT JOIN screenings s ON s.id = r.screening_id
     WHERE r.counsellor_id = ?
     ORDER BY r.id DESC",
    [$c['id']]
);

$page_title = 'Requests';
include dirname(__DIR__) . '/includes/app_header.php';
?>
<div class="page-title">
  <div>
    <div class="kicker"><?= e(category_label($c['category'])) ?> · <?= e($c['district']) ?></div>
    <h1>Incoming support requests</h1>
    <p class="muted">Consumers are listed by private ID. Phone numbers appear only if they opted in.</p>
  </div>
</div>
<div class="table-wrap card" style="padding:0">
  <table>
    <thead>
      <tr>
        <th>Private ID</th>
        <th>Risk</th>
        <th>Status</th>
        <th>Contact</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($requests as $r): $m = risk_meta($r['risk_zone']); ?>
      <tr>
        <td><strong><?= e($r['anon_code']) ?></strong><br><span class="small muted"><?= e(format_date($r['created_at'])) ?></span></td>
        <td><span class="badge badge-<?= e($m['class']) ?>"><?= e($m['label']) ?></span><br><span class="small">Score <?= (int) ($r['score'] ?? 0) ?></span></td>
        <td><?= e(status_label($r['status'])) ?></td>
        <td><?= ((int) $r['share_contact'] && $r['phone']) ? e($r['phone']) : 'Not shared' ?></td>
        <td>
          <form method="post" style="display:flex;gap:.35rem;flex-wrap:wrap">
            <?= csrf_field() ?>
            <input type="hidden" name="referral_id" value="<?= (int) $r['id'] ?>">
            <?php if ($r['status'] === 'submitted'): ?>
              <button class="btn btn-primary btn-sm" name="action" value="accept">Accept</button>
              <button class="btn btn-danger btn-sm" name="action" value="decline">Decline</button>
            <?php elseif (!in_array($r['status'], ['declined','closed'], true)): ?>
              <a class="btn btn-ghost btn-sm" href="<?= e(url('counsellor/chat.php?rid=' . $r['id'])) ?>">Chat</a>
              <button class="btn btn-light btn-sm" name="action" value="contacted">Contacted</button>
              <button class="btn btn-light btn-sm" name="action" value="ongoing">Ongoing</button>
              <button class="btn btn-light btn-sm" name="action" value="closed">Close</button>
            <?php endif; ?>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$requests): ?>
      <tr><td colspan="5">No requests yet.</td></tr>
    <?php endif; ?>
    </tbody>
  </table>
</div>
<?php include dirname(__DIR__) . '/includes/app_footer.php'; ?>
