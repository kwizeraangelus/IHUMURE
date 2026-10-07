<?php
/**
 * Ihumure — Smart Alcohol Abuse Prevention & Rehabilitation Support System
 * Settings come from environment variables (.env locally, Clever Cloud in production).
 */

// ---- Load .env if it exists (local development only) ----
$envFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
if (is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key   = trim($key);
        $value = trim($value, " \t\n\r\0\x0B\"'");
        if (getenv($key) === false) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

// ---- Read a variable, trying several names, with a default ----
if (!function_exists('env')) {
    function env($names, $default = null) {
        foreach ((array) $names as $name) {
            $v = getenv($name);
            if ($v !== false && $v !== '') {
                return $v;
            }
        }
        return $default;
    }
}

define('APP_NAME', 'Ihumure');
define('APP_FULL_NAME', 'Smart Alcohol Abuse Prevention & Rehabilitation Support System');
define('APP_TAGLINE', 'Private screening. Matched support. Recovery together.');

define('DB_DRIVER', env('DB_DRIVER', 'mysql')); // 'sqlite' or 'mysql'
define('DB_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'ihumure.sqlite');

// Local uses DB_*, Clever Cloud uses MYSQL_ADDON_* (set automatically when the addon is linked)
define('DB_HOST', env(['DB_HOST', 'MYSQL_ADDON_HOST'], '127.0.0.1'));
define('DB_PORT', env(['DB_PORT', 'MYSQL_ADDON_PORT'], '3306'));
define('DB_NAME', env(['DB_NAME', 'MYSQL_ADDON_DB'], 'ihumure'));
define('DB_USER', env(['DB_USER', 'MYSQL_ADDON_USER'], 'root'));
define('DB_PASS', env(['DB_PASS', 'MYSQL_ADDON_PASSWORD'], ''));

define('UPLOAD_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads');
define('MAX_CERT_BYTES', 5 * 1024 * 1024);
define('MAX_VIDEO_BYTES', 25 * 1024 * 1024);

define('JITSI_ROOM', 'IhumureRecoveryRwanda');
define('SESSION_LIFETIME', 60 * 60 * 8);