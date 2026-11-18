</main>

<!-- ═══════════════ FOOTER — CURTAIN CALL ═══════════════ -->
<footer class="ft dark" id="footer" data-theme="dark">
  <div class="ft__glow" aria-hidden="true"><i></i><i></i></div>
  <p class="act mono ft__act"><span class="beat-s"><?= star_svg('star star--s') ?></span><span>CURTAIN CALL</span><i></i><span>THANK YOU FOR WATCHING</span></p>

  <div class="ft__top">
    <div class="ft__col">
      <p class="ft__k mono">ADDRESS</p>
      <address><?= e($B['street']) ?>,<br><?= e($B['locality']) ?>, <?= e($B['region']) ?> <?= e($B['postal']) ?></address>
    </div>
    <div class="ft__col">
      <p class="ft__k mono">HOURS</p>
      <p>Open 7 days a week<br>8:00 AM – 8:30 PM<br><span class="ft__dim">[approx. — batch timings vary]</span></p>
    </div>
    <div class="ft__col">
      <p class="ft__k mono">CONTACT</p>
      <p><a href="tel:<?= e($B['tel']) ?>"><?= e($B['phone']) ?></a><br><a href="mailto:<?= e($B['email']) ?>"><?= e($B['email']) ?></a><br><a href="<?= e(wa_link($C)) ?>" target="_blank" rel="noopener">WhatsApp us ↗</a></p>
    </div>
    <div class="ft__col">
      <p class="ft__k mono">SOCIAL</p>
      <p>
        <?php if (!empty($B['instagram'])): ?><a href="https://instagram.com/<?= e(ltrim($B['instagram'], '@')) ?>" target="_blank" rel="noopener">Instagram ↗</a><?php else: ?><span class="ft__dim">Instagram — [ADD HANDLE]</span><?php endif; ?><br>
        <?php if (!empty($B['facebook'])): ?><a href="https://facebook.com/<?= e(ltrim($B['facebook'], '/')) ?>" target="_blank" rel="noopener">Facebook ↗</a><?php else: ?><span class="ft__dim">Facebook — [ADD HANDLE]</span><?php endif; ?><br>
        <a href="<?= e($C['google_reviews_url']) ?>" target="_blank" rel="noopener">Google Reviews ↗</a>
      </p>
    </div>
  </div>

  <nav class="ft__styles mono" aria-label="Dance styles">
    <?php foreach ($C['styles'] as $s): ?><a href="<?= e(base_path() . '/' . $s[1]) ?>"><?= e($s[0]) ?> classes in Guwahati</a><?php endforeach; ?>
  </nav>

  <div class="ft__word" id="ftWord" aria-hidden="true"><?= letters('RISING STAR', 'l') ?></div>

  <div class="ft__bot mono">
    <span>© <?= date('Y') ?> <?= e($B['name']) ?>, <?= e($B['locality']) ?>. <?= e($B['tagline']) ?></span>
    <span>GUWAHATI · <time id="clock2"><?= e($state['time']) ?></time> IST</span>
    <button type="button" class="ft__up" id="toTop" data-magnetic><?= roll('Back to top ↑') ?></button>
  </div>
</footer>

<!-- ═══════════════ PERSISTENT ═══════════════ -->
<nav class="mbar" aria-label="Quick contact">
  <a href="tel:<?= e($B['tel']) ?>"><?= roll('Call') ?></a>
  <a href="<?= e(wa_link($C, 'Hi Rising Star Dance Academy! I’d like to know more.')) ?>" target="_blank" rel="noopener"><?= roll('WhatsApp') ?></a>
  <a href="<?= e($NAV_HOME) ?>#finale" <?= $NAV_HOME === '' ? 'data-nav' : '' ?> class="is-pink"><?= roll('Free Trial') ?></a>
</nav>

<a class="orb" href="<?= e(wa_link($C, 'Hi Rising Star Dance Academy! I’d like to know more.')) ?>" target="_blank" rel="noopener" aria-label="Chat with Rising Star Dance Academy on WhatsApp" data-magnetic data-cursor="CHAT">
  <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.9 9.9 0 0 0 4.74 1.21h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm0 18.15h-.01a8.2 8.2 0 0 1-4.18-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.22 8.22 0 0 1-1.26-4.38c0-4.54 3.7-8.23 8.24-8.23 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.82c0 4.54-3.7 8.23-8.23 8.23Zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.12-.16.25-.64.81-.78.97-.14.17-.29.19-.54.06-.25-.12-1.05-.39-1.99-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.34-.76-1.84-.2-.48-.4-.42-.56-.42h-.48c-.17 0-.43.06-.66.31-.22.25-.86.85-.86 2.07 0 1.22.89 2.4 1.01 2.56.12.17 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.07.14-1.18-.06-.1-.22-.16-.47-.28Z"/></svg>
</a>

<button type="button" class="snd mono" id="sound" aria-pressed="false" aria-label="Toggle ambient dance music">
  <span class="snd__bars" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
  <span id="soundT">SOUND OFF</span>
</button>

<?php
$audio = is_file(RS_ROOT . '/assets/audio/dance-loop.mp3') ? asset('audio/dance-loop.mp3') : '';
$boot = [
    'name'     => $B['name'],
    'wa'       => $B['wa'],
    'tel'      => $B['tel'],
    'hours'    => $C['hours'],
    'geo'      => $B['geo'],
    'mapsKey'  => $B['maps_key'],
    'endpoint' => $B['lead_log'] ? base_path() . '/enquire.php' : '',
    'address'  => $B['street'] . ', ' . $B['locality'] . ', ' . $B['region'] . ' ' . $B['postal'],
    'audio'    => $audio,
    'home'     => $NAV_HOME,
];
?>
<script>window.RS = <?= json_encode($boot, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/CustomEase.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/lenis@1.1.13/dist/lenis.min.js" defer></script>
<script src="<?= e(asset('js/core.js')) ?>" defer></script>
<script src="<?= e(asset('js/hero.js')) ?>" defer></script>
<script src="<?= e(asset('js/scroll.js')) ?>" defer></script>
<script src="<?= e(asset('js/widgets.js')) ?>" defer></script>
</body>
</html>
