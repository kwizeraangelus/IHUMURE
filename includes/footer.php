<footer class="site-footer">
  <div class="wrap foot-grid">
    <div>
      <div class="foot-brand">
        <span class="foot-badge">Verified Healthcare Network</span>
        <strong class="foot-title"><?= e(APP_NAME) ?></strong>
      </div>
      <p class="small"><?= e(APP_FULL_NAME) ?>. A confidential national digital health platform for alcohol abuse prevention, clinical AUDIT screening, and verified counsellor support across Rwanda.</p>
    </div>
    <div>
      <strong>Confidential Support</strong>
      <p class="small"><a href="<?= e(url('screening.php')) ?>">Take AUDIT screening</a><br>
      <a href="<?= e(url('start.php')) ?>">Get anonymous private ID</a><br>
      <a href="<?= e(url('awareness.php')) ?>">Prevention guides &amp; FAQ</a><br>
      <a href="<?= e(url('index.php#recovery')) ?>">Holistic recovery pillars</a></p>
    </div>
    <div>
      <strong>Certified Healthcare Professionals</strong>
      <p class="small"><a href="<?= e(url('counsellor/register.php')) ?>">Register as a counsellor</a><br>
      <a href="<?= e(url('login.php')) ?>">Counsellor &amp; admin portal</a><br>
      <a href="<?= e(url('stories.php')) ?>">Recovery community stories</a></p>
    </div>
  </div>
  <div class="wrap legal">
    <div class="legal-flex">
      <span>&copy; <?= date('Y') ?> <?= e(APP_NAME) ?> Platform. Developed for community health and recovery in Rwanda.</span>
      <span>Emergency: Rwanda Emergency Medical Services <strong>112</strong> &middot; Mental Health Support <strong>114</strong> &middot; Gender-based Violence Helpline <strong>3588</strong></span>
    </div>
  </div>
</footer>
<script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>
