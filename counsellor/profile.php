<?php
require_once dirname(__DIR__) . '/includes/init.php';
$user = require_login('counsellor');
$c = $user['counsellor'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $bio = trim($_POST['bio'] ?? '');
    $fee = $c['category'] === 'public' ? 0 : (float) ($_POST['session_fee'] ?? 0);
    $district = $_POST['district'] ?? $c['district'];
    $facility = trim($_POST['facility_name'] ?? '');
    q(
        'UPDATE counsellors SET bio = ?, session_fee = ?, district = ?, facility_name = ? WHERE id = ?',
        [$bio, $fee, $district, $facility, $c['id']]
    );
    flash('success', 'Profile updated.');
    redirect('counsellor/profile.php');
}

$page_title = 'Profile';
include dirname(__DIR__) . '/includes/app_header.php';
?>
<div class="page-title"><h1>Your public counsellor profile</h1></div>
<form method="post" class="card" style="max-width:640px">
  <?= csrf_field() ?>
  <p>Status: <?= (int) $c['verified'] ? '<span class="badge badge-low">Verified</span>' : '<span class="badge badge-pending">Unverified</span>' ?></p>
  <div class="field">
    <label>Category</label>
    <input value="<?= e(category_label($c['category'])) ?>" disabled>
  </div>
  <div class="field">
    <label for="facility_name">Facility</label>
    <input id="facility_name" name="facility_name" value="<?= e($c['facility_name']) ?>">
  </div>
  <div class="field">
    <label for="district">District</label>
    <select id="district" name="district"><?= district_options($c['district']) ?></select>
  </div>
  <div class="field">
    <label for="session_fee">Session fee (RWF)</label>
    <input id="session_fee" name="session_fee" type="number" min="0" value="<?= e((string) $c['session_fee']) ?>" <?= $c['category'] === 'public' ? 'readonly' : '' ?>>
  </div>
  <div class="field">
    <label for="bio">Bio</label>
    <textarea id="bio" name="bio"><?= e($c['bio']) ?></textarea>
  </div>
  <button class="btn btn-primary" type="submit">Save</button>
</form>
<?php include dirname(__DIR__) . '/includes/app_footer.php'; ?>
