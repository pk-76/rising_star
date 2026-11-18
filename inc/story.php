<!-- ═══════════════ RHYTHM MARQUEE ═══════════════ -->
<section class="mq dark" data-theme="dark" id="marquee" aria-hidden="true">
  <div class="mq__track" id="mqTrack">
    <?php for ($s = 0; $s < 2; $s++): ?>
    <div class="mq__set">
      <?php foreach ($C['marquee'] as $i => $w): ?>
        <span class="mq__w<?= $i % 2 ? ' is-o' : '' ?>"><?= e($w) ?></span><span class="mq__s beat"><?= star_svg('star') ?></span>
      <?php endforeach; ?>
    </div>
    <?php endfor; ?>
  </div>
</section>

<!-- ═══════════════ ACT I — THE ACADEMY ═══════════════ -->
<section class="act1 light" id="academy" data-theme="light" aria-labelledby="manifestoH">
  <?= act('ACT I', 'THE ACADEMY') ?>
  <span class="numeral" aria-hidden="true">I</span>
  <h2 class="sr-only" id="manifestoH">Who we are</h2>
  <p class="manifesto" id="manifesto"><?= $C['manifesto'] ?></p>

  <ul class="pillars">
    <?php foreach ($C['pillars'] as $i => [$t, $d]): ?>
    <li data-reveal>
      <span class="pillars__n mono"><?= sprintf('%02d', $i + 1) ?></span>
      <h3 class="pillars__t"><?= e($t) ?></h3>
      <p><?= e($d) ?></p>
    </li>
    <?php endforeach; ?>
  </ul>
</section>

<!-- Giant outlined word: fills with pink as you scroll through it -->
<section class="dword dark" data-theme="dark" aria-hidden="true">
  <p class="dword__t" id="dword"><span class="o">PERFORM</span><span class="f">PERFORM</span></p>
  <p class="dword__s mono"><span class="beat"><?= star_svg('star star--s') ?></span> EVERY STAR STARTS HERE <span class="beat"><?= star_svg('star star--s') ?></span></p>
</section>

<!-- ═══════════════ STATS ═══════════════ -->
<section class="stats dark" data-theme="dark" aria-label="Rising Star Dance Academy in numbers">
  <ul class="stats__l">
    <li>
      <p class="stat__n"><b data-count="<?= e($B['rating']) ?>" data-dec="1"><?= e(number_format($B['rating'], 1)) ?></b><sup class="beat">★</sup></p>
      <p class="stat__k mono">GOOGLE RATING</p>
    </li>
    <li>
      <p class="stat__n"><b data-count="<?= (int)$B['reviews'] ?>"><?= (int)$B['reviews'] ?></b><sup>+</sup></p>
      <p class="stat__k mono">REVIEWS</p>
    </li>
    <li>
      <p class="stat__n"><b data-count="<?= (int)$B['styles_count'] ?>"><?= (int)$B['styles_count'] ?></b><sup>+</sup></p>
      <p class="stat__k mono">DANCE STYLES</p>
    </li>
    <li>
      <p class="stat__n"><b data-count="<?= (int)$B['days'] ?>"><?= (int)$B['days'] ?></b><small>DAYS</small></p>
      <p class="stat__k mono">A WEEK · OPEN TO ALL</p>
    </li>
  </ul>
</section>
