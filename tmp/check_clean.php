<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$samples = [
    'h3'        => '<h3>Tiêu đề</h3>',
    'div.class' => '<div class="abc">nội dung</div>',
    'div.style' => '<div style="color:#e4762c">nội dung</div>',
    'p.style'   => '<p style="color:#e4762c;background-color:#faf7f2;padding:20px">đoạn</p>',
    'span'      => '<span style="font-size:22px;font-weight:700">chữ</span>',
    'table'     => '<table><tr><td>ô</td></tr></table>',
    'section'   => '<section>khối</section>',
    'flex'      => '<p style="display:flex;gap:10px">x</p>',
    'radius'    => '<p style="border-radius:8px;border:1px solid #ddd">x</p>',
    'img'       => '<img src="https://malibuhotel.com.vn/a.jpg" style="width:100%" alt="a">',
    'hr'        => '<hr>',
];
foreach ($samples as $k => $v) {
    printf("%-10s %s\n", $k, BaseHelper::clean($v));
}
