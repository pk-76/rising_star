<?php
/**
 * RISING STAR DANCE ACADEMY — Every star starts here.
 * Single-page "show programme" experience. All copy & data: data/config.php. No admin panel.
 */
require __DIR__ . '/inc/helpers.php';
$C        = require __DIR__ . '/data/config.php';
$B        = $C['biz'];
$state    = open_state($C['hours']);
$NAV_HOME = '';
$PAGE     = ['type' => 'home'];

foreach (['head', 'header', 'hero', 'story', 'styles', 'classes', 'stage', 'mentors', 'applause', 'timetable', 'finale', 'location', 'footer'] as $part) {
    include __DIR__ . "/inc/$part.php";
}
