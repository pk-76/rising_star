<?php
$url   = base_url($C);
$PAGE  = $PAGE ?? ['type' => 'home'];
$pgTitle = $PAGE['title'] ?? $C['seo']['title'];
$pgDesc  = $PAGE['desc']  ?? $C['seo']['description'];
$canon = $url . ($PAGE['path'] ?? '/');
$og    = $url . '/assets/img/og.png';

$ld = [
    '@context'    => 'https://schema.org',
    '@type'       => ['DanceSchool', 'LocalBusiness'],
    '@id'         => $url . '/#school',
    'name'        => $B['name'],
    'url'         => $url . '/',
    'image'       => [$og],
    'description' => $C['seo']['description'],
    'telephone'   => $B['tel'],
    'email'       => $B['email'],
    'address'     => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => $B['street'],
        'addressLocality' => $B['locality'],
        'addressRegion'   => $B['region'],
        'postalCode'      => $B['postal'],
        'addressCountry'  => $B['country'],
    ],
    'openingHoursSpecification' => [[
        '@type'     => 'OpeningHoursSpecification',
        'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        'opens'     => '08:00',
        'closes'    => '20:30',
    ]],
    'aggregateRating' => [
        '@type' => 'AggregateRating', 'ratingValue' => (string)$B['rating'],
        'reviewCount' => (string)$B['reviews'], 'bestRating' => '5',
    ],
    'hasMap'     => 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($B['name'] . ', ' . $B['street'] . ', ' . $B['locality']),
    'areaServed' => ['@type' => 'City', 'name' => 'Guwahati'],
    'knowsAbout' => array_map(fn($s) => $s[0] . ' dance', $C['styles']),
];
if (!empty($B['geo_confirmed'])) {
    $ld['geo'] = ['@type' => 'GeoCoordinates', 'latitude' => $B['geo']['lat'], 'longitude' => $B['geo']['lng']];
}
$sameAs = [];
if (!empty($B['instagram'])) $sameAs[] = 'https://instagram.com/' . ltrim($B['instagram'], '@');
if (!empty($B['facebook']))  $sameAs[] = 'https://facebook.com/' . ltrim($B['facebook'], '/');
if ($sameAs) $ld['sameAs'] = $sameAs;
$lds = [$ld];
if (!empty($PAGE['ld_extra'])) $lds[] = $PAGE['ld_extra'];
?>
<!doctype html>
<html lang="en" class="no-js is-static">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= e($pgTitle) ?></title>
<meta name="description" content="<?= e($pgDesc) ?>">
<meta name="keywords" content="<?= e($C['seo']['keywords']) ?>">
<meta name="theme-color" content="#08070A">
<meta name="color-scheme" content="dark">
<link rel="canonical" href="<?= e($canon) ?>">

<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= e($B['name']) ?>">
<meta property="og:title" content="<?= e($pgTitle) ?>">
<meta property="og:description" content="<?= e($pgDesc) ?>">
<meta property="og:url" content="<?= e($canon) ?>">
<meta property="og:image" content="<?= e($og) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="en_IN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($pgTitle) ?>">
<meta name="twitter:description" content="<?= e($pgDesc) ?>">
<meta name="twitter:image" content="<?= e($og) ?>">

<link rel="icon" type="image/svg+xml" href="<?= e(asset('img/favicon.svg')) ?>">
<link rel="apple-touch-icon" href="<?= e(asset('img/apple-touch-icon.png')) ?>">

<style>html{background:#08070A}body{margin:0;background:#08070A}</style>
<script>
(function(d){
  var r = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
  d.className = 'js' + (r ? ' is-static reduce' : '');
  try { if (localStorage.getItem('rs_seen')) d.classList.add('seen'); } catch (e) {}
})(document.documentElement);
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://images.unsplash.com" crossorigin>
<?php $fonts = 'https://fonts.googleapis.com/css2?family=Anton&family=Instrument+Serif:ital@0;1&family=Inter:wght@300..600&family=Space+Mono:wght@400;700&display=swap'; ?>
<link rel="preload" as="style" href="<?= $fonts ?>" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="<?= $fonts ?>"></noscript>
<link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">

<?php foreach ($lds as $l): ?>
<script type="application/ld+json"><?= json_encode($l, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
<?php endforeach; ?>
</head>
<body id="body">
<a class="skip" href="#main">Skip to content</a>
