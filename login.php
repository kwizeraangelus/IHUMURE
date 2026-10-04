<?php
require_once __DIR__ . '/includes/init.php';

if (current_user()) {
    redirect(home_for(current_user()));
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $mode = $_POST['mode'] ?? 'id';

    if ($mode === 'id') {
        $code = strtoupper(trim($_POST['anon_code'] ?? ''));
        $pin = trim($_POST['pin'] ?? '');
        $user = fetch_one('SELECT * FROM users WHERE anon_code = ? AND role = ?', [$code, 'consumer']);
        if (!$user || empty($user['pin_hash']) || !password_verify($pin, $user['pin_hash'])) {
            $error = 'Private ID or PIN is not correct.';
        } else {
            login_user($user);
            redirect('consumer/dashboard.php');
        }
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $user = fetch_one('SELECT * FROM users WHERE email = ?', [$email]);
        if (!$user || empty($user['password_hash']) || !password_verify($password, $user['password_hash'])) {
            $error = 'Email or password is not correct.';
        } else {
            login_user($user);
            redirect(home_for($user));
        }
    }
}

$page_title = 'Sign in';
include __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="wrap">
    <div class="form-card card" data-tabs-root>
      <h1>Sign in</h1>
      <p class="muted small">Consumers can return with a private ID. Counsellors and admin use email.</p>
      <?php if ($error): ?><div class="flash flash-error"><?= e($error) ?></div><?php endif; ?>
      <div class="tabs" data-tabs>
        <button class="tab on" type="button" data-tab="id">Private ID</button>
        <button class="tab" type="button" data-tab="account">Email account</button>
      </div>
      <form method="post" data-pane="id">
        <?= csrf_field() ?>
        <input type="hidden" name="mode" value="id">
        <div class="field">
          <label for="anon_code">Private ID</label>
          <input id="anon_code" name="anon_code" required placeholder="IH-XXXXXX">
        </div>
        <div class="field">
          <label for="pin">PIN</label>
          <input id="pin" name="pin" required maxlength="4" inputmode="numeric" placeholder="4 digits">
        </div>
        <button class="btn btn-primary" type="submit">Return privately</button>
      </form>
      <form method="post" data-pane="account" hidden>
        <?= csrf_field() ?>
        <input type="hidden" name="mode" value="account">
        <div class="field">
          <label for="email">Email</label>
          <input id="email" name="email" type="email" required>
        </div>
        <div class="field">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" required>
        </div>
        <button class="btn btn-primary" type="submit">Sign in</button>
      </form>
      <p class="small muted" style="margin-top:1rem">Need an ID? <a href="<?= e(url('start.php')) ?>">Start anonymously</a>. Counsellor? <a href="<?= e(url('counsellor/register.php')) ?>">Register</a>.</p>
      <div class="callout small" style="margin-top:1rem">
        <strong>Demo accounts</strong><br>
        Private ID <code>IH-DEMO01</code> / PIN <code>2026</code><br>
        Admin <code>admin@ihumure.rw</code> / <code>Admin@2026</code><br>
        Counsellor <code>umutoni@ihumure.rw</code> / <code>Counsel@2026</code>
      </div>
    </div>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
