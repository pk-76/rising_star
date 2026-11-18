<!-- ═══════════════ FINALE — BOOK YOUR FREE TRIAL CLASS ═══════════════ -->
<section class="finale dark" id="finale" data-theme="dark" aria-labelledby="finaleH">
  <div class="finale__glow" aria-hidden="true"><i></i><i></i></div>
  <?= act('FINALE', 'BOOK YOUR FREE TRIAL CLASS') ?>
  <h2 class="finale__h" id="finaleH" data-split>YOUR FIRST<br>CLASS IS <em>on us.</em></h2>

  <div class="finale__wrap">
    <p class="finale__lead" data-reveal>Five quick questions, then we’ll open WhatsApp with everything filled in. No pressure, no price talk — just a warm welcome and a proper first class.</p>

    <form class="tf" id="trialForm" novalidate autocomplete="on" data-reveal>
      <div class="tf__top mono">
        <span><b id="tfStep">01</b> / 05</span>
        <span class="tf__bar"><i id="tfBar"></i></span>
        <span id="tfHint">WHO IS IT FOR</span>
      </div>

      <div class="tf__steps" id="tfSteps">
        <fieldset class="tfs is-active" data-step="0">
          <legend class="tfs__q">Who is the class for?</legend>
          <div class="chips chips--2">
            <?php foreach ($C['for'] as $f): ?>
            <label class="chip"><input type="radio" name="for" value="<?= e($f) ?>"><span><?= e($f) ?></span></label>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <fieldset class="tfs" data-step="1">
          <label class="tfs__q" for="tfName" id="tfNameQ">What’s your name?</label>
          <input class="tfs__in" id="tfName" name="name" type="text" autocomplete="name" placeholder="Name" maxlength="60" required>
          <div class="tfs__age" id="tfAgeWrap" hidden>
            <label class="mono" for="tfAge">CHILD’S AGE</label>
            <input class="tfs__in tfs__in--sm" id="tfAge" name="age" type="text" inputmode="numeric" placeholder="e.g. 8" maxlength="2">
          </div>
        </fieldset>

        <fieldset class="tfs" data-step="2">
          <label class="tfs__q" for="tfPhone">Your phone number?</label>
          <input class="tfs__in" id="tfPhone" name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="98765 43210" maxlength="20" required>
        </fieldset>

        <fieldset class="tfs" data-step="3">
          <legend class="tfs__q">Which style calls to you?</legend>
          <div class="chips">
            <?php foreach ($C['styles'] as $s): ?>
            <label class="chip"><input type="radio" name="dance" value="<?= e($s[0]) ?>"><span><?= e($s[0]) ?></span></label>
            <?php endforeach; ?>
            <label class="chip"><input type="radio" name="dance" value="Not sure yet"><span>Not sure yet</span></label>
          </div>
        </fieldset>

        <fieldset class="tfs" data-step="4">
          <legend class="tfs__q">Preferred time?</legend>
          <div class="chips chips--4">
            <?php foreach ($C['times'] as [$t, $hint]): ?>
            <label class="chip"><input type="radio" name="time" value="<?= e($t) ?>"><span><?= e($t) ?><small class="mono"><?= e($hint) ?></small></span></label>
            <?php endforeach; ?>
          </div>
        </fieldset>
      </div>

      <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
      <p class="tf__err mono" id="tfErr" role="alert"></p>

      <div class="tf__nav">
        <button type="button" class="link link--btn" id="tfBack" hidden><span class="link__arr">←</span> <?= roll('Back') ?></button>
        <button type="button" class="btn btn--pink" id="tfNext" data-magnetic><span id="tfNextT"><?= roll('Continue') ?></span><span class="btn__arr">→</span></button>
      </div>
    </form>

    <div class="tf__done" id="tfDone" hidden aria-live="polite">
      <?= star_svg('star star--xl beat') ?>
      <p class="mono tf__dk">REQUEST RECEIVED · TAKE A BOW</p>
      <h3 class="tf__dh">SEE YOU ON THE FLOOR, <em id="tfDoneName">star.</em></h3>
      <p class="tf__dp">Opening WhatsApp with your details so we can lock in your first class…</p>
      <a class="link" id="tfWaFallback" href="<?= e(wa_link($C)) ?>" target="_blank" rel="noopener"><?= roll('WhatsApp didn’t open? Tap here') ?> <span class="link__arr">↗</span></a>
    </div>
  </div>
  <canvas class="confetti" id="confetti" aria-hidden="true"></canvas>
</section>
