<?php
/**
 * RISING STAR DANCE ACADEMY — single source of truth.
 * All copy, business data, styles, classes, instructors, timetable, reviews and gallery live here.
 * Items marked [CONFIRM] / [ADD ...] / [INSTRUCTOR NAME] are placeholders waiting for real details.
 *
 * MEDIA: every image/video key below can be replaced without touching code:
 *   assets/img/photos/<key>.jpg|webp|avif      → replaces the stock placeholder photo
 *   assets/video/<key>.mp4  (+ .webm, optional <key>-m.mp4 for mobile, <key>.jpg poster)  → enables the looping video
 */

return [

    /* ───────────── BUSINESS (use exactly) ───────────── */
    'biz' => [
        'name'        => 'Rising Star Dance Academy',
        'short'       => 'RISING STAR',
        'tagline'     => 'Every star starts here.',
        'street'      => 'GNRC Hospital, Necha Building, 2nd Floor, opposite Om Shree Guest House, Six Mile',
        'locality'    => 'Guwahati',
        'region'      => 'Assam',
        'postal'      => '781036',
        'country'     => 'IN',
        'phone'       => '+91 99577 65174',
        'tel'         => '+919957765174',
        'wa'          => '919957765174',
        'email'       => 'risingstarghy@gmail.com',
        'rating'      => 4.8,
        'reviews'     => 100,
        'styles_count'=> 6,
        'days'        => 7,
        'instagram'   => '',            // [ADD HANDLE] e.g. 'risingstarghy'
        'facebook'    => '',            // [ADD HANDLE / PAGE]
        'maps_key'    => '',            // optional Google Maps JS API key. Empty = free dark Leaflet map.
        // Approximate position of Six Mile / GNRC. [ADD] exact coordinates:
        // Google Maps → right-click the academy pin → click the lat,lng to copy.
        'geo'         => ['lat' => 26.1480, 'lng' => 91.7895],
        'geo_confirmed' => false,       // true once exact coordinates are set (enables geo in schema)
        'site_url'    => '',            // e.g. 'https://www.risingstarghy.in' — empty = auto-detect
        'lead_log'    => true,          // store trial enquiries in storage/leads.csv (private)
        'hours_confirmed' => false,     // hours are approximate [CONFIRM]
    ],

    // 0 = Sunday … 6 = Saturday. [open hour, close hour] decimal 24h. [CONFIRM] approx. 8:00 AM – 8:30 PM daily
    'hours' => [
        1 => ['Monday',    8, 20.5], 2 => ['Tuesday', 8, 20.5], 3 => ['Wednesday', 8, 20.5],
        4 => ['Thursday',  8, 20.5], 5 => ['Friday',  8, 20.5], 6 => ['Saturday',  8, 20.5],
        0 => ['Sunday',    8, 20.5],
    ],

    /* ───────────── SEO ───────────── */
    'seo' => [
        'title'       => 'Rising Star Dance Academy | Dance Classes in Six Mile, Guwahati',
        'description' => 'Dance classes in Guwahati for kids, teens, beginners and performers. Bollywood, contemporary, jazz, popping and western dance at Six Mile, near GNRC Hospital. Rated 4.8★ — book a free trial class.',
        'keywords'    => 'dance classes in Guwahati, dance academy Six Mile, dance classes for kids Guwahati, Bollywood dance classes Guwahati, beginner dance classes Guwahati, dance classes near GNRC Hospital, Rising Star Dance Academy',
    ],

    /* ───────────── MENU (label, href, image key) ───────────── */
    'menu' => [
        ['The Academy',  '#academy',   'kids'],
        ['The Styles',   '#styles',    'st_contemporary'],
        ['Classes',      '#classes',   'teens'],
        ['The Stage',    '#stage',     'stage1'],
        ['The Mentors',  '#mentors',   'mentor1'],
        ['Applause',     '#applause',  'stage5'],
        ['Timetable',    '#timetable', 'st_western'],
        ['Free Trial',   '#finale',    'hero'],
    ],

    'marquee' => ['BOLLYWOOD', 'CONTEMPORARY', 'JAZZ', 'POPPING', 'WESTERN', 'CHOREOGRAPHY'],

    /* ───────────── ACT I ───────────── */
    'manifesto' => 'Every great performer once took their first step. At Rising Star, we turn shy first steps into <em>confident</em> performances, with patient <em>mentors</em>, energetic classes and a <em>stage</em> waiting for you.',

    'pillars' => [
        ['CONFIDENCE', 'The quiet kind that shows up at school, at home and on stage.'],
        ['TECHNIQUE',  'Strong foundations — posture, timing, musicality — taught step by step.'],
        ['PERFORMANCE','Real shows, real lights, real applause. Every dancer gets their moment.'],
    ],

    /* ───────────── ACT II STYLES [CONFIRM final list] ─────────────
       name, slug, short desc, age group, image key, long copy (for each style's SEO page), what you learn */
    'styles' => [
        ['Bollywood', 'bollywood-dance-classes-guwahati', 'Colour, story and swagger — filmi hooks, expressions and the joy of big-screen choreography.', 'AGES 6+ · ALL LEVELS', 'st_bollywood',
            'Bollywood dance is the most joyful way to start dancing. At Rising Star in Six Mile, Guwahati, our Bollywood classes break down iconic film choreography into clear, fun steps — so beginners and kids feel the music and nail the moves within weeks.',
            ['Hook steps and signature film moves', 'Facial expressions and storytelling', 'Rhythm, timing and stage presence', 'Group formations for shows and events']],
        ['Contemporary', 'contemporary-dance-classes-guwahati', 'Flow, floor-work and feeling — emotion turned into movement.', 'AGES 10+ · BEGINNER–ADVANCED', 'st_contemporary',
            'Contemporary dance blends control with freedom. Our Guwahati contemporary classes build flexibility, balance and musical interpretation, guiding dancers from first technique drills to expressive, stage-ready pieces.',
            ['Floor-work, release and balance', 'Flexibility and core control', 'Musical interpretation', 'Expressive, stage-ready choreography']],
        ['Jazz', 'jazz-dance-classes-guwahati', 'Sharp lines, sparkle and rhythm — technique with attitude.', 'AGES 8+ · BEGINNER–INTERMEDIATE', 'st_jazz',
            'Jazz dance is precision with personality. In our Guwahati jazz classes you will learn isolations, turns, leaps and sharp stage lines — building technique and confidence in equal measure.',
            ['Isolations, turns and leaps', 'Jazz walks, lines and extensions', 'Strength and stamina', 'Performance attitude']],
        ['Popping', 'popping-dance-classes-guwahati', 'Hits, grooves and street-style control — the pulse of hip-hop culture.', 'AGES 10+ · ALL LEVELS', 'st_popping',
            'Popping is all about control: muscle hits, grooves and sharp transitions in time with the beat. Our Six Mile popping classes teach the fundamentals, freestyle confidence and street-style performance.',
            ['Pops, hits and fixed points', 'Grooves and bounces', 'Musicality and freestyle', 'Battle and cypher confidence']],
        ['Western', 'western-dance-classes-guwahati', 'Hip-hop, freestyle and commercial — today’s chart-topping choreography.', 'AGES 8+ · ALL LEVELS', 'st_western',
            'Western dance brings together hip-hop, commercial and freestyle styles. Our classes in Guwahati keep things energetic and approachable — perfect for teens, beginners and anyone who wants to move to today’s music.',
            ['Hip-hop foundations and grooves', 'Commercial choreography', 'Freestyle and cypher basics', 'Music-video style routines']],
        ['Choreography', 'choreography-classes-guwahati', 'Performance choreography for stage shows, events and competitions.', 'ALL AGES · AUDITION / SELECT', 'st_choreo',
            'For dancers ready to perform. Our performance choreography programme at Rising Star builds show-ready routines for stage events, school functions and competitions — with formations, transitions and polished presentation.',
            ['Show-ready routines and formations', 'Stage craft and spacing', 'Competition preparation', 'Costume and music guidance']],
    ],

    /* ───────────── ACT III CLASSES FOR EVERYONE ───────────── */
    'classes' => [
        ['Kids',      'Confidence, coordination and joy, in a safe, caring environment.',   'AGES [CONFIRM — e.g. 4–12]', 'kids'],
        ['Teens',     'Bollywood, western and choreography for stage and competitions.',    'AGES [CONFIRM — e.g. 13–18]', 'teens'],
        ['Beginners', 'Never danced before? We start from step one.',                       'ALL AGES · NO EXPERIENCE NEEDED', 'beginners'],
        ['Performers','Stage shows, events and competitions.',                              'SELECT BATCHES', 'performers'],
    ],

    'parents' => [
        ['A safe, caring environment',   'Welcoming space, respectful culture, and a team that treats every child like their own.'],
        ['Supportive instructors',       'Patient mentors who correct with kindness and celebrate every small win.'],
        ['Progress you can see',         'Confidence, coordination and routines that grow visibly, week after week.'],
        ['Real performance opportunities','Showcases, events and competitions — so the practice has a stage to land on.'],
    ],

    /* ───────────── ACT IV THE STAGE ─────────────
       type, key, caption, grid size class. Add a video by dropping assets/video/<key>.mp4 */
    'gallery' => [
        ['video', 'stage1', 'CLIP 01 / BOLLYWOOD / ANNUAL SHOW',      'g-tall'],
        ['image', 'stage2', 'FRAME 02 / BALLET FUSION / REHEARSAL',    'g-wide'],
        ['video', 'stage3', 'CLIP 03 / CONTEMPORARY / ANNUAL SHOW',    ''],
        ['image', 'stage4', 'FRAME 04 / STAGE LIGHTS / FINALE',        'g-tall'],
        ['video', 'stage5', 'CLIP 05 / POPPING / SHOWCASE',            ''],
        ['image', 'stage6', 'FRAME 06 / KIDS BATCH / PERFORMANCE DAY', 'g-wide'],
        ['image', 'stage7', 'FRAME 07 / COLOUR BURST / FESTIVAL',      ''],
        ['video', 'stage8', 'CLIP 08 / FORMATIONS / FROM ABOVE',       'g-tall'],
    ],
    'showcase' => ['ANNUAL SHOWCASE', '[DATE & VENUE — CONFIRM]'],

    /* ───────────── ACT V MENTORS (placeholders) ───────────── */
    'mentors' => [
        ['[INSTRUCTOR NAME]', 'BOLLYWOOD · WESTERN',            '[X]+ YEARS TEACHING', 'mentor1'],
        ['[INSTRUCTOR NAME]', 'CONTEMPORARY · JAZZ',            '[X]+ YEARS TEACHING', 'mentor2'],
        ['[INSTRUCTOR NAME]', 'POPPING · CHOREOGRAPHY',         '[X]+ YEARS TEACHING', 'mentor3'],
    ],

    /* ───────────── ACT VI APPLAUSE ─────────────
       Replace with real Google reviews, then set to false (hides the “illustrative” tag). */
    'reviews_placeholder' => true,
    'reviews' => [
        ['SUPPORTIVE INSTRUCTORS',    'PARENT',  'The instructors are patient and so encouraging. My daughter walks in shy and walks out grinning.'],
        ['KIDS LOVE IT',              'PARENT',  'My son counts the days to his class. He actually asks to practise at home — that never happened before.'],
        ['POSITIVE ATMOSPHERE',       'STUDENT', 'Nobody judges you here. Everyone claps for everyone, and that energy makes you want to try harder.'],
        ['CONFIDENCE GROWTH',         'PARENT',  'The change in confidence in just a few months is real. She now volunteers to perform at school.'],
        ['GREAT CHOREOGRAPHY',        'STUDENT', 'The choreography is fresh, fun and challenging at the right level. Our stage performance was unforgettable.'],
        ['BEGINNER-FRIENDLY',         'STUDENT', 'I had never danced before. They started from step one and I never felt left behind.'],
    ],
    'google_reviews_url' => 'https://www.google.com/maps/search/?api=1&query=Rising+Star+Dance+Academy+Six+Mile+Guwahati',

    /* ───────────── ACT VII TIMETABLE ─────────────
       [day 1=Mon … 7=Sun, start, end, style slug-name, age group (Kids/Teens/Adults), level]
       PLACEHOLDER batches — replace with the academy's real timings. */
    'timetable_placeholder' => true,
    'timetable' => [
        [1, '16:30', '17:30', 'Bollywood',    'Kids',   'Beginner'],
        [1, '18:00', '19:15', 'Western',      'Teens',  'All levels'],
        [2, '17:00', '18:15', 'Contemporary', 'Teens',  'Intermediate'],
        [2, '18:30', '19:45', 'Bollywood',    'Adults', 'Beginner'],
        [3, '16:30', '17:30', 'Jazz',         'Kids',   'Beginner'],
        [3, '18:00', '19:15', 'Popping',      'Teens',  'All levels'],
        [4, '17:00', '18:15', 'Bollywood',    'Teens',  'All levels'],
        [4, '18:30', '20:00', 'Choreography', 'Teens',  'Performance'],
        [5, '16:30', '17:30', 'Western',      'Kids',   'Beginner'],
        [5, '18:00', '19:15', 'Contemporary', 'Adults', 'Beginner'],
        [6, '09:00', '10:15', 'Bollywood',    'Kids',   'All levels'],
        [6, '10:30', '11:45', 'Jazz',         'Teens',  'Intermediate'],
        [6, '17:00', '18:30', 'Choreography', 'Teens',  'Performance'],
        [7, '09:30', '10:45', 'Western',      'Kids',   'All levels'],
        [7, '11:00', '12:15', 'Popping',      'Teens',  'All levels'],
        [7, '17:00', '18:15', 'Contemporary', 'Adults', 'All levels'],
    ],

    /* ───────────── FINALE FORM ───────────── */
    'for'   => ['Myself', 'My child'],
    'times' => [
        ['Morning',   '8 AM – 12 PM'],
        ['Afternoon', '12 PM – 4 PM'],
        ['Evening',   '4 PM – 8:30 PM'],
        ['Weekend',   'SAT / SUN'],
    ],

    /* showreel: optional YouTube/Vimeo embed URL, else assets/video/showreel.mp4, else poster */
    'showreel_embed' => '',

    /* ───────────── IMAGES (key => [unsplash id, alt, shot brief, object-position]) ───────────── */
    'images' => [
        'hero'  => ['1518834107812-67b0b7c58434', 'Dancer in a flowing white dress mid-movement under a stage spotlight',
                    'HERO (looping video, 16:9, 8–10 s). Dancer in flowing fabric mid-turn against a dark studio/stage, single hard spotlight from above, slight haze, slow-motion. Subject slightly right of centre so the headline sits left. Also shoot a 9:16 version for mobile.', '60% 40%'],

        'kids'      => ['1429277158984-614d155e0017', 'Young girl twirling in golden light', 'KIDS — joyful child mid-twirl in warm backlight, flowing skirt. Portrait 3:4. Also a 6 s loop.', '50% 40%'],
        'teens'     => ['1535525153412-5a42439a210d', 'Teen dancer striking a pose under pink and purple lights', 'TEENS — teen dancer in street/Bollywood costume against pink-purple stage lights, motion blur. Portrait 3:4.', '50% 40%'],
        'beginners' => ['1524594152303-9fd13543fe6e', 'Dance class learning a routine in a bright mirrored studio', 'BEGINNERS — adults and kids learning a step together in the Rising Star studio, laughing, mirror behind. Landscape 4:3.', '50% 50%'],
        'performers'=> ['1545959570-a94084071b5d', 'Group of dancers in colourful costumes performing on a dark stage', 'PERFORMERS — group in matching costumes on stage, full formation, coloured wash lights. Landscape 4:3.', '50% 50%'],

        'st_bollywood'    => ['1545959570-a94084071b5d', 'Dancers in vibrant costumes performing a Bollywood routine on stage', 'BOLLYWOOD (video loop 8 s, portrait 4:5) — group or solo in bright costumes, hook step, big smiles, colourful lights.', '50% 50%'],
        'st_contemporary' => ['1547153760-18fc86324498', 'Contemporary dancer in yellow trousers reaching out against a dark grey backdrop', 'CONTEMPORARY (video loop) — solo dancer, floor-work or leap, flowing fabric, single side light, haze.', '50% 35%'],
        'st_jazz'         => ['1508807526345-15e9b5f4eaff', 'Ballet and jazz dancers in white costumes mid-routine on stage', 'JAZZ (video loop) — sharp lines, leaps and turns, costumes with sparkle, dark stage with a pink wash.', '50% 40%'],
        'st_popping'      => ['1535525153412-5a42439a210d', 'Street dancer in a pose against neon city lights', 'POPPING (video loop) — dancer hitting pops/isolations, neon/pink light, close-up hands and footwork.', '50% 40%'],
        'st_western'      => ['1524594152303-9fd13543fe6e', 'Dancers practising a hip-hop routine in a studio', 'WESTERN / HIP-HOP (video loop) — group in a studio, wide-leg moves, mirrors, energetic.', '50% 50%'],
        'st_choreo'       => ['1504609813442-a8924e83f76e', 'Overhead view of dancers moving in formation with long shadows', 'CHOREOGRAPHY (video loop) — overhead shot of a group formation changing shape; clean floor, long shadows.', '50% 50%'],

        'stage1' => ['1545959570-a94084071b5d', 'Group performance on stage under coloured lights', 'ANNUAL SHOW — wide shot of full-cast Bollywood finale. Portrait crop 3:4 for video loop.', '50% 50%'],
        'stage2' => ['1508807526345-15e9b5f4eaff', 'Dancers in white costumes on stage with arms raised', 'REHEARSAL — group in costume mid-formation, stage lights, wide 16:9.', '50% 40%'],
        'stage3' => ['1518834107812-67b0b7c58434', 'Solo contemporary dancer in white fabric on a dark stage', 'CONTEMPORARY SOLO — slow-motion fabric movement, spotlight (video loop).', '50% 40%'],
        'stage4' => ['1514525253161-7a46d19cd819', 'Stage lights and an applauding crowd', 'FINALE — audience applauding with stage lights behind; portrait 3:4.', '50% 50%'],
        'stage5' => ['1516450360452-9312f5e86fc7', 'Pink and blue stage lights over a cheering audience', 'POPPING SHOWCASE — dancers hitting freeze on a darkened stage, pink/blue lights (video loop).', '50% 50%'],
        'stage6' => ['1429962714451-bb934ecdc4ec', 'Heart-shaped hands raised in front of stage lights', 'KIDS BATCH — children taking a bow after their first show, parents clapping. Wide 16:9.', '50% 40%'],
        'stage7' => ['1496024840928-4c417adf211d', 'Colour powder burst over a joyful crowd', 'FESTIVAL / CELEBRATION — colour, confetti or festival-day performance. Square.', '50% 50%'],
        'stage8' => ['1504609813442-a8924e83f76e', 'Dancers seen from above forming shapes on the floor', 'FORMATIONS FROM ABOVE — overhead group formation (video loop). Portrait 3:4.', '50% 50%'],

        'mentor1' => ['1547153760-18fc86324498', 'Dancer instructor in a confident pose', 'INSTRUCTOR portrait — waist-up, confident pose in studio, soft key light with pink rim light. Portrait 3:4.', '50% 30%'],
        'mentor2' => ['1546961342-ea5f71b193f3', 'Smiling instructor with a warm expression', 'INSTRUCTOR portrait — warm natural smile, studio background. Portrait 3:4.', '50% 30%'],
        'mentor3' => ['1535525153412-5a42439a210d', 'Instructor striking a pose under stage lighting', 'INSTRUCTOR portrait — mid-move, stage light, shallow depth. Portrait 3:4.', '50% 30%'],

        'showreel' => ['1518834107812-67b0b7c58434', 'Showreel poster of a dancer in white fabric', 'SHOWREEL poster — hero frame from the showreel.', '50% 40%'],
    ],
];
