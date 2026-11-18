<?php
/** Dynamic robots.txt (served at /robots.txt via .htaccess). */
require __DIR__ . '/inc/helpers.php';
$C = require __DIR__ . '/data/config.php';
header('Content-Type: text/plain; charset=utf-8');
?>
User-agent: *
Allow: /
Disallow: /storage/
Disallow: /data/
Disallow: /inc/
Disallow: /enquire.php

Sitemap: <?= base_url($C) ?>/sitemap.xml
