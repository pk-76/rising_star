<!-- ═══════════════ OVERTURE — THE CURTAIN RISES ═══════════════ -->
<section class="hero dark" id="top" data-theme="dark" aria-labelledby="heroH">
  <div class="hero__media" id="heroMedia">
    <?= photo($C, 'hero', ['eager' => true, 'class' => 'hero__img', 'sizes' => '100vw', 'w' => 1800]) ?>
    <?= video($C, 'hero', ['class' => 'hero__vid', 'autoplay' => true, 'eager' => true]) ?>
  </div>
  <div class="hero__dark" id="heroDark" aria-hidden="true"></div>
  <div class="hero__glow" aria-hidden="true"><i class="g1"></i><i class="g2"></i></div>

  <div class="hero__inner">
    <p class="hero__eye mono" data-hero="fade"><span class="beat"><?= star_svg('star star--s') ?></span> OVERTURE <i></i> THE CURTAIN RISES</p>

    <div class="hero__title">
      <h1 id="heroH" class="hero__h1" aria-label="Find your rhythm. Own the dance floor.">
        <span class="ln" aria-hidden="true"><span class="ln__in">FIND YOUR</span></span>
        <span class="ln ln--serif" aria-hidden="true"><span class="ln__in"><em>rhythm.</em></span></span>
        <span class="ln" aria-hidden="true"><span class="ln__in">OWN THE</span></span>
        <span class="ln" aria-hidden="true"><span class="ln__in">DANCE FLOOR.</span></span>
      </h1>

      <div class="hero__side" data-hero="fade">
        <p class="hero__sub">Learn, perform and grow with <?= e($B['name']) ?>. Discover your passion for dance through professional guidance, energetic classes and a supportive learning environment.</p>
        <div class="hero__cta">
          <a class="btn btn--pink" href="#finale" data-nav data-magnetic><?= roll('Book Your Free Trial Class') ?><span class="btn__arr">→</span></a>
          <button type="button" class="link link--btn" data-reel data-cursor="PLAY"><span class="link__play">▶</span> <?= roll('Watch Our Dancers') ?></button>
        </div>
      </div>
    </div>
  </div>

  <div class="hero__bar mono" data-hero="fade">
    <span class="hb"><?= e($B['rating']) ?>★</span>
    <span class="hb"><?= e($B['reviews']) ?>+ REVIEWS</span>
    <span class="hb"><?= (int)$B['styles_count'] ?>+ DANCE STYLES</span>
    <span class="hb">KIDS TO ADULTS</span>
    <span class="hb">SIX MILE, GUWAHATI</span>
    <a class="hero__scroll" href="#academy" data-nav><span>SCROLL FOR ACT I</span><i></i></a>
  </div>
</section>
