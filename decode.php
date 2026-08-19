<?php
// decode.php
function sm_reverse_bits($orig) {
    $v = decbin(ord($orig));
    $pad = str_pad($v, 8, "0", STR_PAD_LEFT);
    $rev = strrev($pad);
    $bin = bindec($rev);
    return chr($bin);
}

function sm_decode($txt) {
    $from = array("!", "@", "#", "\$", "%", "^", "&", "*", "(", ")");
    $to = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j");
    
    $txt = base64_decode($txt);
    $out = "";
    for ($i = 0; $i < strlen($txt); $i++) {
        $out .= sm_reverse_bits($txt[$i]);
    }
    
    $txt = @gzuncompress($out);
    $txt = str_replace($from, $to, $txt);
    $txt = base64_decode($txt);
    return $txt;
}

$license_str = "这里输入 /usr/local/virtualizor/license2.php加密内容";

$json_data = sm_decode($license_str);
echo "解密后的 JSON 数据:\n";
echo json_encode(json_decode($json_data, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
?>
