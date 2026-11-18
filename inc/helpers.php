<?php
/** Shared helpers for Rising Star Dance Academy templates. */

date_default_timezone_set('Asia/Kolkata');

define('RS_ROOT', dirname(__DIR__));

function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

/** URL path to the site root, e.g. "" or "/Rising_Star-Dance_Academy". Works from any rewritten URL. */
function base_path(): string
{
    static $p = null;
    if ($p !== null) return $p;
    $docroot = rtrim(str_replace('\\', '/', (string)($_SERVER['DOCUMENT_ROOT'] ?? '')), '/');
    $root    = str_replace('\\', '/', RS_ROOT);
    if ($docroot !== '' && strpos($root, $docroot) === 0) {
        $p = rtrim(substr($root, strlen($docroot)), '/');
    } else {
        $p = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    }
    return $p;
}

function base_url(array $cfg = []): string
{
    if (!empty($cfg['biz']['site_url'])) return rtrim($cfg['biz']['site_url'], '/');
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    return ($https ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . base_path();
}

/** Asset URL with cache-busting mtime. */
function asset(string $path): string
{
    $file = RS_ROOT . '/assets/' . $path;
    return base_path() . '/assets/' . $path . (is_file($file) ? '?v=' . filemtime($file) : '');
}

function num($n): string { return number_format((float)$n, 0, '.', ','); }

/* ───────── time ───────── */
function ist_now(): DateTime { return new DateTime('now', new DateTimeZone('Asia/Kolkata')); }

function open_state(array $hours): array
{
    $now = ist_now();
    $d   = (int)$now->format('w');
    $h   = (int)$now->format('G') + ((int)$now->format('i')) / 60;
    $row = $hours[$d];
    return ['open' => $row[1] !== null && $h >= $row[1] && $h < $row[2], 'time' => $now->format('H:i'), 'day' => $d];
}

function fmt_hour($h): string
{
    $m  = (int)round(($h - floor($h)) * 60);
    $hh = (int)floor($h);
    $s  = $hh >= 12 ? 'PM' : 'AM';
    $x  = $hh % 12 ?: 12;
    return $x . ':' . sprintf('%02d', $m) . ' ' . $s;
}

function fmt_clock(string $hm): string
{
    [$h, $m] = array_map('intval', explode(':', $hm));
    return fmt_hour($h + $m / 60);
}

/* ───────── links ───────── */
function wa_link(array $cfg, string $msg = ''): string
{
    return 'https://wa.me/' . $cfg['biz']['wa'] . ($msg !== '' ? '?text=' . rawurlencode($msg) : '');
}

/** "RISING STAR" style star glyph as inline SVG */
function star_svg(string $cls = 'star'): string
{
    return '<svg class="' . e($cls) . '" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M12 1.5l2.9 6.6 7.1.7-5.4 4.8 1.6 7-6.2-3.7-6.2 3.7 1.6-7L2 8.8l7.1-.7z"/></svg>';
}

/** Rolling text for hover flips. */
function roll(string $t): string
{
    $t = e($t);
    return '<span class="roll"><span class="roll__a">' . $t . '</span><span class="roll__b" aria-hidden="true">' . $t . '</span></span>';
}

/** Act label — tiny mono caps, like a theatre programme. */
function act(string $no, string $title): string
{
    return '<div class="act mono" data-reveal><span class="beat-s">' . star_svg('star star--s') . '</span><span>' . e($no) . '</span><i></i><span>' . e($title) . '</span></div>';
}

/* ───────── media ───────── */
function local_photo(string $key): ?string
{
    foreach (['avif', 'webp', 'jpg', 'jpeg', 'png'] as $ext) {
        if (is_file(RS_ROOT . "/assets/img/photos/$key.$ext")) return asset("img/photos/$key.$ext");
    }
    return null;
}

function stock_url(string $id, int $w, int $q = 72): string
{
    return "https://images.unsplash.com/photo-$id?auto=format&fit=max&w=$w&q=$q";
}

/**
 * Responsive <img> for an image key; emits the "REPLACE WITH REAL RISING STAR PHOTO" brief for placeholders.
 * opts: sizes, eager, class, w, cors, extra
 */
function photo(array $cfg, string $key, array $o = []): string
{
    $img = $cfg['images'][$key] ?? null;
    if (!$img) return '';
    [$id, $alt, $brief, $pos] = $img;
    $sizes = $o['sizes'] ?? '100vw';
    $attrs = !empty($o['eager']) ? 'fetchpriority="high" decoding="async"' : 'loading="lazy" decoding="async"';
    if (!empty($o['cors'])) $attrs .= ' crossorigin="anonymous"';
    if (!empty($o['extra'])) $attrs .= ' ' . $o['extra'];
    $cls   = e($o['class'] ?? '');
    $style = 'object-position:' . e($pos);

    if ($local = local_photo($key)) {
        return '<img src="' . e($local) . '" alt="' . e($alt) . '" class="' . $cls . '" style="' . $style . '" ' . $attrs . '>';
    }
    $brief  = str_replace('--', '–', $brief);
    $srcset = [];
    foreach ([480, 800, 1200, 1800, 2400] as $w) $srcset[] = stock_url($id, $w) . " {$w}w";
    return "<!-- REPLACE WITH REAL RISING STAR PHOTO/VIDEO (shot brief: $brief) — save as assets/img/photos/$key.jpg or assets/video/$key.mp4 -->\n"
        . '<img src="' . e(stock_url($id, (int)($o['w'] ?? 1200))) . '" srcset="' . e(implode(', ', $srcset)) . '" sizes="' . e($sizes)
        . '" alt="' . e($alt) . '" class="' . $cls . '" style="' . $style . '" ' . $attrs . '>';
}

function photo_url(array $cfg, string $key, int $w = 1600): string
{
    $img = $cfg['images'][$key] ?? null;
    return $img ? (local_photo($key) ?: stock_url($img[0], $w)) : '';
}

/** Local looping video (if the academy has supplied one). Returns '' when no file exists. */
function video(array $cfg, string $key, array $o = []): string
{
    $mp4  = RS_ROOT . "/assets/video/$key.mp4";
    $webm = RS_ROOT . "/assets/video/$key.webm";
    $mob  = RS_ROOT . "/assets/video/$key-m.mp4";
    if (!is_file($mp4) && !is_file($webm)) return '';
    $poster = photo_url($cfg, $key, 1400);
    $src = '';
    if (is_file($mob))  $src .= '<source src="' . e(asset("video/$key-m.mp4")) . '" type="video/mp4" media="(max-width:700px)">';
    if (is_file($webm)) $src .= '<source src="' . e(asset("video/$key.webm")) . '" type="video/webm">';
    if (is_file($mp4))  $src .= '<source src="' . e(asset("video/$key.mp4")) . '" type="video/mp4">';
    $cls  = e($o['class'] ?? 'vid');
    $auto = !empty($o['autoplay']) ? ' autoplay' : '';
    $pre  = !empty($o['eager']) ? 'auto' : 'none';
    return '<video class="' . $cls . '" muted loop playsinline' . $auto . ' preload="' . $pre . '" poster="' . e($poster)
        . '" data-key="' . e($key) . '" aria-label="' . e($cfg['images'][$key][1] ?? '') . '">' . $src . '</video>';
}

/** Look up a style by slug. */
function style_by_slug(array $cfg, string $slug): ?array
{
    foreach ($cfg['styles'] as $s) if ($s[1] === $slug) return $s;
    return null;
}

/** Letters wrapped for masked reveals. */
function letters(string $word, string $cls = 'l'): string
{
    $o = '';
    foreach (preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY) as $c) {
        $o .= $c === ' ' ? '<span class="sp"></span>' : '<span class="m"><span class="' . $cls . '">' . e($c) . '</span></span>';
    }
    return $o;
}
