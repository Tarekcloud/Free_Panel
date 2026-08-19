<?php

$packages = [
    '3.2.9.7' => '/var/www/relay-web/public/virtualizor-packages/virtualizor-3.2.9.7.pkg',
];

$give = $_GET['give'] ?? '';

if (!isset($packages[$give])) {
    http_response_code(404);
    exit('Invalid update version');
}

$file = $packages[$give];

if (!is_file($file)) {
    http_response_code(404);
    exit('Update package not found');
}

header('Content-Type: application/octet-stream');
header('Content-Length: ' . filesize($file));
header(
    'Content-Disposition: attachment; filename="virtualizor-' .
    $give .
    '.pkg"'
);

readfile($file);
