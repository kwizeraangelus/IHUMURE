<?php
require_once __DIR__ . '/includes/init.php';

$user = ensure_consumer_identity();
$questions = audit_questions();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $answers = [];
    $score = 0;
    foreach ($questions as $num => $q) {
        if (!isset($_POST['q' . $num]) || $_POST['q' . $num] === '') {
            flash('error', 'Please answer all 10 questions. AUDIT is only valid when complete.');
            redirect('screening.php');
        }
        $val = (int) $_POST['q' . $num];
        if (!array_key_exists($val, $q['options'])) {
            flash('error', 'An answer was not recognised. Please try again.');
            redirect('screening.php');
        }
        $answers[$num] = $val;
        $score += $val;
    }
    $zone = risk_zone($score);
    q(
        'INSERT INTO screenings (user_id, answers, score, risk_zone) VALUES (?,?,?,?)',
        [$user['id'], json_encode($answers), $score, $zone]
    );
    redirect('result.php?id=' . last_id());
}

$page_title = 'AUDIT screening';
include __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="wrap screen-wrap">
    <div class="kicker">WHO AUDIT · 10 questions</div>
    <h1>Private self-screening</h1>
    <p class="muted">Answer about the last year. There is no right or wrong answer. Your score is saved against private ID <strong><?= e($user['anon_code']) ?></strong>.</p>
    <form method="post" class="card" data-screening>
      <?= csrf_field() ?>
      <div class="small" data-step-label>Question 1 of 10</div>
      <div class="progress"><span data-progress></span></div>
      <?php foreach ($questions as $num => $q): ?>
        <div class="q-card<?= $num === 1 ? ' on' : '' ?>">
          <h2>Q<?= $num ?>. <?= e($q['q']) ?></h2>
          <div class="options">
            <?php foreach ($q['options'] as $val => $label): ?>
              <label>
                <input type="radio" name="q<?= $num ?>" value="<?= (int) $val ?>">
                <span><?= e($label) ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
      <div class="screen-nav">
        <button class="btn btn-light" type="button" data-prev>Back</button>
        <button class="btn btn-primary" type="button" data-next>Next</button>
        <button class="btn btn-clay" type="submit" data-submit hidden>See my result</button>
      </div>
    </form>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
