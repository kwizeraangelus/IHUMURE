<?php
require_once dirname(__DIR__) . '/includes/init.php';
$user = require_login('admin');

$pending = (int) db()->query("SELECT COUNT(*) FROM counsellors WHERE verified = 0")->fetchColumn();
$screenings = (int) db()->query('SELECT COUNT(*) FROM screenings')->fetchColumn();
$referrals = (int) db()->query('SELECT COUNT(*) FROM referrals')->fetchColumn();
$stories = (int) db()->query('SELECT COUNT(*) FROM stories WHERE approved = 0')->fetchColumn();

$page_title = 'Admin';
include dirname(__DIR__) . '/includes/app_header.php';
?>
<div class="page-title">
  <div>
    <div class="kicker">Administrator</div>
    <h1>Platform oversight</h1>
    <p class="muted">Verify counsellors, moderate stories, watch referral volume. Private chat contents are not shown here.</p>
  </div>
</div>
<div class="grid-4">
  <div class="stat"><b><?= $pending ?></b> Counsellors waiting</div>
  <div class="stat"><b><?= $screenings ?></b> Screenings</div>
  <div class="stat"><b><?= $referrals ?></b> Referrals</div>
  <div class="stat"><b><?= $stories ?></b> Stories to moderate</div>
</div>
<div class="grid-2" style="margin-top:1.2rem">
  <a class="card" href="<?= e(url('admin/counsellors.php')) ?>"><h3>Verify counsellors</h3><p>Review certificates. No auto-approval.</p></a>
  <a class="card" href="<?= e(url('admin/analytics.php')) ?>"><h3>Analytics</h3><p>Risk-zone distribution and referral outcomes.</p></a>
</div>
<?php include dirname(__DIR__) . '/includes/app_footer.php'; ?>
