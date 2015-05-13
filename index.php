<?php
require_once __DIR__ . '/init.php';

header("Content-Type:text/html;charset=UTF-8");
header("x-frame-options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Content-Security-Policy: default-src 'self' http://*.sattan-php.com 'unsafe-inline'; script-src 'self' http://*.sattan-php.com https://cdnjs.cloudflare.com 'unsafe-inline' 'unsafe-eval'");
header("X-Content-Security-Policy: default-src 'self' http://*.sattan-php.com;script-src 'self' http://*.sattan-php.com");


V::$engine->setGlobal("author", "Kay");
$data = array('a'=>5, 'b'=>6, 'c'=>$m);
V::$engine->output('index.tpl', $data);

