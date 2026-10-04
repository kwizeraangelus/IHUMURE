<?php
require_once dirname(__DIR__) . '/includes/init.php';
$user = require_login('consumer');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $prompt = isset($_POST['show_counsellor_prompt']) ? 1 : 0;
    if ($title === '' || $body === '') {
        flash('error', 'Title and story are required.');
    } else {
        q(
            'INSERT INTO stories (user_id, title, body, approved, show_counsellor_prompt) VALUES (?,?,?,0,?)',
            [$user['id'], $title, $body, $prompt]
        );
        flash('success', 'Story submitted for admin review. It will appear publicly only after approval.');
        redirect('consumer/story.php');
    }
}

$mine = fetch_all('SELECT * FROM stories WHERE user_id = ? ORDER BY id DESC', [$user['id']]);
$page_title = 'Recovery story';
include dirname(__DIR__) . '/includes/app_header.php';
?>
<div class="page-title">
  <div>
    <h1>Write a recovery story</h1>
    <p class="muted">Optional. Published stories inspire others. Admin must approve before they go public. You remain <?= e($user['anon_code']) ?> unless you write a name in the text.</p>
  </div>
</div>
<div class="grid-2">
  <form method="post" class="card">
    <?= csrf_field() ?>
    <div class="field">
      <label for="title">Title</label>
      <input id="title" name="title" required>
    </div>
    <div class="field">
      <label for="body">Story</label>
      <textarea id="body" name="body" required></textarea>
    </div>
    <label class="field" style="display:flex;gap:.6rem">
      <input type="checkbox" name="show_counsellor_prompt" value="1" checked>
      <span>Show readers a private “connect with a counsellor” prompt</span>
    </label>
    <button class="btn btn-primary" type="submit">Submit for review</button>
  </form>
  <section>
    <?php foreach ($mine as $s): ?>
      <article class="card" style="margin-bottom:1rem">
        <span class="badge <?= (int) $s['approved'] ? 'badge-low' : 'badge-pending' ?>"><?= (int) $s['approved'] ? 'Published' : 'Pending review' ?></span>
        <h3><?= e($s['title']) ?></h3>
        <p><?= nl2br(e($s['body'])) ?></p>
      </article>
    <?php endforeach; ?>
  </section>
</div>
<?php include dirname(__DIR__) . '/includes/app_footer.php'; ?>
