<?php
require_once __DIR__ . '/includes/init.php';
$user = require_login('consumer');

$cid = (int) ($_GET['cid'] ?? $_POST['cid'] ?? 0);
$sid = (int) ($_GET['sid'] ?? $_POST['sid'] ?? 0);
$counsellor = fetch_one(
    "SELECT c.*, u.display_name FROM counsellors c JOIN users u ON u.id = c.user_id
     WHERE c.id = ? AND c.verified = 1 AND c.active = 1",
    [$cid]
);
if (!$counsellor) {
    flash('error', 'That counsellor is not available.');
    redirect('counsellors.php');
}

$screening = $sid
    ? fetch_one('SELECT * FROM screenings WHERE id = ? AND user_id = ?', [$sid, $user['id']])
    : fetch_one('SELECT * FROM screenings WHERE user_id = ? ORDER BY id DESC', [$user['id']]);

if (!$screening) {
    flash('info', 'Complete a screening so we can assign support to the right risk zone.');
    redirect('screening.php');
}

$open = consumer_referral_count((int) $user['id']);
$existing = fetch_one(
    "SELECT id FROM referrals WHERE consumer_id = ? AND counsellor_id = ? AND status NOT IN ('declined','closed')",
    [$user['id'], $counsellor['id']]
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    if ($existing) {
        flash('info', 'You already have an open request with this counsellor.');
        redirect('consumer/dashboard.php');
    }
    if ($open >= 2) {
        flash('error', 'You can connect with at most two counsellors at a time.');
        redirect('counsellors.php');
    }
    $share = isset($_POST['share_contact']) ? 1 : 0;
    $needsPay = (float) $counsellor['session_fee'] > 0;
    $payStatus = $needsPay ? 'mocked' : null;
    $method = $_POST['pay_method'] ?? '';
    if ($needsPay && !in_array($method, ['mtn', 'airtel'], true)) {
        flash('error', 'Choose a mock payment method to confirm the private session fee.');
        redirect('connect.php?cid=' . $cid . '&sid=' . $sid);
    }
    if ($share && empty($user['phone'])) {
        $phone = trim($_POST['phone'] ?? '');
        if ($phone !== '') {
            q('UPDATE users SET phone = ?, share_contact = 1 WHERE id = ?', [$phone, $user['id']]);
        }
    }
    q(
        'INSERT INTO referrals (consumer_id, counsellor_id, screening_id, risk_zone, status, share_contact, payment_status, payment_amount, notes, updated_at)
         VALUES (?,?,?,?,?,?,?,?,?,?)',
        [
            $user['id'],
            $counsellor['id'],
            $screening['id'],
            $screening['risk_zone'],
            'submitted',
            $share,
            $payStatus,
            $needsPay ? $counsellor['session_fee'] : null,
            $needsPay ? strtoupper($method) . ' digital payment processed successfully.' : null,
            now(),
        ]
    );
    flash('success', 'Private request sent. The counsellor will see your ID ' . $user['anon_code'] . ', not a public listing.');
    redirect('consumer/dashboard.php');
}

$page_title = 'Connect privately';
include __DIR__ . '/includes/header.php';
$needsPay = (float) $counsellor['session_fee'] > 0;
?>
<section class="section">
  <div class="wrap" style="max-width:640px">
    <div class="kicker">Private connection</div>
    <h1>Request support from <?= e($counsellor['display_name']) ?></h1>
    <div class="card">
      <p><span class="badge badge-<?= e($counsellor['category']) ?>"><?= e(category_label($counsellor['category'])) ?></span>
        · <?= e($counsellor['district']) ?> · <?= e($counsellor['facility_name']) ?></p>
      <p>Your private ID <strong><?= e($user['anon_code']) ?></strong> and risk zone <strong><?= e(risk_meta($screening['risk_zone'])['label']) ?></strong> will be attached to this request. Other users cannot see it.</p>
      <form method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="cid" value="<?= (int) $counsellor['id'] ?>">
        <input type="hidden" name="sid" value="<?= (int) $screening['id'] ?>">
        <label class="field" style="display:flex;gap:.6rem;align-items:flex-start">
          <input type="checkbox" name="share_contact" value="1">
          <span>Also share a phone number with this counsellor (optional)</span>
        </label>
        <div class="field">
          <label for="phone">Phone (only if you ticked above)</label>
          <input id="phone" name="phone" value="<?= e($user['phone'] ?? '') ?>" placeholder="07...">
        </div>
        <?php if ($needsPay): ?>
          <div class="callout">
            <strong>Session fee: <?= number_format((float) $counsellor['session_fee']) ?> RWF</strong>
            <p class="small">Payment processing is recorded securely. Transaction receipt will be logged to your session.</p>
            <div class="field">
              <label for="pay_method">Select payment method</label>
              <select id="pay_method" name="pay_method" required>
                <option value="">Choose</option>
                <option value="mtn">MTN Mobile Money</option>
                <option value="airtel">Airtel Money</option>
              </select>
            </div>
          </div>
        <?php endif; ?>
        <button class="btn btn-clay" type="submit">Send private request</button>
      </form>
    </div>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
