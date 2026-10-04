<?php
/**
 * Ihumure — Smart Alcohol Abuse Prevention & Rehabilitation Support System
 * Switch DB_DRIVER to 'mysql' after creating the database (see sql/mysql-schema.sql).
 */

define('APP_NAME', 'Ihumure');
define('APP_FULL_NAME', 'Smart Alcohol Abuse Prevention & Rehabilitation Support System');
define('APP_TAGLINE', 'Private screening. Matched support. Recovery together.');

define('DB_DRIVER', 'mysql'); // 'sqlite' or 'mysql'
define('DB_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'ihumure.sqlite');

define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'ihumure');
define('DB_USER', 'root');
define('DB_PASS', 'Mediane123@');

define('UPLOAD_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads');
define('MAX_CERT_BYTES', 5 * 1024 * 1024);
define('MAX_VIDEO_BYTES', 25 * 1024 * 1024);

define('JITSI_ROOM', 'IhumureRecoveryRwanda');
define('SESSION_LIFETIME', 60 * 60 * 8);
