<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$d = json_decode(file_get_contents(__DIR__ . '/dining.json'), true);
$clean = BaseHelper::clean($d['6']);
// so sánh từng thuộc tính CSS
preg_match_all('/style="([^"]*)"/', $d['6'], $in);
preg_match_all('/style="([^"]*)"/', $clean, $out);
$props = function ($list) { $s = []; foreach ($list as $x) foreach (explode(';', $x) as $p)
    if (trim($p)) $s[trim(explode(':', $p)[0])] = true; return array_keys($s); };
echo "CSS gửi vào : " . implode(', ', $props($in[1])) . "\n";
echo "CSS còn lại : " . implode(', ', $props($out[1])) . "\n";
echo "BỊ LOẠI     : " . implode(', ', array_diff($props($in[1]), $props($out[1]))) . "\n\n";
echo substr($clean, 0, 700) . "\n";
