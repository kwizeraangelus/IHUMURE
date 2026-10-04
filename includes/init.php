<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('ROOT', dirname(__DIR__));

require_once ROOT . '/config/config.php';
require_once ROOT . '/includes/db.php';
require_once ROOT . '/includes/schema.php';
require_once ROOT . '/includes/functions.php';
require_once ROOT . '/includes/auth.php';
require_once ROOT . '/includes/seed.php';

install_schema(db());
seed_if_empty();
ensure_upload_dirs();
