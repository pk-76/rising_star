# Rising Star Dance Academy — "Every star starts here."

PHP + vanilla JS (GSAP, ScrollTrigger, Lenis from CDN). No database, no admin panel, no build step.
Open `http://localhost/Rising_Star-Dance_Academy/` with XAMPP running (Apache + mod_rewrite).

## Where things live

| What | Where |
|---|---|
| **All copy, business data, styles, classes, mentors, timetable, reviews, gallery, image keys** | `data/config.php` |
| Page sections (one file per act) | `inc/*.php` |
| Style SEO pages (`/bollywood-dance-classes-guwahati` …) | `style.php` (content from `styles` in config) |
| Design system / layout | `assets/css/main.css` |
| Interactions | `assets/js/core.js` (boot, scroll, preloader, menu, cursor, sound) · `hero.js` · `scroll.js` · `widgets.js` |
| Branded 404 · sitemap.xml · robots.txt | `404.php` · `sitemap.php` · `robots.php` (routed in `.htaccess`) |
| Free-trial lead log | `enquire.php` → `storage/leads.csv` (blocked from the web; open it in Excel) |

## Replace the placeholders (nothing in code needs editing)

Every placeholder in the HTML carries a comment `REPLACE WITH REAL RISING STAR PHOTO/VIDEO (shot brief: …)`.

* **Photo:** drop `assets/img/photos/<key>.jpg|webp|avif` (keys are in `data/config.php → images`, e.g. `hero`, `st_bollywood`, `mentor1`). It replaces the stock photo automatically.
* **Looping video:** drop `assets/video/<key>.mp4` (+ optional `<key>.webm`, and `<key>-m.mp4` for phones). Keep each under ~2 MB, 5–10 s, H.264, no audio. The photo with the same key becomes the poster. Keys that support video: `hero`, every `st_*`, `stage1/3/5/8`, `showreel`.
* **Showreel modal:** `assets/video/showreel.mp4`, or set `showreel_embed` (YouTube/Vimeo embed URL) in config.
* **Music:** drop `assets/audio/dance-loop.mp3`. Until then the Sound toggle plays a small synthesised 100 BPM loop.
* **Mentors / reviews / timetable:** edit `mentors`, `reviews`, `timetable` in config, then set `reviews_placeholder` and `timetable_placeholder` to `false` to remove the "illustrative" tags.

## Still marked [CONFIRM] / [ADD …]

Opening hours (8:00 AM – 8:30 PM, 7 days) · final style list · kids/teens age ranges · instructor names, specialties and experience · Instagram/Facebook handles · exact map coordinates (`biz.geo`, then `geo_confirmed => true` to emit it in the schema) · annual-showcase date/venue · real batch timings. Fees are never shown; every route goes to WhatsApp.

## Optional

* `biz.maps_key` — Google Maps JS API key → the map switches to a custom dark Google Map with a pink star pin. Empty = free dark OpenStreetMap (light usage only; check OSM's tile policy for high traffic).
* `biz.site_url` — set your real domain for canonical/OG/sitemap URLs. Empty = auto-detected.
* `biz.lead_log` — `false` disables writing to `storage/leads.csv`.

## Notes

* The OG image (`assets/img/og.png`), favicon (`favicon.svg`) and apple icon are branded; regenerate if the logo changes.
* The site degrades cleanly: `prefers-reduced-motion`, no-JS, or a failed CDN fall back to a static layout (no pinned scrolling, no preloader).
* Mobile: no custom cursor, spotlight auto-sweeps, lighter reveals, sticky Call · WhatsApp · Free Trial bar.
