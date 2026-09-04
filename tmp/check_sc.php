<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$in = '<shortcode>[faqs category_ids="1,2,3,4,5"][/faqs]</shortcode>';
$out = BaseHelper::clean($in);
echo "vao : $in\n";
echo "ra  : $out\n";
echo "shortcode con nguyen: " . (str_contains($out, '[faqs') ? 'CO' : 'KHONG') . "\n";
