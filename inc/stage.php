<?php
$lbItems = [];
foreach ($C['gallery'] as [$type, $key, $cap]) {
    $mp4 = is_file(RS_ROOT . "/assets/video/$key.mp4") ? asset("video/$key.mp4") : '';
    $lbItems[] = ['type' => ($type === 'video' && $mp4) ? 'video' : 'image', 'src' => $mp4 ?: photo_url($C, $key, 2000), 'poster' => photo_url($C, $key, 1600), 'cap' => $cap, 'alt' => $C['images'][$key][1] ?? ''];
}
?>
<!-- ═══════════════ ACT IV — THE STAGE ═══════════════ -->
<section class="stage dark" id="stage" data-theme="dark" aria-labelledby="stageH">
  <?= act('ACT IV', 'THE STAGE') ?>
  <span class="numeral" aria-hidden="true">IV</span>
  <div class="stage__head">
    <h2 class="h2" id="stageH" data-split>WHERE THE<br><em>magic</em> HAPPENS.</h2>
    <p class="stage__copy" data-reveal>Rehearsals, showcases, shy first bows and standing ovations. Hover to play. Tap to step into the spotlight.</p>
  </div>

  <div class="gallery" id="gallery">
    <?php foreach ($C['gallery'] as $i => [$type, $key, $cap, $size]):
        $hasVid = $type === 'video' && is_file(RS_ROOT . "/assets/video/$key.mp4"); ?>
    <figure class="gi <?= e($size) ?>">
      <button type="button" class="gi__btn" data-lb="<?= $i ?>" data-cursor="<?= $type === 'video' ? 'PLAY' : 'VIEW' ?>" data-hoverplay aria-label="Open: <?= e($cap) ?>">
        <span class="gi__ph" data-clip>
          <span class="gi__in">
            <?= photo($C, $key, ['sizes' => '(min-width:900px) 30vw, 90vw', 'w' => 1000]) ?>
            <?= $type === 'video' ? video($C, $key, ['class' => 'vid']) : '' ?>
          </span>
          <?php if ($type === 'video'): ?><span class="gi__play" aria-hidden="true">▶</span><?php endif; ?>
        </span>
      </button>
      <figcaption class="mono"><?= e($cap) ?></figcaption>
    </figure>
    <?php endforeach; ?>
  </div>

  <!-- Featured: Annual showcase -->
  <div class="showcase" data-reveal>
    <div class="showcase__glow" aria-hidden="true"></div>
    <p class="mono showcase__k"><span class="beat"><?= star_svg('star star--s') ?></span> FEATURED <span class="showcase__ph">[PLACEHOLDER]</span></p>
    <h3 class="showcase__t"><?= e($C['showcase'][0]) ?> <em>on stage.</em></h3>
    <p class="mono showcase__d"><?= e($C['showcase'][1]) ?></p>
    <a class="btn btn--ghost" href="<?= e(wa_link($C, 'Hi Rising Star Dance Academy! I’d like to know about the Annual Showcase.')) ?>" target="_blank" rel="noopener" data-magnetic><?= roll('Ask about the showcase') ?><span class="btn__arr">↗</span></a>
  </div>
</section>

<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Performance gallery" hidden>
  <button type="button" class="lb__x mono" id="lbClose" aria-label="Close gallery">CLOSE ✕</button>
  <button type="button" class="lb__nav lb__nav--p" id="lbPrev" aria-label="Previous">←</button>
  <button type="button" class="lb__nav lb__nav--n" id="lbNext" aria-label="Next">→</button>
  <div class="lb__stage" id="lbStage"></div>
  <div class="lb__bar mono"><span id="lbCap"></span><span><b id="lbNo">01</b> / <?= sprintf('%02d', count($lbItems)) ?></span></div>
</div>
<script>window.RS_GALLERY = <?= json_encode($lbItems, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;</script>
