<?php
require_once dirname(__DIR__) . '/includes/init.php';
$user = require_login('consumer');
$room = JITSI_ROOM . '-' . substr(hash('sha256', 'ihumure-group'), 0, 8);
$page_title = 'Group room';
include dirname(__DIR__) . '/includes/app_header.php';
?>
<div class="page-title">
  <div>
    <h1>Recovery group room</h1>
    <p class="muted">Embedded Jitsi Meet room — no extra account required. Join only if you are comfortable. Cameras can stay off.</p>
  </div>
</div>
<iframe class="jitsi-frame" allow="camera; microphone; fullscreen; display-capture; autoplay" src="https://meet.jit.si/<?= e($room) ?>"></iframe>
<?php include dirname(__DIR__) . '/includes/app_footer.php'; ?>
