<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
foreach (json_decode(file_get_contents(__DIR__ . '/dining.json'), true) as $id => $html) {
    $clean = BaseHelper::clean($html);
    printf("dịch vụ %s: vào %d ký tự -> ra %d (%s)\n", $id, strlen($html), strlen($clean),
        $html === $clean ? 'GIỮ NGUYÊN' : 'CÓ BỊ LỌC');
    if ($html !== $clean) {
        // tìm những gì bị mất
        preg_match_all('/style="[^"]*"/', $html, $a);
        preg_match_all('/style="[^"]*"/', $clean, $b);
        $lost = array_diff($a[0], $b[0]);
        foreach (array_slice($lost, 0, 6) as $l) echo "    mất: $l\n";
    }
}
