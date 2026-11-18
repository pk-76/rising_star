/* ═══════════════════════════════════════════════════════════
   RISING STAR — scroll choreography (GSAP + ScrollTrigger)
   word reveals · curtain clip wipes · manifesto stage-lights · PERFORM fill ·
   counters · velocity marquee · pinned horizontal stage · sticky bowing reviews · footer
   ═══════════════════════════════════════════════════════════ */
(function () {
  'use strict';
  var App = window.App = window.App || { mods: [] };
  (App.mods = App.mods || []).push(init);

  function init(App) {
    if (App.static) return;
    var G = App.G, ST = window.ScrollTrigger, $ = App.$, $$ = App.$$, E = App.ease;
    var wide = function () { return window.innerWidth >= 900; };

    /* ── split text into masked words ── */
    function splitWords(el) {
      (function walk(node) {
        Array.prototype.slice.call(node.childNodes).forEach(function (n) {
          if (n.nodeType === 3) {
            var frag = document.createDocumentFragment();
            n.textContent.split(/(\s+)/).forEach(function (part) {
              if (!part) return;
              if (/^\s+$/.test(part)) { frag.appendChild(document.createTextNode(part)); return; }
              var w = document.createElement('span'); w.className = 'w';
              var i = document.createElement('span'); i.className = 'wi'; i.textContent = part;
              w.appendChild(i); frag.appendChild(w);
            });
            node.replaceChild(frag, n);
          } else if (n.nodeType === 1 && n.tagName !== 'BR') walk(n);
        });
      })(el);
      return $$('.wi', el);
    }

    $$('[data-split]').forEach(function (el) {
      var words = splitWords(el);
      G.from(words, { yPercent: 118, duration: 1.1, ease: E, stagger: .09,
        scrollTrigger: { trigger: el, start: 'top 86%', once: true } });
    });

    /* ── generic reveals ── */
    $$('[data-reveal]').forEach(function (el) {
      G.from(el, { y: 44, opacity: 0, duration: 1.1, ease: 'power3.out',
        scrollTrigger: { trigger: el, start: 'top 90%', once: true } });
    });

    /* ── curtain-shaped clip wipes (opening curtains) ── */
    $$('[data-clip]').forEach(function (el) {
      G.fromTo(el, { clipPath: 'inset(0% 50% 0% 50%)' }, { clipPath: 'inset(0% 0% 0% 0%)', duration: 1.4, ease: E,
        scrollTrigger: { trigger: el, start: 'top 88%', once: true } });
    });

    /* ── parallax (images drift inside frames; figures drift at different speeds) ── */
    $$('[data-parallax]').forEach(function (el) {
      G.fromTo(el, { yPercent: -5 }, { yPercent: 5, ease: 'none',
        scrollTrigger: { trigger: el.parentNode, start: 'top bottom', end: 'bottom top', scrub: true } });
    });
    if (wide()) {
      $$('[data-speed]').forEach(function (el) {
        var s = parseFloat(el.getAttribute('data-speed')) || 0;
        G.fromTo(el, { y: -s * .6 }, { y: s * .6, ease: 'none',
          scrollTrigger: { trigger: el, start: 'top bottom', end: 'bottom top', scrub: true } });
      });
    }

    /* ── ACT I manifesto — words light up one by one like stage lights ── */
    var man = $('#manifesto');
    if (man) {
      var words = splitWords(man);
      words.forEach(function (w) { w.parentNode.style.overflow = 'visible'; w.parentNode.style.padding = '0'; w.parentNode.style.margin = '0'; });
      var pale = '#cfc8be', ink = '#0E0C10', pinkD = '#C70A5E', flash = '#FF2E88';
      var tl = G.timeline({ scrollTrigger: { trigger: man, start: 'top 78%', end: 'bottom 45%', scrub: true } });
      words.forEach(function (w, i) {
        var final = w.closest('em') ? pinkD : ink;
        G.set(w, { color: pale });
        tl.to(w, { color: flash, duration: .35, ease: 'none' }, i * .14)
          .to(w, { color: final, duration: .55, ease: 'none' }, i * .14 + .35);
      });
    }

    /* ── giant PERFORM fills with pink ── */
    var dw = $('#dword .f');
    if (dw) G.to(dw, { clipPath: 'inset(0 0% 0 0)', ease: 'none',
      scrollTrigger: { trigger: '#dword', start: 'top 85%', end: 'bottom 35%', scrub: .6 } });

    /* ── counters ── */
    $$('[data-count]').forEach(function (el) {
      var end = parseFloat(el.getAttribute('data-count')), dec = +el.getAttribute('data-dec') || 0, sep = el.hasAttribute('data-sep');
      var o = { v: 0 };
      var fmt = function (n) { var s = n.toFixed(dec); return sep ? Number(s).toLocaleString('en-US', { minimumFractionDigits: dec }) : s; };
      el.textContent = fmt(0);
      ST.create({ trigger: el, start: 'top 90%', once: true, onEnter: function () {
        G.to(o, { v: end, duration: 2.2, ease: 'power3.out', onUpdate: function () { el.textContent = fmt(o.v); } });
      } });
    });

    /* ── rhythm marquee: speed + skew react to scroll velocity ── */
    (function () {
      var wrap = $('#marquee'), track = $('#mqTrack'); if (!wrap || !track) return;
      var set = track.firstElementChild, need = Math.ceil(window.innerWidth * 2.2 / set.offsetWidth);
      for (var i = 0; i < need; i++) track.appendChild(set.cloneNode(true));
      var x = 0, dir = -1, skew = 0, active = true, W = function () { return set.offsetWidth; };
      ST.create({ trigger: wrap, start: 'top bottom', end: 'bottom top', onToggle: function (s) { active = s.isActive; } });
      G.ticker.add(function (t, dt) {
        if (!active) return;
        var v = App.lenis ? App.lenis.velocity : 0;
        var tdir = Math.abs(v) > .15 ? (v > 0 ? -1 : 1) : dir;
        dir += (tdir - dir) * .06;
        var speed = 70 + Math.abs(v) * 70;
        x += dir * speed * dt / 1000;
        var w = W(); x = ((x % w) - w) % w;
        skew += (App.clamp(-v * .7, -14, 14) - skew) * .12;
        G.set(track, { x: x, skewX: skew });
      });
    })();

    /* ── ACT II — pinned horizontal stage ── */
    (function () {
      var sec = $('#styles'), track = $('#stylesTrack'); if (!sec || !track) return;
      var dist = function () { return Math.max(0, track.scrollWidth - window.innerWidth); };
      var panels = $$('.sp--style', track), bar = $('#stylesBar'), no = $('#stylesNo'), last = -1;
      var tween = G.to(track, { x: function () { return -dist(); }, ease: 'none',
        scrollTrigger: { trigger: sec, start: 'top top', end: function () { return '+=' + dist(); }, pin: true, scrub: 1, anticipatePin: 1, invalidateOnRefresh: true,
          onUpdate: function (self) {
            if (bar) bar.style.transform = 'scaleX(' + self.progress + ')';
            if (no) {
              var cx = -G.getProperty(track, 'x') + window.innerWidth * .5, idx = 0;
              panels.forEach(function (p, i) { if (cx >= p.offsetLeft) idx = i; });
              if (idx !== last) { last = idx; no.textContent = String(idx + 1).padStart(2, '0'); }
            }
          } } });
      panels.forEach(function (p) {
        var inner = $('.sp__in', p), name = $('.sp__name', p);
        if (wide()) {
          G.fromTo(inner, { xPercent: 4 }, { xPercent: -4, ease: 'none',
            scrollTrigger: { trigger: p, containerAnimation: tween, start: 'left right', end: 'right left', scrub: true } });
          G.fromTo(name, { xPercent: 14 }, { xPercent: -10, ease: 'none',
            scrollTrigger: { trigger: p, containerAnimation: tween, start: 'left right', end: 'right left', scrub: true } });
        }
        // curtains open on each panel's media as it arrives
        G.fromTo($('.sp__media', p), { clipPath: 'inset(0% 50% 0% 50%)' }, { clipPath: 'inset(0% 0% 0% 0%)', ease: E, duration: 1,
          scrollTrigger: { trigger: p, containerAnimation: tween, start: 'left 85%', toggleActions: 'play none none reverse' } });
      });
    })();

    /* ── ACT VI — reviews pile up and take a bow ── */
    (function () {
      var cards = $$('.rc'); if (cards.length < 2) return;
      var topOf = function (i) { return wide() ? window.innerHeight * .12 + i * 28 : window.innerHeight * .10 + i * 20; };
      cards.forEach(function (c, i) {
        if (i === cards.length - 1) return;
        G.to(c, { scale: .94, rotate: (i % 2 ? 1 : -1) * 2.2, yPercent: -2, ease: 'none',
          scrollTrigger: { trigger: cards[i + 1], start: 'top bottom', end: function () { return 'top ' + topOf(i + 1); }, scrub: true, invalidateOnRefresh: true } });
      });
    })();

    /* ── footer wordmark rises into view ── */
    var fw = $$('#ftWord .l');
    if (fw.length) G.from(fw, { yPercent: 112, duration: 1.4, ease: E, stagger: .06,
      scrollTrigger: { trigger: '#ftWord', start: 'top 92%', once: true } });
  }
})();
