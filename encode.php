<?php
// encode.php

// 1. 位反转函数
function sm_reverse_bits($orig) {
    $v = decbin(ord($orig));
    $pad = str_pad($v, 8, "0", STR_PAD_LEFT);
    $rev = strrev($pad);
    $bin = bindec($rev);

    return chr($bin);
}

// 2. 编码函数
function sm_encode($json_string) {

    $from_dec = array(
        "!", "@", "#", "$", "%", "^", "&", "*", "(", ")"
    );

    $to_dec = array(
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j"
    );

    // 步骤 1: Base64
    $txt = base64_encode($json_string);

    // 步骤 2: a-j 替换为特殊符号
    $txt = str_replace(
        $to_dec,
        $from_dec,
        $txt
    );

    // 步骤 3: zlib 压缩
    $txt = gzcompress($txt);

    if ($txt === false) {
        throw new Exception("gzcompress() 失败");
    }

    // 步骤 4: 每个字节位反转
    $out = "";

    for ($i = 0; $i < strlen($txt); $i++) {
        $out .= sm_reverse_bits($txt[$i]);
    }

    // 步骤 5: 最终 Base64
    return base64_encode($out);
}


// 3. Console 输入函数
function read_console($message) {

    echo $message;

    $value = fgets(STDIN);

    if ($value === false) {
        return "";
    }

    return trim($value);
}


// =====================================================
// 从控制台读取参数
// =====================================================

echo "========================================\n";
echo "       Local License Encode Tool\n";
echo "========================================\n\n";

$license = read_console(
    '请输入 license: '
);

if ($license === "") {
    fwrite(
        STDERR,
        "错误：license 不能为空\n"
    );

    exit(1);
}


$primary_ip = read_console(
    '请输入 primary_ip: '
);

if ($primary_ip === "") {
    fwrite(
        STDERR,
        "错误：primary_ip 不能为空\n"
    );

    exit(1);
}


// 校验 IP 地址
if (
    filter_var(
        $primary_ip,
        FILTER_VALIDATE_IP
    ) === false
) {

    fwrite(
        STDERR,
        "错误：primary_ip 格式不正确\n"
    );

    exit(1);
}


// =====================================================
// 4. 构建数据
// =====================================================

$data = array(

    "license" => $license,

    "lictype" => "1",

    "lictype_txt" => "Premium",

    "active" => 1,

    "active_txt" => "<font color=\"green\">Active</font>",

    "licnumvs" => "0",

    "download_time" => 1787035863,

    "primary_ip" => $primary_ip,

    "licexpires" => "20991231",

    "licexpires_txt" => "31/12/2099 GMT",

    "last_edit" => "0",

    "fast_mirrors" => array(

        "https://s0.softaculous.com/a/virtualizor",

        "https://s1.softaculous.com/a/virtualizor",

        "https://s2.softaculous.com/a/virtualizor",

        "https://s3.softaculous.com/a/virtualizor",

        "https://s4.softaculous.com/a/virtualizor",

        "https://s5.softaculous.com/a/virtualizor",

        "https://s6.softaculous.com/a/virtualizor",

        "https://s7.softaculous.com/a/virtualizor",

        "https://s8.softaculous.com/a/virtualizor"
    )
);


// =====================================================
// 5. JSON
// =====================================================

$json_payload = json_encode(
    $data,
    JSON_UNESCAPED_SLASHES
);

if ($json_payload === false) {

    fwrite(
        STDERR,
        "JSON 编码失败：" .
        json_last_error_msg() .
        "\n"
    );

    exit(1);
}


// =====================================================
// 6. 编码
// =====================================================

try {

    $encoded = sm_encode(
        $json_payload
    );

} catch (Throwable $e) {

    fwrite(
        STDERR,
        "编码失败：" .
        $e->getMessage() .
        "\n"
    );

    exit(1);
}


// =====================================================
// 7. 输出
// =====================================================

echo "\n";
echo "========================================\n";
echo "输入参数\n";
echo "========================================\n";

echo "license    : " . $license . "\n";
echo "primary_ip : " . $primary_ip . "\n";


echo "\n";
echo "========================================\n";
echo "JSON Payload\n";
echo "========================================\n";

echo $json_payload . "\n";


echo "\n";
echo "========================================\n";
echo "Encoded Result\n";
echo "========================================\n";

echo $encoded . "\n";


echo "\n";
echo "========================================\n";
echo "完成\n";
echo "========================================\n";
