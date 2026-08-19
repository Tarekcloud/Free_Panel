<?php

$data = [
    'version' => '3.2.9',
    'patch' => '7',

    'message' =>
        '<p><strong>Virtualizor 3.2.9 Patch 7</strong></p>' .
        '<p>Served from local update mirror.</p>',

    'mode' => 1,

    'link' =>
        'https://api.virtualizor.com/a/virtualizor/updates.php?give=3.2.9.7',

    'redirect' => '/index.php',
];

echo serialize($data);
