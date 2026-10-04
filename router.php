<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
foreach (['/data/', '/config/', '/includes/', '/uploads/'] as $blocked) {
    if (str_starts_with($uri, $blocked)) {
        http_response_code(403);
        exit('Forbidden');
    }
}
if ($uri === '/') {
    require __DIR__ . '/index.php';
    return true;
}
$file = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, $uri);
if (is_file($file)) {
    return false;
}
http_response_code(404);
exit('Not found');
