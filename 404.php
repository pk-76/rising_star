<?php
/** Branded 404 — "MISSED YOUR CUE." */
if (!defined('RS_ROOT')) require __DIR__ . '/inc/helpers.php';
if (!isset($C)) $C = require __DIR__ . '/data/config.php';
$B = $C['biz'];
if (!headers_sent()) http_response_code(404);
$home = base_path() . '/';
?>
<!doctype html>
<html lang="en" class="js">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>Missed your cue — 404 | Rising Star Dance Academy</title>
<meta name="theme-color" content="#08070A">
<link rel="icon" type="image/svg+xml" href="<?= e(asset('img/favicon.svg')) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Anton&family=Instrument+Serif:ital@0;1&family=Inter:wght@300..600&family=Space+Mono:wght@400;700&display=swap">
<link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">
</head>
<body>
<div class="grain" aria-hidden="true"></div>
<main class="nf">
  <div class="nf__top">
    <a class="hd__logo" href="<?= e($home) ?>"><span class="beat"><?= star_svg('star') ?></span>RISING STAR</a>
    <span class="mono">ERROR 404 · OFF STAGE</span>
  </div>
  <div>
    <h1 class="nf__h">MISSED<br>YOUR <em>cue.</em></h1>
    <p class="nf__p">This page isn’t on stage. Let’s get you back to the show — your first class is on us.</p>
    <a class="btn btn--pink" href="<?= e($home) ?>"><?= roll('Back to the show') ?><span class="btn__arr">→</span></a>
  </div>
  <div class="nf__bot mono">
    <span>MISSED YOUR CUE. THIS PAGE ISN’T ON STAGE.</span>
    <span>© <?= date('Y') ?> <?= e($B['name']) ?> · <?= e($B['tagline']) ?></span>
  </div>
</main>
</body>
</html>
