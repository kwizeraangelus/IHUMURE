<?php
require_once dirname(__DIR__) . '/includes/init.php';
$user = require_login('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';
    if ($action === 'approve') {
        q('UPDATE stories SET approved = 1 WHERE id = ?', [$id]);
        flash('success', 'Story published.');
    } elseif ($action === 'reject') {
        q('DELETE FROM stories WHERE id = ?', [$id]);
        flash('info', 'Story removed.');
    }
    redirect('admin/stories.php');
}

$rows = fetch_all(
    "SELECT s.*, u.anon_code FROM stories s JOIN users u ON u.id = s.user_id ORDER BY s.approved ASC, s.id DESC"
);
$page_title = 'Stories';
include dirname(__DIR__) . '/includes/app_header.php';
?>
<div class="page-title"><h1>Moderate recovery stories</h1></div>
<?php foreach ($rows as $s): ?>
  <article class="card" style="margin-bottom:1rem">
    <span class="badge <?= (int)$s['approved'] ? 'badge-low' : 'badge-pending' ?>"><?= (int)$s['approved'] ? 'Public' : 'Pending' ?></span>
    <h3><?= e($s['title']) ?></h3>
    <p class="small muted"><?= e($s['anon_code']) ?> · <?= e(format_date($s['created_at'])) ?></p>
    <p><?= nl2br(e($s['body'])) ?></p>
    <?php if (!(int) $s['approved']): ?>
      <form method="post" style="display:flex;gap:.4rem">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
        <button class="btn btn-primary btn-sm" name="action" value="approve">Publish</button>
        <button class="btn btn-danger btn-sm" name="action" value="reject">Remove</button>
      </form>
    <?php endif; ?>
  </article>
<?php endforeach; ?>
<?php if (!$rows): ?><p>No stories submitted.</p><?php endif; ?>
<?php include dirname(__DIR__) . '/includes/app_footer.php'; ?>
