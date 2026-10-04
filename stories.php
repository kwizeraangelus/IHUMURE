<?php
require_once __DIR__ . '/includes/init.php';
$stories = fetch_all(
    "SELECT s.*, u.anon_code FROM stories s JOIN users u ON u.id = s.user_id
     WHERE s.approved = 1 ORDER BY s.id DESC"
);
$page_title = 'Recovery stories';
include __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="wrap">
    <div class="section-head">
      <div class="kicker">Lived experience</div>
      <h1>Recovery stories</h1>
      <p class="lede">Published after admin review. Authors stay behind their private ID unless they chose to write a display name into the story itself.</p>
    </div>
    <div class="grid-2">
      <?php foreach ($stories as $s): ?>
        <article class="card story">
          <h3><?= e($s['title']) ?></h3>
          <p class="small muted"><?= e($s['anon_code']) ?> · <?= e(format_date($s['created_at'])) ?></p>
          <p><?= nl2br(e($s['body'])) ?></p>
          <?php if ((int) $s['show_counsellor_prompt']): ?>
            <a class="btn btn-ghost btn-sm" href="<?= e(url('start.php')) ?>">Need similar support? Connect privately</a>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
      <?php if (!$stories): ?>
        <p class="muted">No approved stories yet. Consumers can submit one from their dashboard.</p>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
