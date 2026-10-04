<?php
require_once dirname(__DIR__) . '/includes/init.php';
$user = require_login('counsellor');
$c = $user['counsellor'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    try {
        $title = trim($_POST['title'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $public = isset($_POST['is_public']) ? 1 : 0;
        $path = save_upload($_FILES['video'] ?? ['error' => UPLOAD_ERR_NO_FILE], 'videos', ['mp4','webm'], MAX_VIDEO_BYTES);
        if (!$title || !$path) {
            throw new RuntimeException('Title and an mp4/webm file are required.');
        }
        q(
            'INSERT INTO videos (counsellor_id, title, description, file_path, is_public) VALUES (?,?,?,?,?)',
            [$c['id'], $title, $desc, $path, $public]
        );
        flash('success', 'Video uploaded.');
    } catch (RuntimeException $ex) {
        flash('error', $ex->getMessage());
    }
    redirect('counsellor/videos.php');
}

$videos = fetch_all('SELECT * FROM videos WHERE counsellor_id = ? ORDER BY id DESC', [$c['id']]);
$page_title = 'Guidance videos';
include dirname(__DIR__) . '/includes/app_header.php';
?>
<div class="page-title">
  <div>
    <h1>Guidance videos</h1>
    <p class="muted">Public videos appear to all visitors of awareness resources via your profile. Private videos are exclusively for your connected consumers.</p>
  </div>
</div>
<div class="grid-2">
  <form method="post" enctype="multipart/form-data" class="card">
    <?= csrf_field() ?>
    <div class="field"><label for="title">Title</label><input id="title" name="title" required></div>
    <div class="field"><label for="description">Description</label><textarea id="description" name="description"></textarea></div>
    <div class="field"><label for="video">File (mp4/webm, max 25 MB)</label><input id="video" name="video" type="file" accept="video/mp4,video/webm" required></div>
    <label class="field" style="display:flex;gap:.6rem"><input type="checkbox" name="is_public" value="1"> <span>Mark public</span></label>
    <button class="btn btn-primary" type="submit">Upload</button>
  </form>
  <div class="video-grid">
    <?php foreach ($videos as $v): ?>
      <article class="card">
        <video controls src="<?= e(url('media.php?v=' . $v['id'])) ?>"></video>
        <h3><?= e($v['title']) ?></h3>
        <p class="small"><?= (int) $v['is_public'] ? 'Public' : 'Connected consumers only' ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/app_footer.php'; ?>
