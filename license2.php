<?php
// /var/www/virtualizor_fake/license2.php

header('Content-Type: text/plain');
header('X-Virtualizor-Fake: yes');

function sm_reverse_bits($orig)
{
    $v = decbin(ord($orig));
    $pad = str_pad($v, 8, "0", STR_PAD_LEFT);
    $rev = strrev($pad);
    $bin = bindec($rev);
    $chr = chr($bin);
    return $chr;
}

function sm_encode($txt)
{
    $from = array("!", "@", "#", "\$", "%", "^", "&", "*", "(", ")");
    $to = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j");

    // Step 1: base64 encode the plain JSON
    $txt = base64_encode($txt);

    // Step 2: reverse of decode's str_replace($from, $to)
    // Decode replaces symbols with letters, so encode replaces letters with symbols
    $txt = str_replace($to, $from, $txt);

    // Step 3: compress with zlib/gzip compatible format
    $txt = gzcompress($txt);

    // Step 4: reverse the bits of every byte
    for ($i = 0; $i < strlen($txt); $i++) {
        $txt[$i] = sm_reverse_bits($txt[$i]);
    }

    // Step 5: final base64 encode
    return base64_encode($txt);
}

// Log all license requests for debugging
file_put_contents(
    '/tmp/virtualizor_license_requests.log',
    date('Y-m-d H:i:s') . ' ' . json_encode($_GET) . "\n",
    FILE_APPEND
);

// Use request data where available
$license = $_GET['license'] ?? '49393-98969-63957-10143-18062';
$soft_email = $_GET['soft_email'] ?? 'your@email.com';
$activevps = (int)($_GET['activevps'] ?? 0);
$version = $_GET['version'] ?? '3.2.9';

$primary_ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$download_time = time();

// Make the license expire 10 years from now
$licexpires = date('Ymd', strtotime('+10 years'));
$licexpires_txt = gmdate('d/m/Y', strtotime('+10 years')) . ' GMT';

$json = [
    'license' => $license,
    'lictype' => '2',                // -1 = Trial, 1 = Full, adjust if needed
    'lictype_txt' => 'Full',
    'active' => 1,
    'active_txt' => '<font color="green">Active</font>',
    'licnumvs' => '0',               // 0 = unlimited, or set integer for a limit
    'download_time' => $download_time,
    'primary_ip' => $primary_ip,
    'licexpires' => $licexpires,
    'licexpires_txt' => $licexpires_txt,
    'last_edit' => '0',
    'fast_mirrors' => [
        'https://s0.softaculous.com/a/virtualizor',
        'https://s1.softaculous.com/a/virtualizor',
        'https://s2.softaculous.com/a/virtualizor',
        'https://s3.softaculous.com/a/virtualizor',
        'https://s4.softaculous.com/a/virtualizor',
        'https://s5.softaculous.com/a/virtualizor',
        'https://s6.softaculous.com/a/virtualizor',
        'https://s7.softaculous.com/a/virtualizor',
        'https://s8.softaculous.com/a/virtualizor'
    ]
];

$plain = json_encode($json);
echo sm_encode($plain);
