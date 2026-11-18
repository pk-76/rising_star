<!-- ═══════════════ ACT II — THE STYLES (pinned horizontal stage) ═══════════════ -->
<section class="styles dark2" id="styles" data-theme="dark" aria-labelledby="stylesH">
  <div class="styles__pin" id="stylesPin">
    <div class="styles__track" id="stylesTrack">

      <div class="sp sp--intro">
        <?= act('ACT II', 'THE STYLES') ?>
        <span class="numeral numeral--lg" aria-hidden="true">II</span>
        <h2 class="h2" id="stylesH" data-split>SIX WAYS<br>TO <em>shine.</em></h2>
        <p class="sp__lede">Pick a style. Or try them all. Every class is led by a mentor who’s watching every step.</p>
        <p class="mono sp__hint">SCROLL <span>→</span></p>
      </div>

      <?php foreach ($C['styles'] as $i => [$name, $slug, $desc, $age, $imgKey, $long, $learn]): ?>
      <article class="sp sp--style" data-style="<?= e($name) ?>">
        <div class="sp__media" data-cursor="PLAY" data-hoverplay>
          <div class="sp__in">
            <?= photo($C, $imgKey, ['sizes' => '(min-width:900px) 52vw, 90vw', 'w' => 1400]) ?>
            <?= video($C, $imgKey, ['class' => 'vid']) ?>
          </div>
          <span class="sp__cap mono">CLIP <?= sprintf('%02d', $i + 1) ?> / <?= e(strtoupper($name)) ?></span>
        </div>
        <h3 class="sp__name" aria-label="<?= e($name) ?>"><span aria-hidden="true"><?= e(strtoupper($name)) ?></span></h3>
        <div class="sp__body">
          <p class="sp__n mono"><span class="beat"><?= star_svg('star star--s') ?></span> STYLE <?= sprintf('%02d', $i + 1) ?> / <?= sprintf('%02d', count($C['styles'])) ?></p>
          <p class="sp__d"><?= e($desc) ?></p>
          <p class="sp__age mono"><?= e($age) ?></p>
          <div class="sp__cta">
            <button type="button" class="link link--btn" data-enquire="<?= e($name) ?> classes"><?= roll('Enquire') ?> <span class="link__arr">→</span></button>
            <a class="link link--dim" href="<?= e(base_path() . '/' . $slug) ?>"><?= roll($name . ' classes') ?> <span class="link__arr">↗</span></a>
          </div>
        </div>
      </article>
      <?php endforeach; ?>

      <div class="sp sp--end">
        <p class="mono">NOT SURE WHERE TO START?</p>
        <h3 class="h2">TRY A CLASS.<br>IT’S <em>on us.</em></h3>
        <a class="btn btn--pink" href="#finale" data-nav data-magnetic><?= roll('Book Your Free Trial Class') ?><span class="btn__arr">→</span></a>
      </div>
    </div>

    <div class="styles__ui mono" aria-hidden="true">
      <span><b id="stylesNo">01</b> / <?= sprintf('%02d', count($C['styles'])) ?></span>
      <span class="styles__bar"><i id="stylesBar"></i></span>
      <span>THE STYLES</span>
    </div>
  </div>
</section>
