<?php
/* preloader (curtain) • page curtain • grain • progress • cursor • header • menu • enquiry modal • showreel modal */
$NAV_HOME = $NAV_HOME ?? '';
?>
<div class="pre" id="pre" aria-hidden="true">
  <div class="pre__c pre__c--l"></div>
  <div class="pre__c pre__c--r"></div>
  <div class="pre__bg" id="preBg">
    <p class="pre__k mono">ACT 0 — THE OVERTURE</p>
    <div class="pre__mid">
      <span class="pre__star" id="preStar"><?= star_svg('star') ?></span>
      <span class="pre__num" id="preNum">000</span>
    </div>
    <p class="pre__k mono">THE SHOW IS ABOUT TO BEGIN</p>
  </div>
</div>

<div class="curtain" id="curtain" aria-hidden="true"><span class="curtain__l"></span><span class="curtain__r"></span></div>
<div class="grain" aria-hidden="true"></div>
<div class="progress" id="progress" aria-hidden="true"><i></i></div>
<div class="cursor" id="cursor" aria-hidden="true"><span class="cursor__lab mono"></span></div>

<header class="hd" id="hd">
  <a class="hd__logo" href="<?= e($NAV_HOME ?: '#top') ?>" <?= $NAV_HOME === '' ? 'data-nav' : '' ?> aria-label="Rising Star Dance Academy — home">
    <span class="beat"><?= star_svg('star') ?></span>RISING STAR
  </a>
  <div class="hd__live mono" aria-live="off">
    GUWAHATI · <time id="clock"><?= e($state['time']) ?></time> IST ·
    <span class="live<?= $state['open'] ? ' is-open' : '' ?>" id="liveState"><i></i><b><?= $state['open'] ? 'CLASSES OPEN NOW' : 'CLOSED NOW' ?></b></span>
  </div>
  <div class="hd__right">
    <button class="hd__menu mono" id="menuBtn" type="button" aria-expanded="false" aria-controls="menu"><?= roll('MENU') ?></button>
    <a class="pill" href="<?= e($NAV_HOME) ?>#finale" <?= $NAV_HOME === '' ? 'data-nav' : '' ?> data-magnetic><?= roll('FREE TRIAL') ?></a>
  </div>
</header>

<div class="menu" id="menu" role="dialog" aria-modal="true" aria-label="Site menu" hidden>
  <div class="menu__top mono">
    <span>PROGRAMME — INDEX</span>
    <button type="button" id="menuClose" class="menu__close"><?= roll('CLOSE ✕') ?></button>
  </div>
  <nav class="menu__nav" aria-label="Main">
    <ul>
      <?php foreach ($C['menu'] as $i => [$label, $href, $imgKey]): ?>
      <li>
        <a href="<?= e($NAV_HOME . $href) ?>" <?= $NAV_HOME === '' ? 'data-nav' : '' ?> data-menu-i="<?= $i ?>">
          <span class="menu__no mono"><?= sprintf('%02d', $i + 1) ?></span>
          <span class="menu__lab"><?= roll($label) ?></span>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <div class="menu__prev" id="menuPrev" aria-hidden="true">
    <?php foreach ($C['menu'] as $i => [$label, $href, $imgKey]): ?>
      <div class="menu__pimg" data-i="<?= $i ?>">
        <?= photo($C, $imgKey, ['sizes' => '420px', 'w' => 600]) ?>
        <?= video($C, $imgKey, ['class' => 'vid']) ?>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="menu__foot mono">
    <span><?= e($B['street']) ?>, <?= e($B['locality']) ?></span>
    <a href="tel:<?= e($B['tel']) ?>"><?= e($B['phone']) ?></a>
    <a href="mailto:<?= e($B['email']) ?>"><?= e($B['email']) ?></a>
  </div>
</div>

<div class="modal" id="enq" role="dialog" aria-modal="true" aria-labelledby="enqT" hidden>
  <div class="modal__box">
    <button type="button" class="modal__close mono" id="enqClose" aria-label="Close enquiry"><?= roll('CLOSE ✕') ?></button>
    <p class="mono modal__k">ENQUIRY · <span id="enqProg">CLASS</span></p>
    <h3 class="modal__t" id="enqT">Let’s find your <em>rhythm.</em></h3>
    <p class="modal__p">Fees depend on the batch and age group, so we share them personally. Message us on WhatsApp and we’ll reply with the right batch, timings and fees.</p>
    <div class="modal__cta">
      <a class="btn btn--pink" id="enqWa" href="<?= e(wa_link($C)) ?>" target="_blank" rel="noopener" data-magnetic><?= roll('Enquire on WhatsApp') ?><span class="btn__arr">↗</span></a>
      <a class="btn btn--ghost" href="<?= e($NAV_HOME) ?>#finale" <?= $NAV_HOME === '' ? 'data-nav' : '' ?> data-close-modal><?= roll('Book free trial instead') ?></a>
    </div>
    <p class="mono modal__f">OR CALL <a href="tel:<?= e($B['tel']) ?>"><?= e($B['phone']) ?></a></p>
  </div>
</div>

<div class="modal modal--reel" id="reel" role="dialog" aria-modal="true" aria-label="Showreel" hidden>
  <button type="button" class="modal__close mono reel__close" id="reelClose" aria-label="Close showreel"><?= roll('CLOSE ✕') ?></button>
  <div class="reel__stage" id="reelStage">
    <?php
      $embed = $C['showreel_embed'];
      $rv    = video($C, 'showreel', ['class' => 'vid reel__vid']);
    ?>
    <?php if ($embed): ?>
      <iframe id="reelFrame" title="Rising Star showreel" data-src="<?= e($embed) ?>" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen loading="lazy"></iframe>
    <?php elseif ($rv): ?>
      <?= str_replace('muted loop', 'controls muted', $rv) ?>
    <?php else: ?>
      <div class="reel__ph">
        <?= photo($C, 'showreel', ['sizes' => '100vw', 'w' => 1600]) ?>
        <p class="mono">SHOWREEL PLACEHOLDER — ADD assets/video/showreel.mp4 OR A YOUTUBE LINK IN data/config.php</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<main id="main">
