<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$files = [
    'platform/themes/riorelax/views/restaurant.blade.php',
    'platform/themes/riorelax/views/restaurants.blade.php',
    'platform/themes/riorelax/partials/restaurants/item.blade.php',
    'platform/themes/riorelax/partials/main-menu.blade.php',
    'platform/themes/riorelax/partials/menu-mobile.blade.php',
    'platform/plugins/restaurant/resources/views/forms/gallery.blade.php',
];

$bad = 0;
foreach ($files as $rel) {
    $path = dirname(__DIR__) . '/' . $rel;
    $compiled = Illuminate\Support\Facades\Blade::compileString(file_get_contents($path));
    $tmp = tempnam(sys_get_temp_dir(), 'bld') . '.php';
    file_put_contents($tmp, $compiled);
    $out = shell_exec(escapeshellarg(PHP_BINARY) . ' -l ' . escapeshellarg($tmp) . ' 2>&1');
    unlink($tmp);
    $ok = str_contains((string) $out, 'No syntax errors');
    printf("%-58s %s\n", basename($rel), $ok ? 'OK' : trim((string) $out));
    if (! $ok) $bad++;
}
echo $bad ? "\n$bad file loi\n" : "\nTat ca Blade bien dich duoc.\n";
