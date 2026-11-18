<!-- ═══════════════ ACT III — CLASSES FOR EVERYONE ═══════════════ -->
<section class="classes light" id="classes" data-theme="light" aria-labelledby="classesH">
  <?= act('ACT III', 'CLASSES FOR EVERYONE') ?>
  <span class="numeral" aria-hidden="true">III</span>
  <h2 class="h2 classes__h" id="classesH" data-split>A STAGE FOR<br><em>every</em> age.</h2>

  <ul class="wf">
    <?php foreach ($C['classes'] as $i => [$name, $text, $age, $imgKey]): ?>
    <li class="wf__row<?= $i === 0 ? ' is-open' : '' ?>">
      <button type="button" class="wf__btn" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="wf<?= $i ?>">
        <span class="wf__no mono"><?= sprintf('%02d', $i + 1) ?></span>
        <span class="wf__name"><?= e(strtoupper($name)) ?></span>
        <span class="wf__age mono"><?= e($age) ?></span>
        <span class="wf__plus" aria-hidden="true"><i></i><i></i></span>
      </button>
      <div class="wf__panel" id="wf<?= $i ?>" role="region">
        <div class="wf__inner">
          <div class="wf__txt">
            <p class="wf__text"><?= e($text) ?></p>
            <button type="button" class="link link--btn link--ink" data-enquire="<?= e($name) ?> batch"><?= roll('Enquire on WhatsApp') ?> <span class="link__arr">→</span></button>
          </div>
          <div class="wf__img" data-cursor="VIEW"><?= photo($C, $imgKey, ['sizes' => '(min-width:900px) 26vw, 70vw', 'w' => 900]) ?></div>
        </div>
      </div>
    </li>
    <?php endforeach; ?>
  </ul>

  <!-- For Parents -->
  <div class="parents" id="parents">
    <div class="parents__head" data-reveal>
      <p class="mono parents__k"><span class="beat"><?= star_svg('star star--s') ?></span> FOR PARENTS</p>
      <h3 class="parents__t">Dance they’ll love.<br><em>Peace of mind</em> you’ll feel.</h3>
    </div>
    <ul class="parents__l">
      <?php foreach ($C['parents'] as $i => [$t, $d]): ?>
      <li data-reveal>
        <span class="mono parents__n"><?= sprintf('%02d', $i + 1) ?></span>
        <h4><?= e($t) ?></h4>
        <p><?= e($d) ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
