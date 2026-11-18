/* ═══════════════════════════════════════════════════════════
   RISING STAR — hero: spotlight that follows the cursor (auto-sweeps on touch),
   hero video autoplay, headline on a 1-2-3-4 beat.
   ═══════════════════════════════════════════════════════════ */
(function () {
  'use strict';
  var App = window.App = window.App || { mods: [] };
  (App.mods = App.mods || []).push(init);

  function init(App) {
    var $ = App.$, hero = $('#top'), G = App.G;
    if (!hero) return;

    // autoplay hero video when available (muted/inline)
    var v = $('.hero__vid', hero);
    if (v) {
      v.addEventListener('playing', function () { v.classList.add('is-playing'); });
      var p = v.play(); if (p && p.catch) p.catch(function () {});
    }

    if (App.static) return;

    /* ── spotlight ── */
    var tx = 64, ty = 42, x = 64, y = 42, visible = true, t0 = performance.now();
    var setVars = function () { hero.style.setProperty('--x', x.toFixed(2) + '%'); hero.style.setProperty('--y', y.toFixed(2) + '%'); };
    new IntersectionObserver(function (e) { visible = e[0].isIntersecting; }, { threshold: 0 }).observe(hero);

    if (App.fine) {
      hero.addEventListener('mousemove', function (e) {
        var r = hero.getBoundingClientRect();
        tx = (e.clientX - r.left) / r.width * 100; ty = (e.clientY - r.top) / r.height * 100;
      });
      hero.addEventListener('mouseleave', function () { tx = 64; ty = 42; });
    }
    G.ticker.add(function () {
      if (!visible) return;
      if (!App.fine) {          // mobile: the light slowly sweeps the stage on its own
        var t = (performance.now() - t0) / 1000;
        tx = 52 + 30 * Math.sin(t * .42); ty = 42 + 16 * Math.sin(t * .31 + 1.2);
      }
      x += (tx - x) * .07; y += (ty - y) * .07;
      setVars();
    });

    // parallax: media drifts slower than the page
    G.to('#heroMedia', { yPercent: 14, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true } });
    G.to('.hero__inner', { yPercent: -8, opacity: .0, ease: 'none', scrollTrigger: { trigger: hero, start: '55% top', end: 'bottom top', scrub: true } });

    /* ── intro (called when the curtains open) ── */
    var lines = App.$$('.ln__in', hero), fades = App.$$('[data-hero="fade"]', hero);
    var played = false;
    App.heroIntro = function () {
      if (played) return; played = true;
      var beat = .46;            // ≈ 130 BPM — one headline line per beat: 1-2-3-4
      var tl = G.timeline();
      tl.fromTo('.hero__img, .hero__vid', { scale: 1.16 }, { scale: 1.04, duration: 2.4, ease: 'power3.out' }, 0)
        .fromTo(hero, { '--r': '6vmax' }, { '--r': '30vmax', duration: 2.2, ease: 'power2.out' }, 0);
      lines.forEach(function (l, i) {
        tl.fromTo(l, { yPercent: 112, y: 0 }, { yPercent: 0, y: 0, duration: .95, ease: App.ease }, .15 + i * beat);
      });
      tl.fromTo(fades, { opacity: 0, y: 24 }, { opacity: 1, y: 0, duration: 1, ease: 'power3.out', stagger: .12 }, .15 + 3 * beat + .2);
    };
    // if no preloader runs (already triggered elsewhere) nothing else needed
  }
})();
