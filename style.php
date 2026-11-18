<?php
/**
 * SEO landing page for one dance style, e.g. /bollywood-dance-classes-guwahati
 * Routed by .htaccess → style.php?slug=...  Content comes from data/config.php ('styles').
 */
require __DIR__ . '/inc/helpers.php';
$C     = require __DIR__ . '/data/config.php';
$B     = $C['biz'];
$state = open_state($C['hours']);
$slug  = preg_replace('/[^a-z0-9-]/', '', strtolower($_GET['slug'] ?? ''));
$s     = style_by_slug($C, $slug);

if (!$s) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}
[$name, $slug, $desc, $age, $imgKey, $long, $learn] = $s;

$NAV_HOME = base_path() . '/';
$home     = $NAV_HOME;
$title    = "$name Dance Classes in Guwahati | Rising Star Dance Academy, Six Mile";
$metaDesc = "$name dance classes in Guwahati at Rising Star Dance Academy, Six Mile (near GNRC Hospital). $desc Kids, teens, beginners and adults welcome — book a free trial class.";

$faq = [
    ["Is there a free trial class for $name?", "Yes. Your first $name class at Rising Star is free. Book it online in under a minute and we’ll confirm the best batch on WhatsApp."],
    ["Can complete beginners join $name classes?", "Absolutely. We start from step one, so beginners of every age are welcome. Many of our students had never danced before they joined."],
    ["Which age groups do the $name classes cover?", "$age. Batches are grouped by age and level so every dancer learns at the right pace. Exact batch ages are confirmed when you enquire."],
    ["Where are the classes held?", "At " . $B['street'] . ", " . $B['locality'] . " — near GNRC Hospital, opposite Om Shree Guest House."],
    ["How do I find out about fees and timings?", "Fees depend on the batch and age group, so we share them personally. Message us on WhatsApp or call " . $B['phone'] . " for batches, timings and fees."],
];
$faqLd = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => array_map(
    fn($f) => ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]], $faq)];
$crumbs = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => [
    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Rising Star Dance Academy', 'item' => base_url($C) . '/'],
    ['@type' => 'ListItem', 'position' => 2, 'name' => "$name classes in Guwahati", 'item' => base_url($C) . '/' . $slug],
]];
$PAGE = ['type' => 'style', 'title' => $title, 'desc' => $metaDesc, 'path' => '/' . $slug, 'ld_extra' => ['@graph' => [$faqLd, $crumbs]]];
unset($PAGE['ld_extra']['@graph'][0]['@context'], $PAGE['ld_extra']['@graph'][1]['@context']);
$PAGE['ld_extra']['@context'] = 'https://schema.org';

$batches = array_values(array_filter($C['timetable'], fn($t) => $t[3] === $name));
$days    = [1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday'];
$waTrial = wa_link($C, "Hi {$B['name']}! ✨ I’d like to book a FREE TRIAL CLASS for $name.");

include __DIR__ . '/inc/head.php';
include __DIR__ . '/inc/header.php';
?>
<section class="sx dark" data-theme="dark" aria-labelledby="sxH">
  <div class="sx__bg" aria-hidden="true">
    <?= photo($C, $imgKey, ['eager' => true, 'sizes' => '100vw', 'w' => 1800]) ?>
    <?= video($C, $imgKey, ['class' => 'vid', 'autoplay' => true, 'eager' => true]) ?>
  </div>
  <?= act('STYLE', strtoupper($name)) ?>
  <h1 class="sx__h" id="sxH"><?= e(strtoupper($name)) ?> <em>classes</em><br>in Guwahati</h1>
  <p class="sx__lede"><?= e($desc) ?> At Rising Star Dance Academy, Six Mile — near GNRC Hospital.</p>
  <div class="sx__cta">
    <a class="btn btn--pink" href="<?= e($home) ?>#finale" data-magnetic><?= roll('Book Your Free Trial Class') ?><span class="btn__arr">→</span></a>
    <a class="link" href="<?= e($waTrial) ?>" target="_blank" rel="noopener"><?= roll('Enquire on WhatsApp') ?> <span class="link__arr">↗</span></a>
  </div>
  <p class="sx__meta mono"><span><?= e($age) ?></span><span>SIX MILE, GUWAHATI</span><span><?= e($B['rating']) ?>★ · <?= e($B['reviews']) ?>+ REVIEWS</span></p>
</section>

<section class="light" data-theme="light" aria-labelledby="sxAbout">
  <div class="sxb">
    <div>
      <?= act('ABOUT', strtoupper($name) . ' AT RISING STAR') ?>
      <h2 id="sxAbout" style="margin-top:28px" data-split>WHY <em style="font-family:var(--f-s);text-transform:none;color:var(--pink-d)"><?= e($name) ?>?</em></h2>
      <p data-reveal><?= e($long) ?></p>
      <p data-reveal>Our mentors teach with patience and energy, in a friendly, safe and supportive studio — and every dancer gets a chance to perform. Your first class is free, so you can feel the floor before you commit.</p>
    </div>
    <div data-reveal>
      <p class="mono" style="color:var(--pink-d);margin-bottom:14px">WHAT YOU’LL LEARN</p>
      <ul><?php foreach ($learn as $l): ?><li><?= e($l) ?></li><?php endforeach; ?></ul>
    </div>
  </div>
</section>

<section class="dark2" data-theme="dark" aria-labelledby="sxBatch">
  <?= act('TIMETABLE', 'CURRENT ' . strtoupper($name) . ' BATCHES') ?>
  <h2 class="h2" id="sxBatch" style="margin:28px 0 40px;font-size:clamp(2.6rem,7vw,7rem)" data-split>BATCHES <em>this week.</em></h2>
  <?php if ($batches): ?>
  <div class="ttg" style="border-top:1px solid var(--line);grid-template-columns:repeat(auto-fit,minmax(240px,1fr))">
    <?php foreach ($batches as [$d, $st, $en, $sn, $ag, $lv]): $msg = "Hi {$B['name']}! ✨ I’d like to book a FREE TRIAL CLASS for this batch: {$days[$d]} " . fmt_clock($st) . ' – ' . fmt_clock($en) . " · $sn ($ag)."; ?>
    <a class="slot" style="color:var(--ivory);border-color:var(--line);margin:0;padding:22px 18px" href="<?= e(wa_link($C, $msg)) ?>" target="_blank" rel="noopener">
      <span class="slot__t mono" style="color:var(--pink)"><?= e($days[$d]) ?> · <?= e(fmt_clock($st)) ?> – <?= e(fmt_clock($en)) ?></span>
      <span class="slot__s"><?= e($sn) ?></span>
      <span class="slot__m mono" style="color:var(--smoke)"><?= e(strtoupper($ag)) ?> · <?= e(strtoupper($lv)) ?></span>
      <span class="slot__b mono" style="color:var(--yellow)">BOOK TRIAL →</span>
    </a>
    <?php endforeach; ?>
  </div>
  <?php if (!empty($C['timetable_placeholder'])): ?><p class="mono" style="color:var(--smoke);margin-top:18px">[PLACEHOLDER TIMINGS — REPLACE WITH REAL BATCHES]</p><?php endif; ?>
  <?php else: ?>
  <p class="sx__lede">New <?= e($name) ?> batches are forming — message us and we’ll find the right slot.</p>
  <?php endif; ?>
</section>

<section class="light sxfaq" data-theme="light" aria-labelledby="sxFaq">
  <?= act('FAQ', 'QUESTIONS PARENTS ASK') ?>
  <h2 class="h2" id="sxFaq" style="margin:28px 0 36px;font-size:clamp(2.6rem,7vw,7rem)" data-split>GOOD <em>questions.</em></h2>
  <div style="max-width:900px">
    <?php foreach ($faq as [$q, $a]): ?>
    <details><summary><?= e($q) ?></summary><p><?= e($a) ?></p></details>
    <?php endforeach; ?>
  </div>
</section>

<section class="dark" data-theme="dark" aria-labelledby="sxMore">
  <?= act('MORE', 'EXPLORE OTHER STYLES') ?>
  <h2 class="h2" id="sxMore" style="margin:28px 0 40px;font-size:clamp(2.6rem,7vw,7rem)" data-split>ONE ACADEMY.<br><em>six</em> ways to shine.</h2>
  <div class="sxs">
    <?php foreach ($C['styles'] as $o): if ($o[1] === $slug) continue; ?>
    <a href="<?= e(base_path() . '/' . $o[1]) ?>"><span><?= e($o[0]) ?></span><span class="mono">VIEW →</span></a>
    <?php endforeach; ?>
    <a href="<?= e($home) ?>#finale"><span>Free trial</span><span class="mono">BOOK →</span></a>
  </div>
</section>

<?php include __DIR__ . '/inc/location.php'; include __DIR__ . '/inc/footer.php'; ?>
