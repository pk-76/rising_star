<?php
$dir = 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode($B['name'] . ', ' . $B['street'] . ', ' . $B['locality'] . ', ' . $B['region'] . ' ' . $B['postal']);
$h = $C['hours'][1];
?>
<!-- ═══════════════ LOCATION ═══════════════ -->
<section class="visit dark2" id="visit" data-theme="dark" aria-labelledby="visitH">
  <?= act('THE VENUE', 'FIND US') ?>

  <div class="visit__grid">
    <div class="visit__map" data-cursor="MAP">
      <div id="map" role="img" aria-label="Dark map showing <?= e($B['name']) ?> at Six Mile, Guwahati, near GNRC Hospital"></div>
      <span class="visit__corner mono"><?= number_format($B['geo']['lat'], 3) ?>° N · <?= number_format($B['geo']['lng'], 3) ?>° E<?= $B['geo_confirmed'] ? '' : ' (APPROX.)' ?></span>
    </div>

    <div class="visit__info">
      <h2 class="h2" id="visitH" data-split>COME <em>dance.</em></h2>

      <address class="visit__addr" data-reveal>
        <?= e($B['name']) ?><br>
        <?= e($B['street']) ?>,<br>
        <?= e($B['locality']) ?>, <?= e($B['region']) ?> <?= e($B['postal']) ?>
      </address>
      <p class="visit__land mono" data-reveal>NEAR GNRC HOSPITAL · OPP. OM SHREE GUEST HOUSE · NECHA BUILDING, 2ND FLOOR</p>

      <p class="live live--lg mono<?= $state['open'] ? ' is-open' : '' ?>" id="liveBadge"><i></i><b><?= $state['open'] ? 'CLASSES OPEN NOW' : 'CLOSED NOW' ?></b></p>

      <table class="hours" id="hours" data-reveal>
        <caption class="sr-only">Opening hours</caption>
        <tbody>
        <?php foreach ([1, 2, 3, 4, 5, 6, 0] as $d): [$day, $o, $c] = $C['hours'][$d]; ?>
          <tr data-day="<?= $d ?>"<?= $d === $state['day'] ? ' class="is-today"' : '' ?>>
            <th scope="row" class="mono"><?= e(strtoupper($day)) ?></th>
            <td><?= $o === null ? '<span class="closed">Closed</span>' : fmt_hour($o) . ' – ' . fmt_hour($c) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <?php if (empty($B['hours_confirmed'])): ?><p class="mono visit__conf">APPROX. HOURS [CONFIRM] — CLASS TIMINGS VARY BY BATCH</p><?php endif; ?>

      <div class="visit__cta" data-reveal>
        <a class="btn btn--pink" href="<?= e($dir) ?>" target="_blank" rel="noopener" data-magnetic><?= roll('Directions') ?><span class="btn__arr">↗</span></a>
        <a class="btn btn--ghost" href="tel:<?= e($B['tel']) ?>" data-magnetic><?= roll('Call') ?></a>
        <a class="btn btn--ghost" href="<?= e(wa_link($C, 'Hi Rising Star Dance Academy! I’d like to know more.')) ?>" target="_blank" rel="noopener" data-magnetic><?= roll('WhatsApp') ?></a>
        <a class="btn btn--ghost" href="mailto:<?= e($B['email']) ?>" data-magnetic><?= roll('Email') ?></a>
      </div>
    </div>
  </div>
</section>
