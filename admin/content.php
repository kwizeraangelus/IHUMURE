<?php
require_once dirname(__DIR__) . '/includes/init.php';
$user = require_login('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    if (($_POST['action'] ?? '') === 'delete' && $id) {
        q('DELETE FROM content WHERE id = ?', [$id]);
        flash('success', 'Content removed.');
    } else {
        $title = trim($_POST['title'] ?? '');
        $body = trim($_POST['body'] ?? '');
        $type = $_POST['type'] ?? 'faq';
        $published = isset($_POST['published']) ? 1 : 0;
        if ($title && $body && in_array($type, ['faq','awareness','tip'], true)) {
            if ($id) {
                q('UPDATE content SET title=?, body=?, type=?, published=? WHERE id=?', [$title, $body, $type, $published, $id]);
            } else {
                q('INSERT INTO content (title, body, type, published) VALUES (?,?,?,?)', [$title, $body, $type, $published]);
            }
            flash('success', 'Content saved.');
        }
    }
    redirect('admin/content.php');
}

$items = fetch_all('SELECT * FROM content ORDER BY id DESC');
$edit = isset($_GET['edit']) ? fetch_one('SELECT * FROM content WHERE id = ?', [(int) $_GET['edit']]) : null;
$page_title = 'Content';
include dirname(__DIR__) . '/includes/app_header.php';
?>
<div class="page-title"><h1>Awareness &amp; FAQ content</h1></div>
<div class="grid-2">
  <form method="post" class="card">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) ($edit['id'] ?? 0) ?>">
    <div class="field"><label>Title</label><input name="title" required value="<?= e($edit['title'] ?? '') ?>"></div>
    <div class="field"><label>Type</label>
      <select name="type">
        <?php foreach (['faq'=>'FAQ','awareness'=>'Awareness','tip'=>'Tip'] as $k=>$lab): ?>
          <option value="<?= $k ?>" <?= (($edit['type'] ?? '') === $k) ? 'selected' : '' ?>><?= $lab ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="field"><label>Body</label><textarea name="body" required><?= e($edit['body'] ?? '') ?></textarea></div>
    <label class="field" style="display:flex;gap:.6rem"><input type="checkbox" name="published" value="1" <?= !isset($edit['published']) || (int)$edit['published'] ? 'checked' : '' ?>> Published</label>
    <button class="btn btn-primary" type="submit"><?= $edit ? 'Update' : 'Add content' ?></button>
  </form>
  <div>
    <?php foreach ($items as $item): ?>
      <article class="card" style="margin-bottom:.8rem">
        <span class="badge badge-public"><?= e($item['type']) ?></span>
        <h3><?= e($item['title']) ?></h3>
        <p class="small"><?= e(excerpt($item['body'])) ?></p>
        <a class="btn btn-light btn-sm" href="<?= e(url('admin/content.php?edit=' . $item['id'])) ?>">Edit</a>
        <form method="post" style="display:inline" onsubmit="return confirm('Delete this item?')">
          <?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
          <button class="btn btn-danger btn-sm" name="action" value="delete">Delete</button>
        </form>
      </article>
    <?php endforeach; ?>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/app_footer.php'; ?>
