<?php
require_once __DIR__ . '/includes/init.php';
$user = require_login('consumer');

$latest = fetch_one('SELECT * FROM screenings WHERE user_id = ? ORDER BY id DESC', [$user['id']]);
$zone = $_GET['zone'] ?? ($latest['risk_zone'] ?? 'hazardous');
$sid = (int) ($_GET['sid'] ?? ($latest['id'] ?? 0));
$district = $_GET['district'] ?? $user['district'];
$category = $_GET['category'] ?? '';

$list = match_counsellors($zone, $district ?: null);
if ($category) {
    $list = array_values(array_filter($list, fn($c) => $c['category'] === $category));
}

$page_title = 'Find support';
include __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="wrap">
    <div class="section-head">
      <div class="kicker">Matched to your support need</div>
      <h1>Verified counsellors</h1>
      <p class="lede">
        Sorted for risk zone <strong><?= e(risk_meta($zone)['label']) ?></strong>.
        Public facilities are prioritised when dependence is likely. You may connect with up to two counsellors. Selection is private.
      </p>
    </div>
    <form class="filters" method="get">
      <input type="hidden" name="zone" value="<?= e($zone) ?>">
      <input type="hidden" name="sid" value="<?= (int) $sid ?>">
      <select name="district" onchange="this.form.submit()">
        <option value="">Any district</option>
        <?php foreach (rwanda_districts() as $province => $ds): foreach ($ds as $d): ?>
          <option value="<?= e($d) ?>" <?= $district === $d ? 'selected' : '' ?>><?= e($d) ?></option>
        <?php endforeach; endforeach; ?>
      </select>
      <select name="category" onchange="this.form.submit()">
        <option value="">All categories</option>
        <option value="public" <?= $category === 'public' ? 'selected' : '' ?>>Public</option>
        <option value="private" <?= $category === 'private' ? 'selected' : '' ?>>Private</option>
        <option value="personal" <?= $category === 'personal' ? 'selected' : '' ?>>Independent</option>
      </select>
    </form>
    <div class="grid-2">
      <?php foreach ($list as $c): ?>
        <article class="card counsellor-card">
          <div class="meta">
            <span class="badge badge-<?= e($c['category']) ?>"><?= e(category_label($c['category'])) ?></span>
            <span class="badge badge-pending"><?= e($c['district']) ?></span>
            <?php if ($c['match_score'] >= 20): ?><span class="badge badge-low">Recommended match</span><?php endif; ?>
          </div>
          <h3><?= e($c['display_name']) ?></h3>
          <p class="small muted"><?= e($c['facility_name']) ?></p>
          <p><?= e($c['bio']) ?></p>
          <div class="fee"><?= (float) $c['session_fee'] > 0 ? number_format((float) $c['session_fee']) . ' RWF / session (mocked payment)' : 'No session fee' ?></div>
          <a class="btn btn-primary btn-sm" href="<?= e(url('connect.php?cid=' . $c['id'] . '&sid=' . $sid)) ?>">Connect privately</a>
        </article>
      <?php endforeach; ?>
      <?php if (!$list): ?>
        <p>No verified counsellors match those filters yet.</p>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
