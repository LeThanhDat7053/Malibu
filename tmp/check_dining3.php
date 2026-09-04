<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$props = function ($html) {
    preg_match_all('/style="([^"]*)"/', $html, $m);
    $s = [];
    foreach ($m[1] as $x) foreach (explode(';', $x) as $p)
        if (trim($p)) $s[trim(explode(':', $p)[0])] = true;
    return array_keys($s);
};
$tags = function ($html) {
    preg_match_all('/<([a-z0-9]+)/i', $html, $m); return array_unique($m[1]);
};
$classes = function ($html) {
    preg_match_all('/class="([^"]*)"/', $html, $m);
    $s = []; foreach ($m[1] as $x) foreach (explode(' ', $x) as $c) if ($c) $s[$c] = true;
    return array_keys($s);
};
$bad = 0;
foreach (json_decode(file_get_contents(__DIR__ . '/dining.json'), true) as $id => $html) {
    $c = BaseHelper::clean($html);
    $lostCss = array_diff($props($html), $props($c));
    $lostTag = array_diff($tags($html), $tags($c));
    $lostCls = array_diff($classes($html), $classes($c));
    $ok = !$lostCss && !$lostTag && !$lostCls;
    printf("%-8s %s\n", $id, $ok ? 'OK - không mất gì' : 'MẤT: css[' . implode(',', $lostCss)
        . '] tag[' . implode(',', $lostTag) . '] class[' . implode(',', $lostCls) . ']');
    if (!$ok) $bad++;
}
echo $bad ? "\n$bad trang có vấn đề\n" : "\nCả 6 bản nội dung qua bộ lọc nguyên vẹn.\n";
