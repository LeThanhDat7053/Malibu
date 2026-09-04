<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach (['#0e4d97', 'rgb(228, 118, 44)', '#E4762C', 'rgb(22,25,44)'] as $color) {
    $rgb = BaseHelper::hexToRgb($color);
    $dark = sprintf('#%02x%02x%02x',
        (int) max(0, $rgb['red'] * .78),
        (int) max(0, $rgb['green'] * .78),
        (int) max(0, $rgb['blue'] * .78));
    printf("%-20s -> rgb(%3s,%3s,%3s)  dam hon: %s\n",
        $color, $rgb['red'], $rgb['green'], $rgb['blue'], $dark);
}
