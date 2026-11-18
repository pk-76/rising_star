<!-- ═══════════════ ACT V — THE MENTORS ═══════════════ -->
<section class="mentors dark2" id="mentors" data-theme="dark" aria-labelledby="mentorsH">
  <?= act('ACT V', 'THE MENTORS') ?>
  <span class="numeral" aria-hidden="true">V</span>
  <div class="mentors__head">
    <h2 class="h2" id="mentorsH" data-split>THE PEOPLE<br>BEHIND <em>every step.</em></h2>
    <p class="mentors__copy" data-reveal>Patient. Encouraging. Seriously talented. Meet the mentors who’ll know your name, your style and your next big moment.</p>
  </div>

  <div class="mentor-row">
    <?php foreach ($C['mentors'] as $i => [$name, $spec, $exp, $imgKey]): ?>
    <article class="mc mc--<?= $i + 1 ?>" data-speed="<?= [-40, 60, -20][$i] ?>">
      <div class="mc__ph" data-clip data-spot>
        <div class="mc__in fx" data-cursor="VIEW" data-parallax><?= photo($C, $imgKey, ['sizes' => '(min-width:900px) 30vw, 85vw', 'w' => 1000]) ?></div>
        <span class="mc__glow" aria-hidden="true"></span>
        <span class="mc__idx mono">0<?= $i + 1 ?></span>
      </div>
      <div class="mc__meta">
        <h3 class="mc__name"><?= e($name) ?></h3>
        <p class="mc__spec mono"><?= e($spec) ?></p>
        <p class="mc__exp mono"><?= e($exp) ?></p>
      </div>
    </article>
    <?php endforeach; ?>
  </div>
</section>
