<?php
require_once dirname(__DIR__) . '/includes/init.php';

if (current_user()) {
    redirect(home_for(current_user()));
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim($_POST['display_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $category = $_POST['category'] ?? '';
    $district = $_POST['district'] ?? '';
    $facility = trim($_POST['facility_name'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $fee = (float) ($_POST['session_fee'] ?? 0);
    if ($category === 'public') {
        $fee = 0;
    }

    if ($name === '' || $email === '' || strlen($password) < 8 || !in_array($category, ['public','private','personal'], true) || $district === '') {
        $error = 'Please complete all required fields. Password must be at least 8 characters.';
    } elseif (fetch_one('SELECT id FROM users WHERE email = ?', [$email])) {
        $error = 'That email is already registered.';
    } else {
        try {
            $cert = save_upload($_FILES['certificate'] ?? ['error' => UPLOAD_ERR_NO_FILE], 'certificates', ['pdf','jpg','jpeg','png'], MAX_CERT_BYTES);
            if (!$cert) {
                throw new RuntimeException('Please upload a certificate (PDF, JPG or PNG).');
            }
            q(
                'INSERT INTO users (anon_code, role, display_name, email, password_hash, district) VALUES (?,?,?,?,?,?)',
                [generate_anon_code(), 'counsellor', $name, $email, password_hash($password, PASSWORD_DEFAULT), $district]
            );
            $uid = last_id();
            q(
                'INSERT INTO counsellors (user_id, category, facility_name, certificate_file, verified, active, district, bio, session_fee) VALUES (?,?,?,?,0,1,?,?,?)',
                [$uid, $category, $facility, $cert, $district, $bio, $fee]
            );
            flash('success', 'Registration received. An admin will review your certificate before you can receive requests.');
            redirect('login.php');
        } catch (RuntimeException $ex) {
            $error = $ex->getMessage();
        }
    }
}

$page_title = 'Counsellor registration';
include dirname(__DIR__) . '/includes/header.php';
?>
<section class="section">
  <div class="wrap" style="max-width:680px">
    <div class="kicker">Professionals</div>
    <h1>Register as a counsellor</h1>
    <p class="lede">Choose public, private or independent. Upload a certificate. Your account stays unverified until an administrator reviews it. There is no auto-approval.</p>
    <?php if ($error): ?><div class="flash flash-error"><?= e($error) ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="card">
      <?= csrf_field() ?>
      <div class="field">
        <label for="display_name">Full name</label>
        <input id="display_name" name="display_name" required>
      </div>
      <div class="field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required>
      </div>
      <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required minlength="8">
      </div>
      <div class="field">
        <label for="category">Category</label>
        <select id="category" name="category" required>
          <option value="public">Public facility</option>
          <option value="private">Private practice</option>
          <option value="personal">Independent / personal</option>
        </select>
      </div>
      <div class="field">
        <label for="district">District</label>
        <select id="district" name="district" required><?= district_options() ?></select>
      </div>
      <div class="field">
        <label for="facility_name">Facility or practice name</label>
        <input id="facility_name" name="facility_name">
      </div>
      <div class="field">
        <label for="session_fee">Session fee in RWF (0 for public)</label>
        <input id="session_fee" name="session_fee" type="number" min="0" value="0">
      </div>
      <div class="field">
        <label for="bio">Short bio</label>
        <textarea id="bio" name="bio"></textarea>
      </div>
      <div class="field">
        <label for="certificate">Certificate / credential</label>
        <input id="certificate" name="certificate" type="file" accept=".pdf,.jpg,.jpeg,.png" required>
        <div class="help">PDF or image, max 5 MB. Reviewed manually by admin.</div>
      </div>
      <button class="btn btn-primary" type="submit">Submit for verification</button>
    </form>
  </div>
</section>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
