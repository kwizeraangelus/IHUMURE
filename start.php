<?php
require_once __DIR__ . '/includes/init.php';

if (current_user()) {
    redirect(home_for(current_user()));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $district = trim($_POST['district'] ?? '') ?: null;
    create_anonymous_consumer($district);
    redirect('identity.php');
}

$page_title = 'Start privately';
include __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="wrap" style="max-width:640px">
    <div class="kicker">No name required</div>
    <h1>Continue as a private user</h1>
    <p class="lede">We will create a private ID and a 4-digit PIN. Write them down. They let us count your screenings and assign a counsellor to you — without publishing who you are.</p>
    <form method="post" class="card">
      <?= csrf_field() ?>
      <div class="field">
        <label for="district">District (optional — used only to sort nearby support)</label>
        <select id="district" name="district"><?= district_options() ?></select>
      </div>
      <button class="btn btn-clay" type="submit">Create my private ID</button>
    </form>
    <p class="small muted">Already have an ID? <a href="<?= e(url('login.php')) ?>">Return with your code</a>.</p>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
