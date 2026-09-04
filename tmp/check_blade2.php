<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$files = [
    'platform/themes/riorelax/partials/booking-mask.blade.php',
    'platform/themes/riorelax/layouts/base.blade.php',
];
foreach ($files as $rel) {
    $compiled = Illuminate\Support\Facades\Blade::compileString(
        file_get_contents(dirname(__DIR__) . '/' . $rel));
    $tmp = tempnam(sys_get_temp_dir(), 'bld') . '.php';
    file_put_contents($tmp, $compiled);
    $out = shell_exec(escapeshellarg(PHP_BINARY) . ' -l ' . escapeshellarg($tmp) . ' 2>&1');
    unlink($tmp);
    printf("%-34s %s\n", basename($rel),
        str_contains((string) $out, 'No syntax errors') ? 'OK' : trim((string) $out));
}
