<!-- ═══════════════ ACT VI — APPLAUSE ═══════════════ -->
<section class="applause dark" id="applause" data-theme="dark" aria-labelledby="applauseH">
  <?= act('ACT VI', 'APPLAUSE') ?>
  <span class="numeral" aria-hidden="true">VI</span>
  <h2 class="h2 applause__h" id="applauseH" data-split>THE CROWD<br>GOES <em>wild.</em></h2>

  <div class="rv" id="reviews">
    <aside class="rv__side">
      <div class="rv__sticky">
        <p class="mono rv__k">GOOGLE REVIEWS</p>
        <p class="rv__big" aria-label="<?= e($B['rating']) ?> out of 5"><?= e(number_format($B['rating'], 1)) ?></p>
        <p class="stars beat-slow" style="--r:<?= e($B['rating']) ?>" aria-hidden="true">★★★★★</p>
        <p class="mono rv__n"><?= e($B['reviews']) ?>+ STUDENTS &amp; PARENTS HAVE RATED US</p>
        <a class="btn btn--ghost" href="<?= e($C['google_reviews_url']) ?>" target="_blank" rel="noopener" data-magnetic><?= roll('Read all reviews on Google') ?><span class="btn__arr">↗</span></a>
        <?php if (!empty($C['reviews_placeholder'])): ?><p class="mono rv__ph">REVIEW TEXT ILLUSTRATIVE — REPLACE WITH REAL QUOTES</p><?php endif; ?>
      </div>
    </aside>

    <div class="rv__stack" id="rvStack">
      <?php foreach ($C['reviews'] as $i => [$theme, $who, $quote]): ?>
      <article class="rc" style="--i:<?= $i ?>">
        <p class="mono rc__k"><span><?= sprintf('%02d', $i + 1) ?></span> <?= e($theme) ?> <em class="rc__who"><?= e($who) ?></em></p>
        <blockquote class="rc__q">“<?= e($quote) ?>”</blockquote>
        <footer class="rc__f mono"><span class="stars" style="--r:5" aria-label="5 out of 5">★★★★★</span><span>[REVIEWER NAME] · GOOGLE</span></footer>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
