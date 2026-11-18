/* ═══════════════════════════════════════════════════════════
   RISING STAR — widgets: accordions · video hover-play · timetable filters ·
   lightbox · free-trial form (+ star-burst confetti, WhatsApp) · dark map
   ═══════════════════════════════════════════════════════════ */
(function () {
  'use strict';
  var App = window.App = window.App || { mods: [] };
  (App.mods = App.mods || []).push(init);

  function init(App) {
    var $ = App.$, $$ = App.$$, G = App.G, RS = App.RS;
    accordions(); videos(); spotlightCards(); timetable(); lightbox(); trialForm(); map();

    /* ───────── accordion (Classes for everyone) ───────── */
    function accordions() {
      var rows = $$('.wf__row'); if (!rows.length) return;
      function open(row) {
        rows.forEach(function (r) {
          var on = r === row;
          r.classList.toggle('is-open', on);
          $('.wf__btn', r).setAttribute('aria-expanded', on);
        });
      }
      rows.forEach(function (row) {
        var btn = $('.wf__btn', row);
        btn.addEventListener('click', function () {
          if (row.classList.contains('is-open')) { row.classList.remove('is-open'); btn.setAttribute('aria-expanded', 'false'); }
          else open(row);
        });
        if (App.fine) row.addEventListener('mouseenter', function () { open(row); });
      });
    }

    /* ───────── looping videos: hover to play (desktop) · in-view autoplay (stage panels) ───────── */
    function videos() {
      var all = $$('video.vid'); if (!all.length) return;
      all.forEach(function (v) {
        v.muted = true; v.loop = true; v.playsInline = true;
        v.addEventListener('playing', function () { v.classList.add('is-playing'); });
        v.addEventListener('pause', function () { if (!v.closest('.reel__stage')) v.classList.remove('is-playing'); });
      });
      var play = function (v) { var p = v.play(); if (p && p.catch) p.catch(function () {}); };
      $$('[data-hoverplay]').forEach(function (host) {
        var v = $('video.vid', host); if (!v) return;
        if (App.fine) {
          host.addEventListener('mouseenter', function () { play(v); });
          host.addEventListener('mouseleave', function () { v.pause(); });
        }
      });
      // style panels play when on screen (any device)
      if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
          entries.forEach(function (en) { var v = $('video.vid', en.target); if (!v) return; en.isIntersecting ? play(v) : v.pause(); });
        }, { threshold: .45 });
        $$('.sp__media').forEach(function (m) { io.observe(m); });
      }
    }

    /* ───────── mentor spotlight glow follows the pointer ───────── */
    function spotlightCards() {
      $$('[data-spot]').forEach(function (el) {
        el.addEventListener('mousemove', function (e) {
          var r = el.getBoundingClientRect();
          el.style.setProperty('--mx', ((e.clientX - r.left) / r.width * 100) + '%');
          el.style.setProperty('--my', ((e.clientY - r.top) / r.height * 100) + '%');
        });
      });
    }

    /* ───────── timetable: filters + click-to-book ───────── */
    function timetable() {
      var grid = $('#ttGrid'); if (!grid) return;
      var st = 'all', ag = 'all', slots = $$('.slot', grid), empty = $('#ttEmpty');
      function apply() {
        var shown = 0;
        slots.forEach(function (s) {
          var ok = (st === 'all' || s.getAttribute('data-style') === st) && (ag === 'all' || s.getAttribute('data-age') === ag);
          s.classList.toggle('is-dim', !ok);
          s.tabIndex = ok ? 0 : -1;
          if (ok) shown++;
        });
        if (empty) empty.hidden = shown > 0;
      }
      function wire(attr, setter) {
        $$('[' + attr + ']').forEach(function (b) {
          b.addEventListener('click', function () {
            $$('[' + attr + ']').forEach(function (x) { var on = x === b; x.classList.toggle('is-on', on); x.setAttribute('aria-pressed', on); });
            setter(b.getAttribute(attr)); apply();
          });
        });
      }
      wire('data-fstyle', function (v) { st = v; });
      wire('data-fage', function (v) { ag = v; });
      slots.forEach(function (s) {
        s.addEventListener('click', function () {
          var batch = s.getAttribute('data-batch');
          App.openEnquiry({ title: 'Free trial · ' + s.getAttribute('data-style'),
            msg: 'Hi ' + RS.name + '! ✨ I’d like to book a FREE TRIAL CLASS for this batch: ' + batch + '.' });
        });
      });
    }

    /* ───────── gallery lightbox ───────── */
    function lightbox() {
      var lb = $('#lb'), items = window.RS_GALLERY || []; if (!lb || !items.length) return;
      var stage = $('#lbStage'), cap = $('#lbCap'), no = $('#lbNo'), cur = 0, sx = null;
      function render(i, dir) {
        cur = (i + items.length) % items.length;
        var it = items[cur], el;
        if (it.type === 'video') {
          el = document.createElement('video'); el.src = it.src; el.poster = it.poster; el.controls = true; el.autoplay = true; el.loop = true; el.playsInline = true; el.muted = false;
          el.setAttribute('aria-label', it.alt);
        } else { el = document.createElement('img'); el.src = it.src; el.alt = it.alt; }
        stage.innerHTML = ''; stage.appendChild(el);
        if (it.type === 'video') { var p = el.play(); if (p && p.catch) p.catch(function () { el.muted = true; el.play().catch(function () {}); }); }
        cap.textContent = it.cap; no.textContent = String(cur + 1).padStart(2, '0');
        if (G && !App.static && dir) G.fromTo(el, { x: dir * 60, opacity: 0 }, { x: 0, opacity: 1, duration: .7, ease: App.ease });
        else if (G && !App.static) G.fromTo(el, { clipPath: 'inset(0% 50% 0% 50%)' }, { clipPath: 'inset(0% 0% 0% 0%)', duration: 1, ease: App.ease });
      }
      function openLb(i) {
        App.curtain(function () { render(i, 0); App.modalShow(lb, '#lbClose'); });
      }
      function closeLb() { var v = $('video', stage); if (v) v.pause(); App.modalHide(lb); }
      $$('[data-lb]').forEach(function (b) { b.addEventListener('click', function () { openLb(+b.getAttribute('data-lb')); }); });
      $('#lbClose').addEventListener('click', closeLb);
      $('#lbPrev').addEventListener('click', function () { render(cur - 1, -1); });
      $('#lbNext').addEventListener('click', function () { render(cur + 1, 1); });
      document.addEventListener('keydown', function (e) {
        if (lb.hidden) return;
        if (e.key === 'ArrowLeft') render(cur - 1, -1);
        if (e.key === 'ArrowRight') render(cur + 1, 1);
      });
      lb.addEventListener('rs:closed', function () { stage.innerHTML = ''; });
      stage.addEventListener('pointerdown', function (e) { sx = e.clientX; });
      stage.addEventListener('pointerup', function (e) {
        if (sx === null) return; var dx = e.clientX - sx; sx = null;
        if (Math.abs(dx) > 50) render(cur + (dx < 0 ? 1 : -1), dx < 0 ? 1 : -1);
      });
    }

    /* ───────── FINALE: multi-step trial form ───────── */
    function trialForm() {
      var form = $('#trialForm'); if (!form) return;
      var steps = $$('.tfs', form), n = steps.length, i = 0;
      var hints = ['WHO IS IT FOR', 'YOUR NAME', 'YOUR PHONE', 'DANCE STYLE', 'PREFERRED TIME'];
      var err = $('#tfErr'), back = $('#tfBack'), next = $('#tfNext'), nextT = $('#tfNextT'), bar = $('#tfBar'), stepEl = $('#tfStep'), hint = $('#tfHint');
      var ageWrap = $('#tfAgeWrap'), nameQ = $('#tfNameQ');
      var val = function (name) { var r = form.querySelector('[name="' + name + '"]:checked'); return r ? r.value : ''; };
      var isChild = function () { return val('for') === 'My child'; };

      function validate() {
        err.textContent = '';
        if (i === 0 && !val('for')) return 'Please choose who the class is for.';
        if (i === 1) {
          var nm = form.elements.name.value.trim();
          if (nm.length < 2) return isChild() ? 'Please enter your child’s name.' : 'Please enter your name.';
          if (isChild()) { var a = parseInt(form.age.value, 10); if (!(a >= 2 && a <= 80)) return 'Please enter your child’s age.'; }
        }
        if (i === 2) {
          var d = form.phone.value.replace(/\D/g, '').replace(/^(91|0)(?=\d{10}$)/, '');
          if (!/^[6-9]\d{9}$/.test(d)) return 'Please enter a valid 10-digit mobile number.';
        }
        if (i === 3 && !val('dance')) return 'Pick a style — or “Not sure yet”.';
        if (i === 4 && !val('time')) return 'Pick a time that suits you.';
        return '';
      }

      function show(to, dir) {
        var from = steps[i], target = steps[to];
        i = to;
        var finish = function () {
          from.classList.remove('is-active'); target.classList.add('is-active');
          if (G && !App.static) G.fromTo(target, { x: dir * 50, opacity: 0 }, { x: 0, opacity: 1, duration: .7, ease: App.ease });
          var f = $('input[type="text"], input[type="tel"]', target); if (f) setTimeout(function () { f.focus({ preventScroll: true }); }, 80);
        };
        if (G && !App.static && from !== target) G.to(from, { x: -dir * 50, opacity: 0, duration: .35, ease: 'power2.in', onComplete: finish }); else finish();
        stepEl.textContent = String(i + 1).padStart(2, '0');
        hint.textContent = hints[i];
        bar.style.transform = 'scaleX(' + ((i + 1) / n) + ')';
        back.hidden = i === 0;
        nextT.innerHTML = i === n - 1 ? '<span class="roll"><span class="roll__a">Book my free class</span><span class="roll__b" aria-hidden="true">Book my free class</span></span>' : '<span class="roll"><span class="roll__a">Continue</span><span class="roll__b" aria-hidden="true">Continue</span></span>';
      }

      function adapt() {
        var c = isChild();
        ageWrap.hidden = !c;
        nameQ.textContent = c ? 'Your child’s name?' : 'What’s your name?';
        form.elements.name.placeholder = c ? 'Child’s name' : 'Name';
      }

      function advance() {
        var m = validate(); if (m) { err.textContent = m; if (G && !App.static) G.fromTo(err, { x: -8 }, { x: 0, duration: .5, ease: 'elastic.out(1,.3)' }); return; }
        if (i === 0) adapt();
        if (i < n - 1) show(i + 1, 1); else submit();
      }

      next.addEventListener('click', advance);
      back.addEventListener('click', function () { err.textContent = ''; if (i > 0) show(i - 1, -1); });
      form.addEventListener('keydown', function (e) { if (e.key === 'Enter' && e.target.tagName === 'INPUT' && e.target.type !== 'radio') { e.preventDefault(); advance(); } });
      form.addEventListener('change', function (e) {
        if (e.target.type !== 'radio') return;
        err.textContent = '';
        if (e.target.name === 'for') adapt();
        if (e.target.name === 'for' || e.target.name === 'dance') setTimeout(advance, 380);
      });

      function submit() {
        if (form.website.value) return;                       // honeypot
        var data = {
          for: val('for'), name: form.elements.name.value.trim(), age: isChild() ? form.age.value.trim() : '',
          phone: form.phone.value.replace(/\D/g, '').replace(/^(91|0)(?=\d{10}$)/, ''),
          style: val('dance'), time: val('time')
        };
        var msg = 'Hi ' + RS.name + '! ✨ I’d like to book a FREE TRIAL CLASS.\n\n' +
          '• For: ' + data.for + '\n' +
          '• Name: ' + data.name + '\n' +
          (data.age ? '• Age: ' + data.age + '\n' : '') +
          '• Phone: ' + data.phone + '\n' +
          '• Style: ' + data.style + '\n' +
          '• Preferred time: ' + data.time + '\n\nThank you!';
        var url = 'https://wa.me/' + RS.wa + '?text=' + encodeURIComponent(msg);

        if (RS.endpoint) {                                    // quiet lead log (no admin panel; storage/leads.csv)
          try { fetch(RS.endpoint, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data), keepalive: true }).catch(function () {}); } catch (e) {}
        }

        var done = $('#tfDone'), wrap = form;
        $('#tfDoneName').textContent = data.name.split(' ')[0] || 'star';
        $('#tfWaFallback').href = url;
        var show = function () { wrap.hidden = true; done.hidden = false; if (G && !App.static) G.from(done.children, { y: 30, opacity: 0, duration: .9, stagger: .1, ease: 'power3.out' }); };
        if (G && !App.static) G.to(wrap, { opacity: 0, y: -20, duration: .4, onComplete: show }); else show();
        starBurst();
        setTimeout(function () {
          var w = window.open(url, '_blank');
          if (w) { try { w.opener = null; } catch (e) {} } else { window.location.href = url; }
        }, 2100);
      }
    }

    /* ───────── star-burst confetti ───────── */
    function starBurst() {
      var cv = $('#confetti'); if (!cv || App.static) return;
      var ctx = cv.getContext('2d'), dpr = Math.min(2, window.devicePixelRatio || 1);
      cv.width = innerWidth * dpr; cv.height = innerHeight * dpr; ctx.scale(dpr, dpr);
      var colors = ['#FF2E88', '#FFD60A', '#F6F2EC', '#FF2E88', '#FFD60A'], ps = [], i;
      var ox = innerWidth * .5, oy = innerHeight * .55;
      for (i = 0; i < 170; i++) {
        var a = Math.random() * Math.PI * 2, s = 6 + Math.random() * 16;
        ps.push({ x: ox, y: oy, vx: Math.cos(a) * s, vy: Math.sin(a) * s - 6, r: 5 + Math.random() * 9, rot: Math.random() * 6, vr: (Math.random() - .5) * .3,
          c: colors[(Math.random() * colors.length) | 0], star: Math.random() < .55, life: 1 });
      }
      function star(x, y, r, rot) {
        ctx.beginPath();
        for (var k = 0; k < 10; k++) { var rr = k % 2 ? r * .45 : r, an = rot + k * Math.PI / 5 - Math.PI / 2; ctx.lineTo(x + Math.cos(an) * rr, y + Math.sin(an) * rr); }
        ctx.closePath(); ctx.fill();
      }
      var t0 = performance.now();
      (function frame(t) {
        var el = t - t0; ctx.clearRect(0, 0, innerWidth, innerHeight);
        ps.forEach(function (p) {
          p.vx *= .985; p.vy = p.vy * .985 + .38; p.x += p.vx; p.y += p.vy; p.rot += p.vr; p.life = Math.max(0, 1 - el / 3600);
          ctx.globalAlpha = p.life; ctx.fillStyle = p.c;
          if (p.star) star(p.x, p.y, p.r, p.rot); else { ctx.save(); ctx.translate(p.x, p.y); ctx.rotate(p.rot); ctx.fillRect(-p.r / 2, -p.r / 4, p.r, p.r / 2); ctx.restore(); }
        });
        if (el < 3700) requestAnimationFrame(frame); else ctx.clearRect(0, 0, innerWidth, innerHeight);
      })(t0);
    }

    /* ───────── dark map with a glowing pink star pin ───────── */
    function map() {
      var el = $('#map'); if (!el) return;
      var loaded = false;
      var pinSvg = '<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 1.5l2.9 6.6 7.1.7-5.4 4.8 1.6 7-6.2-3.7-6.2 3.7 1.6-7L2 8.8l7.1-.7z"/></svg>';

      function leaflet() {
        var css = document.createElement('link'); css.rel = 'stylesheet'; css.href = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css'; document.head.appendChild(css);
        var s = document.createElement('script'); s.src = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js';
        s.onload = function () {
          var L = window.L, ll = [RS.geo.lat, RS.geo.lng];
          var m = L.map(el, { center: ll, zoom: 15, zoomControl: true, scrollWheelZoom: false, attributionControl: true });
          L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OpenStreetMap contributors' }).addTo(m);
          L.marker(ll, { icon: L.divIcon({ className: '', html: '<div class="pin">' + pinSvg + '</div>', iconSize: [30, 30], iconAnchor: [15, 15] }), keyboard: false }).addTo(m);
          m.once('click', function () { m.scrollWheelZoom.enable(); });
        };
        document.head.appendChild(s);
      }

      function google() {
        var style = [
          { elementType: 'geometry', stylers: [{ color: '#0e0c10' }] },
          { elementType: 'labels.text.fill', stylers: [{ color: '#8B8790' }] },
          { elementType: 'labels.text.stroke', stylers: [{ color: '#08070A' }] },
          { featureType: 'road', elementType: 'geometry', stylers: [{ color: '#1c1a20' }] },
          { featureType: 'road.highway', elementType: 'geometry', stylers: [{ color: '#2a2630' }] },
          { featureType: 'water', elementType: 'geometry', stylers: [{ color: '#050407' }] },
          { featureType: 'poi', stylers: [{ visibility: 'off' }] },
          { featureType: 'transit', stylers: [{ visibility: 'off' }] }
        ];
        window.__rsMap = function () {
          var g = window.google.maps, pos = { lat: RS.geo.lat, lng: RS.geo.lng };
          var m = new g.Map(el, { center: pos, zoom: 16, styles: style, disableDefaultUI: true, zoomControl: true, gestureHandling: 'cooperative' });
          new g.Marker({ position: pos, map: m, title: RS.name, icon: { path: 'M12 1.5l2.9 6.6 7.1.7-5.4 4.8 1.6 7-6.2-3.7-6.2 3.7 1.6-7L2 8.8l7.1-.7z', fillColor: '#FF2E88', fillOpacity: 1, strokeColor: '#FFD60A', strokeWeight: 1.5, scale: 1.6, anchor: new g.Point(12, 12) } });
        };
        var s = document.createElement('script'); s.src = 'https://maps.googleapis.com/maps/api/js?key=' + encodeURIComponent(RS.mapsKey) + '&callback=__rsMap'; s.async = true; document.head.appendChild(s);
      }

      function load() { if (loaded) return; loaded = true; RS.mapsKey ? google() : leaflet(); }
      if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (e, o) { if (e[0].isIntersecting) { load(); o.disconnect(); } }, { rootMargin: '700px' }).observe(el);
      } else load();
    }
  }
})();
