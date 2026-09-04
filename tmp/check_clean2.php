<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$samples = [
  'grid'   => '<div class="row g-4"><div class="col-md-6">A</div><div class="col-md-6">B</div></div>',
  'flexcls'=> '<div class="d-flex align-items-center justify-content-between gap-3">x</div>',
  'btn'    => '<a href="/x" class="btn btn-primary rounded-pill">Đặt bàn</a>',
  'imgcls' => '<img src="https://a/b.jpg" class="img-fluid rounded shadow" alt="a">',
  'figure' => '<figure><img src="https://a/b.jpg" alt="a"><figcaption>chú thích</figcaption></figure>',
  'style'  => '<style>.x{color:red}</style><p class="x">y</p>',
  'h2cls'  => '<h2 class="text-uppercase fw-bold">Tiêu đề</h2>',
  'ulcls'  => '<ul class="list-unstyled"><li class="mb-2">a</li></ul>',
  'datattr'=> '<div data-x="1">z</div>',
  'iframe' => '<iframe src="https://www.google.com/maps"></iframe>',
];
foreach ($samples as $k => $v) printf("%-9s %s\n", $k, BaseHelper::clean($v));
