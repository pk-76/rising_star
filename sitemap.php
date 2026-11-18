<?php
/** Dynamic sitemap.xml (served at /sitemap.xml via .htaccess). */
require __DIR__ . '/inc/helpers.php';
$C   = require __DIR__ . '/data/config.php';
$url = base_url($C);
$now = date('Y-m-d', filemtime(__DIR__ . '/data/config.php'));
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url><loc><?= e($url) ?>/</loc><lastmod><?= $now ?></lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>
<?php foreach ($C['styles'] as $s): ?>
  <url><loc><?= e($url . '/' . $s[1]) ?></loc><lastmod><?= $now ?></lastmod><changefreq>monthly</changefreq><priority>0.8</priority></url>
<?php endforeach; ?>
</urlset>
