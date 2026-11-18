/* ═══════════════════════════════════════════════════════════
   RISING STAR — core: boot, smooth scroll, preloader (the curtain), nav, menu,
   cursor, magnetic buttons, curtain transitions, modals, clock, sound.
   Modules in hero.js / scroll.js / widgets.js register via App.mods.
   ═══════════════════════════════════════════════════════════ */
(function () {
  'use strict';

  var RS  = window.RS || {};
  var doc = document.documentElement;
  var $   = function (s, c) { return (c || document).querySelector(s); };
  var $$  = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  var App = window.App = window.App || {};
  App.mods   = App.mods || [];
  App.RS     = RS;
  App.$      = $; App.$$ = $$;
  App.reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  App.fine   = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  App.lenis  = null;
  App.static = true;
  App.clamp  = function (v, a, b) { return Math.min(b, Math.max(a, v)); };

  var G, menuOpen = false;

  /* ───────────────── boot ───────────────── */
  document.addEventListener('DOMContentLoaded', boot);

  function boot() {
    var ok = !!(window.gsap && window.ScrollTrigger) && !App.reduce;
    if (ok) {
      G = window.gsap;
      G.registerPlugin(window.ScrollTrigger);
      if (window.CustomEase) window.CustomEase.create('rs', 'M0,0 C0.76,0 0.24,1 1,1');
      App.ease = window.CustomEase ? 'rs' : 'power4.inOut';
      App.static = false;
      doc.classList.remove('is-static');
    } else {
      doc.classList.add('is-static');
      App.static = true;
    }
    App.G = G;

    clock();
    headerTheme();
    if (!App.static) smoothScroll();
    else staticScroll();
    menu();
    modals();
    navLinks();
    toTop();

    if (!App.static) {
      cursor();
      magnetic();
    }

    App.mods.forEach(function (m) { try { m(App); } catch (e) { console.error(e); } });

    if (App.static) return;

    document.documentElement.classList.add('is-loading');
    if (App.lenis) App.lenis.stop();
    preloader(function () {
      doc.classList.remove('is-loading');
      if (App.lenis) App.lenis.start();
      if (App.heroIntro) App.heroIntro();
      window.ScrollTrigger.refresh();
    });

    window.addEventListener('load', function () { window.ScrollTrigger.refresh(); });
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(function () { window.ScrollTrigger.refresh(); });
    // failsafe: never leave the visitor behind the curtain
    setTimeout(function () {
      var p = $('#pre'); if (p) p.remove();
      doc.classList.remove('is-loading');
      if (App.lenis && App.lenis.isStopped) App.lenis.start();
    }, 7000);
  }

  /* ───────────────── preloader — THE CURTAIN ───────────────── */
  function preloader(done) {
    var pre = $('#pre');
    if (!pre || doc.classList.contains('seen')) { if (pre) pre.remove(); done(); return; }
    try { localStorage.setItem('rs_seen', '1'); } catch (e) {}

    var num = $('#preNum'), bg = $('#preBg'), l = $('.pre__c--l'), r = $('.pre__c--r');
    var o = { v: 0 }, started = false;
    var tl = G.timeline({ onComplete: function () { pre.remove(); } });
    tl.to(o, { v: 100, duration: 1.1, ease: 'power2.inOut', onUpdate: function () {
        num.textContent = String(Math.round(o.v)).padStart(3, '0');
      } })
      .to(bg, { opacity: 0, duration: .25, ease: 'power1.out' }, '>+.02')
      .to(l, { xPercent: -103, duration: .85, ease: App.ease }, '>+.02')
      .to(r, { xPercent: 103, duration: .85, ease: App.ease }, '<')
      .add(function () { if (!started) { started = true; done(); } }, '<+.3');
  }

  /* ───────────────── smooth scroll (Lenis) ───────────────── */
  function smoothScroll() {
    if (!window.Lenis) { staticScroll(); return; }
    var lenis = App.lenis = new window.Lenis({ lerp: .09, smoothWheel: true, wheelMultiplier: .95 });
    lenis.on('scroll', window.ScrollTrigger.update);
    G.ticker.add(function (t) { lenis.raf(t * 1000); });
    G.ticker.lagSmoothing(0);
    lenis.on('scroll', function (e) { onScroll(e.scroll, e.direction); });
    onScroll(0, 0);
  }

  var lastY = 0, hd, prog, lightSecs;
  function staticScroll() {
    window.addEventListener('scroll', function () { onScroll(window.scrollY, window.scrollY > lastY ? 1 : -1); }, { passive: true });
  }

  function onScroll(y) {
    var dy = y - lastY;
    if (hd) {
      if (y > 160 && dy > 4 && !menuOpen) hd.classList.add('is-hidden');
      else if (dy < -4 || y < 160) hd.classList.remove('is-hidden');
    }
    if (prog) {
      var max = Math.max(1, document.documentElement.scrollHeight - window.innerHeight);
      prog.style.transform = 'scaleX(' + App.clamp(y / max, 0, 1) + ')';
    }
    if (hd && lightSecs.length) {
      var on = false, i;
      for (i = 0; i < lightSecs.length; i++) {
        var r = lightSecs[i].getBoundingClientRect();
        if (r.top <= 40 && r.bottom >= 40) { on = true; break; }
      }
      hd.classList.toggle('on-light', on);
    }
    lastY = y;
  }

  function headerTheme() {
    hd = $('#hd');
    prog = $('#progress i');
    lightSecs = $$('[data-theme="light"]');
  }

  /* ───────────────── IST clock + open/closed ───────────────── */
  function clock() {
    var fmt = new Intl.DateTimeFormat('en-GB', { timeZone: 'Asia/Kolkata', hour: '2-digit', minute: '2-digit', hour12: false, weekday: 'short' });
    var map = { Sun: 0, Mon: 1, Tue: 2, Wed: 3, Thu: 4, Fri: 5, Sat: 6 };
    function tick() {
      var parts = {};
      fmt.formatToParts(new Date()).forEach(function (p) { parts[p.type] = p.value; });
      var h = parseInt(parts.hour, 10) % 24, m = parseInt(parts.minute, 10), d = map[parts.weekday];
      var time = String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0');
      var row = RS.hours && RS.hours[d];
      var open = !!(row && row[1] !== null && h + m / 60 >= row[1] && h + m / 60 < row[2]);
      ['clock', 'clock2'].forEach(function (id) { var el = document.getElementById(id); if (el) el.textContent = time; });
      var s = $('#liveState'); if (s) { s.classList.toggle('is-open', open); s.querySelector('b').textContent = open ? 'CLASSES OPEN NOW' : 'CLOSED NOW'; }
      var b = $('#liveBadge'); if (b) { b.classList.toggle('is-open', open); b.querySelector('b').textContent = open ? 'CLASSES OPEN NOW' : 'CLOSED NOW'; }
      $$('#hours tr').forEach(function (tr) { tr.classList.toggle('is-today', parseInt(tr.getAttribute('data-day'), 10) === d); });
    }
    tick(); setInterval(tick, 15000);
  }

  /* ───────────────── curtain transition ───────────────── */
  App.curtain = function (mid, after) {
    var c = $('#curtain');
    if (App.static || !c) { mid && mid(); after && after(); return; }
    var l = $('.curtain__l', c), r = $('.curtain__r', c);
    G.set(c, { visibility: 'visible' });
    G.set(l, { xPercent: -101, x: 0 }); G.set(r, { xPercent: 101, x: 0 });
    G.timeline({ onComplete: function () { G.set(c, { visibility: 'hidden' }); after && after(); } })
      .to([l, r], { xPercent: 0, duration: .6, ease: App.ease })
      .add(function () { mid && mid(); })
      .to(l, { xPercent: -101, duration: .7, ease: App.ease }, '+=.08')
      .to(r, { xPercent: 101, duration: .7, ease: App.ease }, '<');
  };

  App.scrollTo = function (target, immediate) {
    if (App.lenis) App.lenis.scrollTo(target, { immediate: !!immediate, offset: 0, duration: 1.4 });
    else if (target === 0 || target === '#top') window.scrollTo(0, 0);
    else if (target && target.scrollIntoView) target.scrollIntoView();
  };

  function navLinks() {
    document.addEventListener('click', function (e) {
      var a = e.target.closest && e.target.closest('a[data-nav]');
      if (!a) return;
      var href = a.getAttribute('href') || '';
      var hash = href.charAt(0) === '#' ? href : (href.indexOf('#') > -1 ? '#' + href.split('#')[1] : '');
      if (!hash) return;
      var target = hash === '#top' ? 0 : document.getElementById(hash.slice(1));
      if (target === null) return; // not on this page → normal navigation
      e.preventDefault();
      var wasMenu = menuOpen;
      var go = function () {
        if (wasMenu) menuClose(true);
        modalCloseAll(true);
        App.scrollTo(target, true);
        history.replaceState(null, '', hash === '#top' ? location.pathname : hash);
      };
      if (App.static) { go(); return; }
      App.curtain(go);
    });
  }

  function toTop() {
    var b = $('#toTop');
    if (b) b.addEventListener('click', function () {
      if (App.lenis) App.lenis.scrollTo(0, { duration: 1.8 }); else window.scrollTo({ top: 0 });
    });
  }

  /* ───────────────── menu overlay ───────────────── */
  var menuEl, menuBtn, prevEl, prevImgs, lastFocus;
  function menu() {
    menuEl = $('#menu'); menuBtn = $('#menuBtn');
    if (!menuEl || !menuBtn) return;
    prevEl = $('#menuPrev'); prevImgs = $$('.menu__pimg', menuEl);
    menuBtn.addEventListener('click', menuOpenFn);
    $('#menuClose').addEventListener('click', function () { menuClose(); });
    document.addEventListener('keydown', function (e) {
      if (!menuOpen) return;
      if (e.key === 'Escape') menuClose();
      if (e.key === 'Tab') trapFocus(e, menuEl);
    });

    if (App.fine && !App.static) {
      var qx = G.quickTo(prevEl, 'x', { duration: .6, ease: 'power3' }), qy = G.quickTo(prevEl, 'y', { duration: .6, ease: 'power3' });
      menuEl.addEventListener('mousemove', function (e) { qx(e.clientX + 36); qy(e.clientY - prevEl.offsetHeight * .5); });
      $$('.menu__nav a', menuEl).forEach(function (a) {
        a.addEventListener('mouseenter', function () {
          var i = +a.getAttribute('data-menu-i');
          prevImgs.forEach(function (p, n) {
            var on = n === i; p.classList.toggle('is-on', on);
            var v = $('video', p); if (v) { if (on) { v.play().catch(function () {}); } else v.pause(); }
          });
          G.to(prevEl, { opacity: 1, duration: .4 });
        });
      });
      $('.menu__nav ul', menuEl).addEventListener('mouseleave', function () { G.to(prevEl, { opacity: 0, duration: .3 }); });
    }
  }

  function menuOpenFn() {
    if (menuOpen) return;
    menuOpen = true; lastFocus = document.activeElement;
    menuBtn.setAttribute('aria-expanded', 'true');
    menuEl.hidden = false;
    if (App.lenis) App.lenis.stop();
    if (App.static) { menuEl.style.clipPath = 'inset(0)'; $('#menuClose').focus(); return; }
    G.fromTo(menuEl, { clipPath: 'inset(0% 0% 100% 0%)' }, { clipPath: 'inset(0% 0% 0% 0%)', duration: .9, ease: App.ease });
    G.fromTo($$('.menu__nav li a', menuEl), { yPercent: 110 }, { yPercent: 0, duration: 1, ease: App.ease, stagger: .06, delay: .25 });
    G.fromTo($$('.menu__top, .menu__foot', menuEl), { opacity: 0 }, { opacity: 1, duration: .6, delay: .6 });
    setTimeout(function () { $('#menuClose').focus(); }, 500);
  }

  function menuClose(instant) {
    if (!menuOpen) return;
    menuOpen = false;
    menuBtn.setAttribute('aria-expanded', 'false');
    var fin = function () { menuEl.hidden = true; if (App.lenis) App.lenis.start(); if (G && prevEl) G.set(prevEl, { opacity: 0 }); if (!instant && lastFocus) lastFocus.focus(); };
    if (App.static || instant) { menuEl.style.clipPath = ''; if (G) G.set(menuEl, { clearProps: 'clipPath' }); fin(); return; }
    G.to(menuEl, { clipPath: 'inset(0% 0% 100% 0%)', duration: .8, ease: App.ease, onComplete: fin });
  }

  function trapFocus(e, root) {
    var f = $$('a[href], button:not([disabled]), input, [tabindex]:not([tabindex="-1"])', root).filter(function (x) { return x.offsetParent !== null; });
    if (!f.length) return;
    var first = f[0], last = f[f.length - 1];
    if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
    else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
  }

  /* ───────────────── modals (enquiry + showreel) ───────────────── */
  var openModalEl = null, modalFocus = null;
  function modalShow(el, focusSel) {
    modalFocus = document.activeElement;
    el.hidden = false; openModalEl = el;
    if (App.lenis) App.lenis.stop();
    if (App.static) { el.style.opacity = 1; } else G.to(el, { opacity: 1, duration: .5 });
    var f = $(focusSel, el); if (f) setTimeout(function () { f.focus(); }, 60);
  }
  function modalHide(el, instant) {
    if (!el || el.hidden) return;
    var fin = function () { el.hidden = true; if (openModalEl === el) openModalEl = null; if (!menuOpen && App.lenis) App.lenis.start(); if (!instant && modalFocus) modalFocus.focus(); el.dispatchEvent(new Event('rs:closed')); };
    if (App.static || instant) { el.style.opacity = 0; fin(); } else G.to(el, { opacity: 0, duration: .4, onComplete: fin });
  }
  function modalCloseAll(instant) { ['#enq', '#reel', '#lb'].forEach(function (s) { var m = $(s); if (m) modalHide(m, instant); }); }
  App.modalShow = modalShow; App.modalHide = modalHide;

  App.openEnquiry = function (o) {
    var m = $('#enq'); if (!m) return;
    $('#enqProg').textContent = (o.title || 'CLASS').toUpperCase();
    var msg = o.msg || ('Hi ' + RS.name + '! ✨ I’d like to enquire about ' + (o.title || 'your classes') + '.');
    $('#enqWa').href = 'https://wa.me/' + RS.wa + '?text=' + encodeURIComponent(msg);
    App.curtain(function () { modalShow(m, '#enqWa'); });
  };

  function modals() {
    var enq = $('#enq'), reel = $('#reel');
    if (enq) {
      $('#enqClose').addEventListener('click', function () { modalHide(enq); });
      enq.addEventListener('click', function (e) { if (e.target === enq) modalHide(enq); });
    }
    document.addEventListener('click', function (e) {
      var b = e.target.closest && e.target.closest('[data-enquire]');
      if (b) { e.preventDefault(); App.openEnquiry({ title: b.getAttribute('data-enquire') }); }
    });
    if (reel) {
      var frame = $('#reelFrame'), vid = $('video', reel);
      document.addEventListener('click', function (e) {
        if (!(e.target.closest && e.target.closest('[data-reel]'))) return;
        e.preventDefault();
        App.curtain(function () {
          modalShow(reel, '#reelClose');
          if (frame && !frame.src) frame.src = frame.getAttribute('data-src');
          if (vid) { vid.currentTime = 0; vid.play().catch(function () {}); }
        });
      });
      $('#reelClose').addEventListener('click', function () { modalHide(reel); });
      reel.addEventListener('rs:closed', function () { if (frame) frame.src = ''; if (vid) vid.pause(); });
    }
    document.addEventListener('keydown', function (e) {
      if (!openModalEl) return;
      if (e.key === 'Escape') modalHide(openModalEl);
      if (e.key === 'Tab') trapFocus(e, openModalEl);
    });
  }

  /* ───────────────── custom cursor (desktop) ───────────────── */
  function cursor() {
    var c = $('#cursor'); if (!c || !App.fine) return;
    var lab = $('.cursor__lab', c);
    var qx = G.quickTo(c, 'x', { duration: .25, ease: 'power3' }), qy = G.quickTo(c, 'y', { duration: .25, ease: 'power3' });
    var seen = false;
    window.addEventListener('mousemove', function (e) {
      if (!seen) { seen = true; G.set(c, { x: e.clientX, y: e.clientY }); }
      qx(e.clientX); qy(e.clientY);
    }, { passive: true });
    document.addEventListener('mouseleave', function () { c.classList.add('is-hidden'); });
    document.addEventListener('mouseenter', function () { c.classList.remove('is-hidden'); });
    window.addEventListener('mousedown', function () { c.classList.add('is-down'); });
    window.addEventListener('mouseup', function () { c.classList.remove('is-down'); });

    document.addEventListener('mouseover', function (e) {
      var t = e.target; if (!t.closest) return;
      var l = t.closest('[data-cursor]');
      c.classList.remove('is-label', 'is-link', 'is-diff');
      if (l) { lab.textContent = l.getAttribute('data-cursor'); c.classList.add('is-label'); }
      else if (t.closest('a, button, .chip, .fchip, .slot, summary, label')) c.classList.add('is-link');
      else if (t.closest('img, video, .fx')) c.classList.add('is-diff');
    });
  }

  /* ───────────────── magnetic buttons ───────────────── */
  function magnetic() {
    if (!App.fine) return;
    $$('[data-magnetic]').forEach(function (el) {
      var qx = G.quickTo(el, 'x', { duration: .6, ease: 'elastic.out(1,.5)' }), qy = G.quickTo(el, 'y', { duration: .6, ease: 'elastic.out(1,.5)' });
      el.addEventListener('mousemove', function (e) {
        var r = el.getBoundingClientRect();
        qx((e.clientX - (r.left + r.width / 2)) * .32); qy((e.clientY - (r.top + r.height / 2)) * .4);
      });
      el.addEventListener('mouseleave', function () { qx(0); qy(0); });
    });
  }

  /* ───────────────── ambient music toggle ───────────────── */
  (function sound() {
    document.addEventListener('DOMContentLoaded', function () {
      var btn = $('#sound'), txt = $('#soundT'); if (!btn) return;
      var on = false, ctx, master, timer, step = 0, next = 0, el;
      var BPM = 100, S = 60 / BPM / 4;
      var bass = [55, 55, 87.31, 87.31, 65.41, 65.41, 98, 98]; // A1 F2 C2 G2
      var chords = [[220, 261.63, 329.63], [174.61, 220, 261.63], [261.63, 329.63, 392], [196, 246.94, 293.66]];

      function noise(t, dur, type, freq, gain) {
        var n = Math.floor(ctx.sampleRate * dur), b = ctx.createBuffer(1, n, ctx.sampleRate), d = b.getChannelData(0);
        for (var i = 0; i < n; i++) d[i] = Math.random() * 2 - 1;
        var s = ctx.createBufferSource(); s.buffer = b;
        var f = ctx.createBiquadFilter(); f.type = type; f.frequency.value = freq;
        var g = ctx.createGain(); g.gain.setValueAtTime(gain, t); g.gain.exponentialRampToValueAtTime(.001, t + dur);
        s.connect(f); f.connect(g); g.connect(master); s.start(t);
      }
      function kick(t) {
        var o = ctx.createOscillator(), g = ctx.createGain();
        o.frequency.setValueAtTime(140, t); o.frequency.exponentialRampToValueAtTime(42, t + .14);
        g.gain.setValueAtTime(.9, t); g.gain.exponentialRampToValueAtTime(.001, t + .28);
        o.connect(g); g.connect(master); o.start(t); o.stop(t + .3);
      }
      function pluck(t, f, dur) {
        var o = ctx.createOscillator(), fl = ctx.createBiquadFilter(), g = ctx.createGain();
        o.type = 'sawtooth'; o.frequency.value = f; fl.type = 'lowpass'; fl.frequency.setValueAtTime(900, t); fl.frequency.exponentialRampToValueAtTime(180, t + dur);
        g.gain.setValueAtTime(.32, t); g.gain.exponentialRampToValueAtTime(.001, t + dur);
        o.connect(fl); fl.connect(g); g.connect(master); o.start(t); o.stop(t + dur + .02);
      }
      function pad(t, notes, dur) {
        notes.forEach(function (f) {
          var o = ctx.createOscillator(), g = ctx.createGain(); o.type = 'triangle'; o.frequency.value = f;
          g.gain.setValueAtTime(0, t); g.gain.linearRampToValueAtTime(.05, t + .3); g.gain.linearRampToValueAtTime(0, t + dur);
          o.connect(g); g.connect(master); o.start(t); o.stop(t + dur + .05);
        });
      }
      function schedule() {
        while (next < ctx.currentTime + .25) {
          var s = step % 16, bar = Math.floor(step / 16) % 4;
          if (s % 4 === 0) kick(next);
          if (s % 4 === 2) noise(next, .05, 'highpass', 7000, .12);
          if (s === 4 || s === 12) noise(next, .16, 'bandpass', 1800, .22);
          if ([0, 3, 6, 8, 11, 14].indexOf(s) > -1) pluck(next, bass[bar * 2 + (s > 7 ? 1 : 0)] * 2, S * 2.2);
          if (s === 0) pad(next, chords[bar], S * 16);
          next += S; step++;
        }
      }
      function start() {
        if (RS.audio) {
          el = el || Object.assign(new Audio(RS.audio), { loop: true, volume: 0 });
          el.play().then(function () { fade(el, .5); }).catch(function () {}); return;
        }
        ctx = ctx || new (window.AudioContext || window.webkitAudioContext)();
        if (ctx.state === 'suspended') ctx.resume();
        if (!master) { master = ctx.createGain(); master.gain.value = 0; master.connect(ctx.destination); }
        master.gain.cancelScheduledValues(ctx.currentTime); master.gain.linearRampToValueAtTime(.16, ctx.currentTime + 1);
        next = ctx.currentTime + .05; step = 0;
        timer = setInterval(schedule, 60);
      }
      function stop() {
        if (el) { fade(el, 0, function () { el.pause(); }); return; }
        if (!ctx) return;
        master.gain.cancelScheduledValues(ctx.currentTime); master.gain.linearRampToValueAtTime(0, ctx.currentTime + .5);
        clearInterval(timer);
      }
      function fade(a, to, cb) {
        var i = setInterval(function () {
          a.volume = Math.max(0, Math.min(1, a.volume + (to > a.volume ? .05 : -.05)));
          if (Math.abs(a.volume - to) < .06) { a.volume = to; clearInterval(i); cb && cb(); }
        }, 40);
      }
      btn.addEventListener('click', function () {
        on = !on; btn.setAttribute('aria-pressed', on); txt.textContent = on ? 'SOUND ON' : 'SOUND OFF';
        on ? start() : stop();
      });
    });
  })();

})();
