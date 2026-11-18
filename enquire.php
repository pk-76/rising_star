<?php
/**
 * Quiet lead log for free-trial requests (no admin panel needed).
 * Appends a row to storage/leads.csv — open it in Excel/Sheets. The folder is protected from the web.
 * The visitor is always sent to WhatsApp regardless, so a failure here never blocks a booking.
 */
header('Content-Type: application/json; charset=utf-8');
header('X-Robots-Tag: noindex');
date_default_timezone_set('Asia/Kolkata');

function out(int $code, array $body): void { http_response_code($code); echo json_encode($body); exit; }

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') out(405, ['ok' => false]);

// same-origin only
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin !== '' && parse_url($origin, PHP_URL_HOST) !== ($_SERVER['HTTP_HOST'] ?? '') && parse_url($origin, PHP_URL_HOST) !== explode(':', $_SERVER['HTTP_HOST'] ?? '')[0]) out(403, ['ok' => false]);

$raw  = file_get_contents('php://input', false, null, 0, 4096);
$data = json_decode($raw ?: '', true);
if (!is_array($data)) out(400, ['ok' => false]);

// basic rate limit: 6 submissions / hour / session
session_start();
$now = time();
$_SESSION['rs_hits'] = array_values(array_filter($_SESSION['rs_hits'] ?? [], fn($t) => $t > $now - 3600));
if (count($_SESSION['rs_hits']) >= 6) out(429, ['ok' => false]);
$_SESSION['rs_hits'][] = $now;

// sanitise (also neutralise spreadsheet formula injection)
$clean = function ($v, int $max = 80): string {
    $v = trim(preg_replace('/[\x00-\x1F\x7F]+/u', ' ', (string)$v));
    $v = mb_substr($v, 0, $max);
    return preg_match('/^[=+\-@\t\r]/', $v) ? "'" . $v : $v;
};
$row = [
    date('Y-m-d H:i:s'),
    $clean($data['for']   ?? '', 20),
    $clean($data['name']  ?? '', 60),
    $clean($data['age']   ?? '', 3),
    preg_replace('/\D/', '', (string)($data['phone'] ?? '')),
    $clean($data['style'] ?? '', 30),
    $clean($data['time']  ?? '', 20),
];
if ($row[2] === '' || strlen($row[4]) < 10) out(422, ['ok' => false]);

$dir = __DIR__ . '/storage';
if (!is_dir($dir)) mkdir($dir, 0755, true);
$file = $dir . '/leads.csv';
$new  = !is_file($file);
$fh   = fopen($file, 'ab');
if (!$fh) out(500, ['ok' => false]);
flock($fh, LOCK_EX);
if ($new) fputcsv($fh, ['Received (IST)', 'For', 'Name', 'Age', 'Phone', 'Style', 'Preferred time']);
fputcsv($fh, $row);
flock($fh, LOCK_UN);
fclose($fh);

out(200, ['ok' => true]);
