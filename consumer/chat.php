<?php
require_once dirname(__DIR__) . '/includes/init.php';
$user = require_login('consumer');

$threads = fetch_all(
    "SELECT r.*, u.display_name FROM referrals r
     JOIN counsellors c ON c.id = r.counsellor_id
     JOIN users u ON u.id = c.user_id
     WHERE r.consumer_id = ? AND r.status IN ('acknowledged','contacted','ongoing')
     ORDER BY r.id DESC",
    [$user['id']]
);
$rid = (int) ($_GET['rid'] ?? ($threads[0]['id'] ?? 0));
$current = null;
foreach ($threads as $t) {
    if ((int) $t['id'] === $rid) {
        $current = $t;
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $current) {
    verify_csrf();
    $body = trim($_POST['body'] ?? '');
    if ($body !== '') {
        q(
            'INSERT INTO messages (referral_id, sender_id, sender_role, body) VALUES (?,?,?,?)',
            [$current['id'], $user['id'], 'consumer', $body]
        );
    }
    redirect('consumer/chat.php?rid=' . $current['id']);
}

$messages = $current
    ? fetch_all('SELECT * FROM messages WHERE referral_id = ? ORDER BY id ASC', [$current['id']])
    : [];

$page_title = 'Messages';
include dirname(__DIR__) . '/includes/app_header.php';
?>
<div class="page-title">
  <div>
    <h1>Private messages</h1>
    <p class="muted">Only you and the counsellor you selected can see this thread.</p>
  </div>
</div>
<div class="chat-layout" data-chat="<?= e(url('api/messages.php?rid=' . $rid)) ?>">
  <div class="chat-list">
    <?php foreach ($threads as $t): ?>
      <a class="<?= (int) $t['id'] === $rid ? 'active' : '' ?>" href="<?= e(url('consumer/chat.php?rid=' . $t['id'])) ?>">
        <?= e($t['display_name']) ?><br>
        <span class="small muted"><?= e(status_label($t['status'])) ?></span>
      </a>
    <?php endforeach; ?>
    <?php if (!$threads): ?>
      <p class="small" style="padding:1rem">No accepted requests yet.</p>
    <?php endif; ?>
  </div>
  <div class="chat-thread">
    <div class="msgs" data-msgs>
      <?php foreach ($messages as $m): ?>
        <div class="bubble <?= (int) $m['sender_id'] === (int) $user['id'] ? 'me' : '' ?>">
          <?= nl2br(e($m['body'])) ?>
          <div class="small" style="opacity:.75"><?= e(format_date($m['created_at'])) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php if ($current): ?>
      <form class="chat-form" method="post" action="<?= e(url('consumer/chat.php?rid=' . $current['id'])) ?>">
        <?= csrf_field() ?>
        <input name="body" required placeholder="Write a private message">
        <button class="btn btn-primary" type="submit">Send</button>
      </form>
    <?php endif; ?>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/app_footer.php'; ?>
