<?php
$days = [1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun'];
$daysFull = [1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday'];
$styleNames = array_map(fn($s) => $s[0], $C['styles']);
$ages = ['Kids', 'Teens', 'Adults'];
$byDay = [];
foreach ($C['timetable'] as $t) $byDay[$t[0]][] = $t;
foreach ($byDay as &$d) usort($d, fn($a, $b) => strcmp($a[1], $b[1])); unset($d);
?>
<!-- ═══════════════ ACT VII — TIMETABLE ═══════════════ -->
<section class="tt light" id="timetable" data-theme="light" aria-labelledby="ttH">
  <?= act('ACT VII', 'TIMETABLE') ?>
  <span class="numeral" aria-hidden="true">VII</span>
  <div class="tt__head">
    <h2 class="h2" id="ttH" data-split>THE WEEK,<br><em>choreographed.</em></h2>
    <p class="tt__copy" data-reveal>Filter by style and age, then tap a batch to book a free trial for that exact slot.<?php if (!empty($C['timetable_placeholder'])): ?> <span class="mono tt__ph">[PLACEHOLDER TIMINGS — REPLACE WITH REAL BATCHES]</span><?php endif; ?></p>
  </div>

  <div class="tt__filters" data-reveal>
    <div class="tt__group" role="group" aria-label="Filter by dance style">
      <span class="mono tt__lab">STYLE</span>
      <button type="button" class="fchip is-on" data-fstyle="all" aria-pressed="true">All</button>
      <?php foreach ($styleNames as $sn): ?><button type="button" class="fchip" data-fstyle="<?= e($sn) ?>" aria-pressed="false"><?= e($sn) ?></button><?php endforeach; ?>
    </div>
    <div class="tt__group" role="group" aria-label="Filter by age group">
      <span class="mono tt__lab">AGE</span>
      <button type="button" class="fchip is-on" data-fage="all" aria-pressed="true">All</button>
      <?php foreach ($ages as $a): ?><button type="button" class="fchip" data-fage="<?= e($a) ?>" aria-pressed="false"><?= e($a) ?></button><?php endforeach; ?>
    </div>
  </div>

  <div class="ttg" id="ttGrid">
    <?php foreach ($days as $n => $short): ?>
    <div class="ttg__day" data-day="<?= $n ?>">
      <p class="ttg__h mono"><b><?= e($short) ?></b><span><?= e($daysFull[$n]) ?></span></p>
      <ul>
        <?php foreach ($byDay[$n] ?? [] as [$d, $st, $en, $style, $age, $level]): ?>
        <li>
          <button type="button" class="slot" data-style="<?= e($style) ?>" data-age="<?= e($age) ?>"
                  data-batch="<?= e($daysFull[$n] . ' ' . fmt_clock($st) . ' – ' . fmt_clock($en) . ' · ' . $style . ' (' . $age . ')') ?>">
            <span class="slot__t mono"><?= e(fmt_clock($st)) ?> – <?= e(fmt_clock($en)) ?></span>
            <span class="slot__s"><?= e($style) ?></span>
            <span class="slot__m mono"><?= e(strtoupper($age)) ?> · <?= e(strtoupper($level)) ?></span>
            <span class="slot__b mono">BOOK TRIAL →</span>
          </button>
        </li>
        <?php endforeach; ?>
        <?php if (empty($byDay[$n])): ?><li class="ttg__none mono">— NO BATCH —</li><?php endif; ?>
      </ul>
    </div>
    <?php endforeach; ?>
  </div>
  <p class="tt__empty mono" id="ttEmpty" hidden>NO BATCH MATCHES THAT FILTER YET — <button type="button" class="link link--btn link--ink" data-enquire="a new batch">ASK US ABOUT ONE →</button></p>
</section>
