<?php
require_once __DIR__ . '/includes/init.php';

$faqs = fetch_all("SELECT * FROM content WHERE published = 1 AND type = 'faq' ORDER BY id");
$articles = fetch_all("SELECT * FROM content WHERE published = 1 AND type IN ('awareness','tip') ORDER BY type, id");
$videos = fetch_all(
    "SELECT v.*, u.display_name FROM videos v
     JOIN counsellors c ON c.id = v.counsellor_id
     JOIN users u ON u.id = c.user_id
     WHERE v.is_public = 1
     ORDER BY v.id DESC"
);

$page_title = 'Awareness & FAQ';
include __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="wrap">
    <div class="section-head">
      <div class="kicker">Learn first</div>
      <h1>Awareness, FAQ and practical tips</h1>
      <p class="lede">This page is educational. It is not the screening tool. Use it to understand risk, support a loved one, and decide whether to take AUDIT privately.</p>
    </div>

    <h2>Frequently asked questions</h2>
    <div class="grid-2" style="margin-bottom:2.5rem">
      <?php foreach ($faqs as $item): ?>
        <article class="card">
          <h3><?= e($item['title']) ?></h3>
          <p><?= nl2br(e($item['body'])) ?></p>
        </article>
      <?php endforeach; ?>
    </div>

    <h2>Awareness &amp; self-help</h2>
    <div class="grid-2">
      <?php foreach ($articles as $item): ?>
        <article class="card">
          <span class="badge badge-public"><?= e($item['type']) ?></span>
          <h3><?= e($item['title']) ?></h3>
          <p><?= nl2br(e($item['body'])) ?></p>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if ($videos): ?>
      <h2 style="margin-top:2.5rem">Public guidance videos</h2>
      <div class="video-grid">
        <?php foreach ($videos as $v): ?>
          <article class="card">
            <video controls src="<?= e(url('media.php?v=' . $v['id'])) ?>"></video>
            <h3><?= e($v['title']) ?></h3>
            <p class="small muted"><?= e($v['display_name']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
