<!DOCTYPE html>
<html lang="id" class="scroll-smooth no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kabarsih✱ — Suara Warga FISIP</title>
    <meta name="description" content="Ruang bebas warga FISIP buat nyalurin aspirasi, baca kabar kampus, dan bikin suara kritis tetap aman.">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&family=Instrument+Serif:ital@0;1&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

    <script>
        document.documentElement.classList.remove('no-js');
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        paper:    '#F3ECE0',
                        'paper-2':'#EAE1D2',
                        ink:      '#0A0A0A',
                        accent:   '#FF5500',
                        'accent-2':'#FF8A1F',
                        muted:    '#6E655B',
                    },
                    fontFamily: {
                        sans:  ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        display:['"Space Grotesk"', 'system-ui', 'sans-serif'],
                        serif: ['"Instrument Serif"', 'serif'],
                        mono:  ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --paper: #F3ECE0;
            --paper-2: #EAE1D2;
            --ink: #0A0A0A;
            --accent: #FF5500;
            --accent-2: #FF8A1F;
            --muted: #6E655B;
        }

        html { background: var(--paper); }
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: var(--paper);
            color: var(--ink);
            overflow-x: hidden;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 9990;
            pointer-events: none;
            opacity: 0.07;
            mix-blend-mode: multiply;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        }

        .dotgrid {
            background-image: radial-gradient(circle, rgba(10,10,10,0.09) 1px, transparent 1px);
            background-size: 22px 22px;
        }

        #slashCanvas {
            position: fixed;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            mix-blend-mode: multiply;
        }

        .cursor-dot, .cursor-ring {
            position: fixed;
            top: 0; left: 0;
            pointer-events: none;
            z-index: 9999;
            will-change: transform;
            border-radius: 50%;
        }
        .cursor-dot {
            width: 6px; height: 6px;
            background: var(--ink);
            transform: translate(-50%, -50%);
        }
        .cursor-ring {
            width: 32px; height: 32px;
            border: 1.5px solid rgba(10, 10, 10, 0.5);
            transform: translate(-50%, -50%);
            transition: width 0.35s cubic-bezier(0.16,1,0.3,1),
                        height 0.35s cubic-bezier(0.16,1,0.3,1),
                        border-color 0.35s, background 0.35s;
        }
        .cursor-ring.is-hover {
            width: 56px; height: 56px;
            background: var(--accent);
            border-color: var(--accent);
            mix-blend-mode: multiply;
        }
        @media (hover: none) {
            .cursor-dot, .cursor-ring { display: none; }
        }

        /* ============ TYPING CURSOR ============ */
        .typing-cursor {
            display: inline-block;
            width: 0.55em;
            height: 0.82em;
            background: var(--accent);
            margin-left: 0.08em;
            vertical-align: -0.08em;
            animation: cursorBlink 0.95s steps(2, start) infinite;
            transition: opacity 0.45s ease;
            border-radius: 1px;
        }
        .typing-cursor.is-done {
            animation: none;
            opacity: 0;
        }
        @keyframes cursorBlink {
            50% { opacity: 0; }
        }

        header {
            background: var(--paper);
            border-bottom: 1.5px solid var(--ink);
            transition: transform 0.45s cubic-bezier(0.16,1,0.3,1);
        }
        header.is-hidden { transform: translateY(-100%); }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--ink);
            color: var(--paper);
            border: 1.5px solid var(--ink);
            box-shadow: 4px 4px 0 var(--accent);
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.2s ease, color 0.2s ease;
        }
        .btn-primary:hover {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0 var(--accent);
            background: var(--accent);
            color: var(--ink);
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: transparent;
            color: var(--ink);
            border: 1.5px solid var(--ink);
            transition: background 0.2s ease, color 0.2s ease;
        }
        .btn-ghost:hover { background: var(--ink); color: var(--paper); }

        .card {
            background: var(--paper);
            border: 1.5px solid var(--ink);
            box-shadow: 4px 4px 0 var(--ink);
            transition: transform 0.3s cubic-bezier(0.16,1,0.3,1),
                        box-shadow 0.3s cubic-bezier(0.16,1,0.3,1);
        }
        .card:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0 var(--accent);
        }
        .card-accent { box-shadow: 5px 5px 0 var(--accent); }
        .card-accent:hover { box-shadow: 7px 7px 0 var(--ink); }

        .sticker {
            display: inline-block;
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 5px 10px;
            background: var(--accent);
            color: var(--ink);
            border: 1.5px solid var(--ink);
            box-shadow: 2px 2px 0 var(--ink);
        }
        .sticker-cream { background: var(--paper); color: var(--ink); }

        .mono-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .tape { position: relative; }
        .tape::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%) rotate(-2deg);
            width: 64px;
            height: 20px;
            background: rgba(255, 222, 89, 0.75);
            border: 1px solid rgba(10, 10, 10, 0.15);
            z-index: 1;
        }

        .pinned {
            transform: rotate(var(--r, -0.5deg));
            transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
        }
        .pinned:hover {
            transform: rotate(0deg) translateY(-4px);
            box-shadow: 6px 6px 0 var(--accent);
        }

        .marquee { overflow: hidden; position: relative; }
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marquee 60s linear infinite;
        }
        .marquee:hover .marquee-track { animation-play-state: paused; }
        @keyframes marquee {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }

        .pulse-dot {
            position: relative;
            display: inline-block;
            width: 7px; height: 7px;
            background: var(--accent);
            border-radius: 50%;
            border: 1.5px solid var(--ink);
        }
        .pulse-dot::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: var(--accent);
            opacity: 0.55;
            animation: pulse 2s cubic-bezier(0.16,1,0.3,1) infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.5); opacity: 0.7; }
            100% { transform: scale(2.4); opacity: 0; }
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.85s cubic-bezier(0.16,1,0.3,1),
                        transform 0.85s cubic-bezier(0.16,1,0.3,1);
        }
        .reveal.is-shown { opacity: 1; transform: translateY(0); }
        .no-js .reveal { opacity: 1; transform: none; }

        .hero-item {
            opacity: 0;
            transform: translateY(18px);
            animation: heroIn 0.9s cubic-bezier(0.16,1,0.3,1) forwards;
        }
        .hero-item:nth-child(1) { animation-delay: 0.05s; }
        .hero-item:nth-child(2) { animation-delay: 0.15s; }
        .hero-item:nth-child(3) { animation-delay: 0.25s; }
        .hero-item:nth-child(4) { animation-delay: 0.35s; }
        @keyframes heroIn { to { opacity: 1; transform: translateY(0); } }

        .scribble path {
            stroke-dasharray: 340;
            stroke-dashoffset: 340;
            animation: scribble 1.6s 0.6s cubic-bezier(0.16,1,0.3,1) forwards;
        }
        @keyframes scribble { to { stroke-dashoffset: 0; } }

        .chip {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.04em;
            padding: 6px 14px;
            border: 1.5px solid var(--ink);
            background: var(--paper);
            color: var(--ink);
            transition: all 0.2s;
        }
        .chip:hover { background: var(--ink); color: var(--paper); }
        .chip.is-active { background: var(--ink); color: var(--paper); }

        .wordmark {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: clamp(100px, 24vw, 380px);
            letter-spacing: -0.055em;
            line-height: 0.8;
            color: transparent;
            -webkit-text-stroke: 1.5px rgba(243, 236, 224, 0.22);
            user-select: none;
        }

        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: var(--paper-2); }
        ::-webkit-scrollbar-thumb { background: var(--ink); }
        ::-webkit-scrollbar-thumb:hover { background: var(--accent); }

        ::selection { background: var(--accent); color: var(--ink); }

        h1, h2, h3 { text-wrap: balance; }

        .asterisk {
            display: inline-block;
            color: var(--accent);
            transition: transform 0.6s cubic-bezier(0.16,1,0.3,1);
        }
        .group:hover .asterisk { transform: rotate(90deg); }

        /* Typing slot: invisible placeholder reserves width so layout doesn't shift */
        .type-slot {
            position: relative;
            display: inline-block;
        }
        .type-slot > .type-ghost { visibility: hidden; }
        .type-slot > .type-live {
            position: absolute;
            left: 0; top: 0;
            white-space: nowrap;
        }
        /* For long headings that wrap on mobile */
        .type-slot.is-block { display: block; }
        .type-slot.is-block > .type-live { right: 0; white-space: normal; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            .reveal { opacity: 1; transform: none; }
            .typing-cursor { display: none; }
        }
    </style>
</head>

<body class="relative min-h-screen bg-paper text-ink font-sans overflow-x-hidden">

    <div class="cursor-dot" aria-hidden="true"></div>
    <div class="cursor-ring" aria-hidden="true"></div>

    <canvas id="slashCanvas" aria-hidden="true"></canvas>

    <!-- HEADER -->
    <header class="fixed top-0 inset-x-0 z-50">
        <div class="max-w-7xl mx-auto px-5 lg:px-10 h-16 flex items-center justify-between">

            <a href="index.php" class="group flex items-center gap-1" aria-label="Kabarsih beranda">
                <span class="font-display text-xl font-bold tracking-tight">kabarsih</span>
                <span class="asterisk font-display text-2xl leading-none font-bold">✱</span>
            </a>

            <nav class="hidden md:flex items-center gap-8 font-mono text-[11px] font-medium uppercase tracking-[0.1em]">
                <a href="#berita" class="hover:text-accent transition-colors">berita</a>
                <a href="#aspirasi" class="hover:text-accent transition-colors">aspirasi</a>
                <a href="#kategori" class="hover:text-accent transition-colors">kategori</a>
            </nav>

            <a href="auth/login.php" class="btn-primary px-4 py-2 text-[11px] font-bold uppercase tracking-[0.12em] rounded-sm">
                masuk akun
            </a>
        </div>
    </header>

    <!-- MAIN -->
    <main class="relative z-10 pt-24">

        <!-- HERO -->
        <section class="relative max-w-7xl mx-auto px-5 lg:px-10 pb-16 dotgrid">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-end pt-8">

                <div class="lg:col-span-7 space-y-7">
                    <div class="hero-item inline-flex items-center gap-2.5 font-mono text-[11px] font-medium uppercase tracking-[0.14em] text-ink/70 whitespace-nowrap">
                        <span class="pulse-dot"></span>
                        <span class="type-slot" data-type-now="portal suara warga fisip" data-delay="700">
                            <span class="type-ghost" aria-hidden="true">portal suara warga fisip</span>
                            <span class="type-live" aria-hidden="true"></span>
                            <span class="sr-only">portal suara warga fisip</span>
                        </span>
                        <span class="text-ink/30">—</span>
                        <span class="text-accent">est. 2023</span>
                    </div>

                    <h1 class="hero-item font-display text-[clamp(2.75rem,8vw,6.5rem)] font-bold tracking-[-0.04em] leading-[0.92]">
                        Suara
                        <span class="relative inline-block">
                            <span class="relative z-10">Kritis.</span>
                            <svg class="scribble absolute -inset-x-3 -inset-y-1 w-[calc(100%+1.5rem)] h-[calc(100%+0.5rem)] pointer-events-none" viewBox="0 0 200 60" preserveAspectRatio="none" fill="none">
                                <path d="M8 30 Q 20 12 50 10 T 108 14 T 165 10 T 192 30 T 160 50 T 90 52 T 22 48 T 8 30"
                                      stroke="var(--accent)" stroke-width="2.5" stroke-linecap="round"/>
                            </svg>
                        </span><br>
                        <span class="serif-italic text-[0.88em] font-normal text-ink/55 type-slot" data-type-now="kabar terbuka." data-delay="1500">
                            <span class="type-ghost" aria-hidden="true">kabar terbuka.</span>
                            <span class="type-live" aria-hidden="true"></span>
                            <span class="sr-only">kabar terbuka.</span>
                        </span>
                    </h1>

                    <p class="hero-item max-w-lg text-[15px] sm:text-base leading-relaxed text-ink/70 font-medium">
                        Tempat warga FISIP nyalurin aspirasi &amp; baca kabar kampus.
                        <strong class="text-ink font-semibold">Anonim? Bisa.</strong>
                        <strong class="text-ink font-semibold">Kritis? Wajib.</strong>
                        Nggak ada yang perlu takut.
                    </p>

                    <div class="hero-item flex flex-wrap items-center gap-3 pt-1">
                        <a href="#aspirasi" class="btn-primary px-6 py-3 rounded-sm text-[13px] font-bold uppercase tracking-[0.08em]">
                            <span>gas kirim aspirasi</span>
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </a>
                        <a href="#berita" class="btn-ghost px-6 py-3 rounded-sm text-[13px] font-bold uppercase tracking-[0.08em]">
                            cek isu kampus
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5 flex justify-start lg:justify-end relative">
                    <svg class="hidden lg:block absolute -left-14 top-8 w-16 h-16 text-ink/60 rotate-[180deg]" viewBox="0 0 60 60" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M8 30 C 20 8, 42 18, 52 42 M 42 40 L 52 42 L 50 32"/>
                    </svg>

                    <article class="card card-accent tape tilt-1 relative w-full max-w-sm rounded-sm p-6 sm:p-7 bg-paper">
                        <div class="flex items-center justify-between mb-5">
                            <span class="sticker">sorotan</span>
                            <span class="font-mono text-[10px] uppercase tracking-wider text-ink/45">30/10/26</span>
                        </div>

                        <h3 class="font-display text-[22px] font-bold leading-[1.15] tracking-tight mb-2 type-slot is-block" data-type-on-view="Evaluasi Fasilitas &amp; Jam Operasional Perpus FISIP" data-delay="900">
                            <span class="type-ghost" aria-hidden="true">Evaluasi Fasilitas &amp; Jam Operasional Perpus FISIP</span>
                            <span class="type-live" aria-hidden="true"></span>
                            <span class="sr-only">Evaluasi Fasilitas &amp; Jam Operasional Perpus FISIP</span>
                        </h3>

                        <p class="text-[12.5px] leading-relaxed text-ink/65 mb-5">
                            Tanggapan resmi Dekanat soal usulan perpanjangan akses fasilitas belajar plus penambahan ruang diskusi.
                        </p>

                        <div class="flex items-center justify-between pt-4 border-t border-ink/15">
                            <span class="font-mono text-[10px] uppercase tracking-wider text-ink/55">#fasilitas</span>
                            <a href="#berita" class="font-mono text-[10px] font-semibold uppercase tracking-wider text-accent hover:text-ink transition-colors inline-flex items-center gap-1">
                                baca detail →
                            </a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- MARQUEE -->
        <section class="bg-ink text-paper border-y-[1.5px] border-ink overflow-hidden">
            <div class="marquee py-3.5">
                <div class="marquee-track gap-8 font-display font-medium text-[15px] tracking-tight">
                    <span class="flex items-center gap-3"><span class="text-accent">✱</span> warga fisip</span>
                    <span class="text-accent">·</span>
                    <span>kritis tanpa takut</span>
                    <span class="text-accent">·</span>
                    <span class="flex items-center gap-3"><span class="text-accent">✱</span> anonim aman</span>
                    <span class="text-accent">·</span>
                    <span>no cap, real talk</span>
                    <span class="text-accent">·</span>
                    <span class="flex items-center gap-3"><span class="text-accent">✱</span> suara lo didengerin</span>
                    <span class="text-accent">·</span>
                    <span>aspirasi 24/7</span>
                    <span class="text-accent">·</span>
                    <span class="flex items-center gap-3"><span class="text-accent">✱</span> warga fisip</span>
                    <span class="text-accent">·</span>
                    <span>kritis tanpa takut</span>
                    <span class="text-accent">·</span>
                    <span class="flex items-center gap-3"><span class="text-accent">✱</span> anonim aman</span>
                    <span class="text-accent">·</span>
                    <span>no cap, real talk</span>
                    <span class="text-accent">·</span>
                    <span class="flex items-center gap-3"><span class="text-accent">✱</span> suara lo didengerin</span>
                    <span class="text-accent">·</span>
                    <span>aspirasi 24/7</span>
                    <span class="text-accent">·</span>
                </div>
            </div>
        </section>

        <!-- STATS -->
        <section class="max-w-7xl mx-auto px-5 lg:px-10 py-14">
            <div class="reveal relative bg-ink text-paper rounded-sm border-[1.5px] border-ink shadow-[6px_6px_0_var(--accent)] tilt-2 px-6 sm:px-10 py-8">
                <div class="flex items-center justify-between mb-6">
                    <span class="font-mono text-[10px] uppercase tracking-[0.18em] text-paper/55">manifesto singkat</span>
                    <span class="font-mono text-[10px] uppercase tracking-wider text-accent">06/11/26</span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-4">
                    <div>
                        <div class="font-display text-4xl md:text-5xl font-bold tracking-tight stat-num" data-count="248">0</div>
                        <div class="font-mono text-[10px] uppercase tracking-wider text-paper/50 mt-2">aspirasi masuk</div>
                    </div>
                    <div>
                        <div class="font-display text-4xl md:text-5xl font-bold tracking-tight stat-num" data-count="193">0</div>
                        <div class="font-mono text-[10px] uppercase tracking-wider text-paper/50 mt-2">udah ditindak</div>
                    </div>
                    <div>
                        <div class="font-display text-4xl md:text-5xl font-bold tracking-tight stat-num" data-count="14">0</div>
                        <div class="font-mono text-[10px] uppercase tracking-wider text-paper/50 mt-2">kategori isu</div>
                    </div>
                    <div>
                        <div class="font-display text-4xl md:text-5xl font-bold tracking-tight">
                            <span class="stat-num" data-count="3">0</span><span class="text-accent">h</span>
                        </div>
                        <div class="font-mono text-[10px] uppercase tracking-wider text-paper/50 mt-2">rata-rata respons</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- BERITA -->
        <section id="berita" class="max-w-7xl mx-auto px-5 lg:px-10 pb-20">
            <div class="reveal flex flex-col md:flex-row justify-between items-start md:items-end pb-5 mb-8 border-b-[1.5px] border-ink gap-5">
                <div class="space-y-2">
                    <div class="mono-label flex items-center gap-2">
                        <span class="text-accent">✱</span> publikasi resmi
                    </div>
                    <h2 class="font-display text-3xl sm:text-4xl md:text-5xl font-bold tracking-[-0.03em] leading-[0.95]">
                        Kabar kilat
                        <span class="serif-italic text-ink/45 type-slot" data-type-on-view="fisip." data-delay="150">
                            <span class="type-ghost" aria-hidden="true">fisip.</span>
                            <span class="type-live" aria-hidden="true"></span>
                            <span class="sr-only">fisip.</span>
                        </span>
                    </h2>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button class="chip is-active rounded-sm">semua</button>
                    <button class="chip rounded-sm">akademik</button>
                    <button class="chip rounded-sm">fasilitas</button>
                    <button class="chip rounded-sm">isu sosial</button>
                </div>
            </div>

            <div class="reveal-group grid grid-cols-1 md:grid-cols-3 gap-6">
                <article class="reveal card rounded-sm p-6 flex flex-col justify-between min-h-[260px] group">
                    <div class="flex items-start justify-between mb-5">
                        <span class="font-display text-3xl font-bold text-ink/30 group-hover:text-accent transition-colors leading-none">01</span>
                        <span class="sticker sticker-cream">akademik</span>
                    </div>
                    <div class="space-y-2.5">
                        <h3 class="font-display text-[18px] font-bold leading-[1.25] tracking-tight group-hover:text-accent transition-colors">
                            Jadwal UAS Genap udah rilis
                        </h3>
                        <p class="text-[12.5px] leading-relaxed text-ink/60 line-clamp-3">
                            Tata tertib + jadwal resmi udah didistribusiin sekjur buat semua mahasiswa FISIP. Cek jadwal lo sebelum telat.
                        </p>
                    </div>
                    <div class="flex items-center justify-between mt-5 pt-4 border-t border-ink/15">
                        <span class="font-mono text-[10px] uppercase tracking-wider text-ink/45">28/10/26</span>
                        <svg class="w-4 h-4 text-ink/50 group-hover:text-accent group-hover:translate-x-0.5 transition-all" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </div>
                </article>

                <article class="reveal card rounded-sm p-6 flex flex-col justify-between min-h-[260px] group">
                    <div class="flex items-start justify-between mb-5">
                        <span class="font-display text-3xl font-bold text-ink/30 group-hover:text-accent transition-colors leading-none">02</span>
                        <span class="sticker sticker-cream">fasilitas</span>
                    </div>
                    <div class="space-y-2.5">
                        <h3 class="font-display text-[18px] font-bold leading-[1.25] tracking-tight group-hover:text-accent transition-colors">
                            Wi-Fi gedung B udah beres
                        </h3>
                        <p class="text-[12.5px] leading-relaxed text-ink/60 line-clamp-3">
                            Kuota titik akses Wi-Fi di selasar gedung kuliah udah ditingkat. Nugas di kampus nggak bakal patah-patah lagi.
                        </p>
                    </div>
                    <div class="flex items-center justify-between mt-5 pt-4 border-t border-ink/15">
                        <span class="font-mono text-[10px] uppercase tracking-wider text-ink/45">25/10/26</span>
                        <svg class="w-4 h-4 text-ink/50 group-hover:text-accent group-hover:translate-x-0.5 transition-all" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </div>
                </article>

                <article class="reveal card rounded-sm p-6 flex flex-col justify-between min-h-[260px] group">
                    <div class="flex items-start justify-between mb-5">
                        <span class="font-display text-3xl font-bold text-ink/30 group-hover:text-accent transition-colors leading-none">03</span>
                        <span class="sticker sticker-cream">isu sosial</span>
                    </div>
                    <div class="space-y-2.5">
                        <h3 class="font-display text-[18px] font-bold leading-[1.25] tracking-tight group-hover:text-accent transition-colors">
                            Forum kebebasan berpendapat
                        </h3>
                        <p class="text-[12.5px] leading-relaxed text-ink/60 line-clamp-3">
                            Hasil bahasan bareng Lembaga Kemahasiswaan FISIP soal jaminan ruang aspirasi yang aman tanpa rasa takut.
                        </p>
                    </div>
                    <div class="flex items-center justify-between mt-5 pt-4 border-t border-ink/15">
                        <span class="font-mono text-[10px] uppercase tracking-wider text-ink/45">22/10/26</span>
                        <svg class="w-4 h-4 text-ink/50 group-hover:text-accent group-hover:translate-x-0.5 transition-all" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </div>
                </article>
            </div>
        </section>

        <!-- ASPIRASI -->
        <section id="aspirasi" class="bg-paper-2 border-y-[1.5px] border-ink">
            <div class="max-w-7xl mx-auto px-5 lg:px-10 py-16">
                <div class="reveal flex flex-col md:flex-row justify-between items-start md:items-end pb-5 mb-8 border-b-[1.5px] border-ink/20 gap-5">
                    <div class="space-y-2">
                        <div class="mono-label flex items-center gap-2">
                            <span class="text-accent">✱</span> curhat &amp; aduan
                        </div>
                        <h2 class="font-display text-3xl sm:text-4xl md:text-5xl font-bold tracking-[-0.03em] leading-[0.95]">
                            Suara yang
                            <span class="serif-italic text-ink/45 type-slot" data-type-on-view="udah masuk." data-delay="150">
                                <span class="type-ghost" aria-hidden="true">udah masuk.</span>
                                <span class="type-live" aria-hidden="true"></span>
                                <span class="sr-only">udah masuk.</span>
                            </span>
                        </h2>
                    </div>
                    <a href="auth/login.php" class="btn-primary px-5 py-3 rounded-sm text-[12px] font-bold uppercase tracking-[0.1em]">
                        + bikin laporan
                    </a>
                </div>

                <div class="reveal-group grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="reveal pinned card rounded-sm p-5 sm:p-6 tape bg-paper group" style="--r: -0.9deg;">
                        <div class="flex items-center gap-3 flex-wrap mb-3">
                            <span class="font-mono text-[10px] font-semibold uppercase tracking-wider px-2 py-1 bg-emerald-100 text-emerald-800 border-[1.5px] border-emerald-900/70 rounded-sm">selesai</span>
                            <span class="font-mono text-[10px] uppercase tracking-wider text-ink/45">pengirim · <strong class="text-ink/75 font-semibold normal-case">anonim</strong></span>
                        </div>
                        <h4 class="font-display text-[17px] font-bold leading-snug tracking-tight mb-2 group-hover:text-accent transition-colors">
                            Lampu parkir belakang mati, gelap banget
                        </h4>
                        <p class="text-[12.5px] leading-relaxed text-ink/60 mb-4">
                            Beberapa titik lampu penerangan mati, jadi parkir motor malam-malam agak was-was. Minta tolong dicek.
                        </p>
                        <a href="#" class="font-mono text-[10px] font-semibold uppercase tracking-wider text-accent hover:text-ink transition-colors inline-flex items-center gap-1">
                            tinjau diskusi →
                        </a>
                    </div>

                    <div class="reveal pinned card rounded-sm p-5 sm:p-6 tape bg-paper group" style="--r: 0.7deg;">
                        <div class="flex items-center gap-3 flex-wrap mb-3">
                            <span class="font-mono text-[10px] font-semibold uppercase tracking-wider px-2 py-1 bg-amber-100 text-amber-900 border-[1.5px] border-amber-900/70 rounded-sm">ditinjau</span>
                            <span class="font-mono text-[10px] uppercase tracking-wider text-ink/45">pengirim · <strong class="text-ink/75 font-semibold normal-case">mahasiswa fisip</strong></span>
                        </div>
                        <h4 class="font-display text-[17px] font-bold leading-snug tracking-tight mb-2 group-hover:text-accent transition-colors">
                            Stopkontak di gazebo kurang banyak
                        </h4>
                        <p class="text-[12.5px] leading-relaxed text-ink/60 mb-4">
                            Nugas kelompok di selasar luar sering rebutan colokan. Minta tambah stopkontak di gazebo kampus.
                        </p>
                        <a href="#" class="font-mono text-[10px] font-semibold uppercase tracking-wider text-accent hover:text-ink transition-colors inline-flex items-center gap-1">
                            tinjau diskusi →
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="relative z-10 bg-ink text-paper border-t-[1.5px] border-ink">
        <div class="max-w-7xl mx-auto px-5 lg:px-10 pt-12 pb-8">
            <div class="grid md:grid-cols-3 gap-8 mb-10">
                <div>
                    <div class="flex items-center gap-1 mb-3">
                        <span class="font-display text-lg font-bold tracking-tight">kabarsih</span>
                        <span class="text-accent font-display text-xl leading-none font-bold">✱</span>
                    </div>
                    <p class="text-[13px] text-paper/55 leading-relaxed max-w-xs">
                        Ruang bebas buat nyalurin aspirasi dan baca kabar kampus. Dikelola warga FISIP, buat warga FISIP.
                    </p>
                </div>
                <div>
                    <h4 class="font-mono text-[10px] uppercase tracking-[0.18em] text-paper/40 mb-4">navigasi</h4>
                    <ul class="space-y-2.5 text-[13px] font-medium">
                        <li><a href="#berita" class="text-paper/70 hover:text-accent transition-colors">berita</a></li>
                        <li><a href="#aspirasi" class="text-paper/70 hover:text-accent transition-colors">aspirasi</a></li>
                        <li><a href="#kategori" class="text-paper/70 hover:text-accent transition-colors">kategori</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-mono text-[10px] uppercase tracking-[0.18em] text-paper/40 mb-4">kontak</h4>
                    <ul class="space-y-2.5 text-[13px] font-medium text-paper/70">
                        <li>FISIP — Gedung A, Lt. 2</li>
                        <li>kabarsih@fisip.ac.id</li>
                        <li class="text-paper/45">jam operasional: 08.00–21.00</li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 border-t border-paper/10 flex flex-col md:flex-row justify-between items-start md:items-center gap-3 font-mono text-[10px] uppercase tracking-[0.14em] text-paper/35">
                <p>© 2026 kabarsih — dikelola lembaga kemahasiswaan fisip</p>
                <p>dibikin pakai <span class="text-accent">♥</span> sama anak fisip</p>
            </div>
        </div>

        <div class="overflow-hidden select-none pointer-events-none">
            <div class="wordmark text-center -mb-[2vw]">FISIP.</div>
        </div>
    </footer>

    <!-- ============================================================
         SCRIPT 1: SLASH CANVAS (orange ink) — unchanged from before
         ============================================================ -->
    <script>
        (function () {
            const canvas = document.getElementById('slashCanvas');
            const ctx = canvas.getContext('2d');
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                canvas.style.display = 'none'; return;
            }
            let dpr = Math.min(window.devicePixelRatio || 1, 2);
            function resize() {
                dpr = Math.min(window.devicePixelRatio || 1, 2);
                canvas.width  = innerWidth  * dpr;
                canvas.height = innerHeight * dpr;
                canvas.style.width  = innerWidth  + 'px';
                canvas.style.height = innerHeight + 'px';
                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            }
            addEventListener('resize', resize); resize();

            const slashes = [];
            let lastMouse = null;
            addEventListener('mousemove', e => {
                const cur = { x: e.clientX, y: e.clientY };
                if (lastMouse && slashes.length < 55) {
                    const dx = cur.x - lastMouse.x, dy = cur.y - lastMouse.y;
                    const dist = Math.hypot(dx, dy);
                    if (dist > 6) {
                        slashes.push({
                            x: cur.x, y: cur.y,
                            angle: Math.atan2(dy, dx),
                            length: Math.min(dist * 2.2, 120),
                            width: Math.random() * 22 + 14,
                            opacity: 0.92,
                        });
                    }
                }
                lastMouse = cur;
            });

            (function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (let i = slashes.length - 1; i >= 0; i--) {
                    const s = slashes[i];
                    ctx.save();
                    ctx.translate(s.x, s.y);
                    ctx.rotate(s.angle);
                    const g = ctx.createLinearGradient(-s.length/2 - 10, 0, s.length/2 + 20, 0);
                    g.addColorStop(0,   `rgba(255, 85, 0, ${s.opacity})`);
                    g.addColorStop(0.5, `rgba(255, 45, 0, ${s.opacity})`);
                    g.addColorStop(1,   `rgba(10, 10, 10, ${s.opacity * 0.6})`);
                    ctx.fillStyle = g;
                    ctx.beginPath();
                    ctx.moveTo(-s.length/2,     -s.width/2);
                    ctx.lineTo( s.length/2,     -s.width/4);
                    ctx.lineTo( s.length/2 + 18, s.width/2);
                    ctx.lineTo(-s.length/2 - 8,  s.width/3);
                    ctx.closePath();
                    ctx.fill();
                    ctx.restore();
                    s.opacity -= 0.045;
                    s.length  += 2.4;
                    s.width   *= 0.965;
                    if (s.opacity <= 0) slashes.splice(i, 1);
                }
                requestAnimationFrame(draw);
            })();
        })();
    </script>

    <!-- ============================================================
         SCRIPT 2: REVEAL + STAGGER
         ============================================================ -->
    <script>
        (function () {
            if (!('IntersectionObserver' in window)) {
                document.querySelectorAll('.reveal').forEach(el => el.classList.add('is-shown'));
                return;
            }
            const obs = new IntersectionObserver((entries) => {
                entries.forEach(en => {
                    if (en.isIntersecting) en.target.classList.add('is-shown');
                    else en.target.classList.remove('is-shown');
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

            document.querySelectorAll('.reveal-group').forEach(g => {
                g.querySelectorAll('.reveal').forEach((el, i) => {
                    el.style.transitionDelay = `${i * 90}ms`;
                });
            });
            document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
        })();
    </script>

    <!-- ============================================================
         SCRIPT 3: TYPEWRITER
         ============================================================ -->
    <script>
        (function () {
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            function createCursor() {
                const c = document.createElement('span');
                c.className = 'typing-cursor';
                c.setAttribute('aria-hidden', 'true');
                return c;
            }

            function typeText(liveEl, text, opts) {
                opts = opts || {};
                const speed = opts.speed || 40;
                const delay = opts.delay || 0;

                if (liveEl.dataset.typed === '1') return;
                liveEl.dataset.typed = '1';

                // Reduced motion: skip animation, just render
                if (reduceMotion) {
                    liveEl.textContent = text;
                    return;
                }

                // Clear and attach cursor
                liveEl.textContent = '';
                const cursor = createCursor();
                liveEl.appendChild(cursor);

                setTimeout(function () {
                    let i = 0;
                    function tick() {
                        if (i < text.length) {
                            const ch = text[i];
                            cursor.before(document.createTextNode(ch));
                            i++;
                            // Slower after punctuation, slightly jittered speed
                            let wait = speed;
                            if (/[.,!?]/.test(ch))          wait = speed * 6;
                            else if (/[\s]/.test(ch))       wait = speed * 0.65;
                            else                            wait = speed + Math.random() * 18;
                            setTimeout(tick, wait);
                        } else {
                            // Done typing: keep cursor blinking briefly then fade
                            setTimeout(function () {
                                cursor.classList.add('is-done');
                                setTimeout(function () { cursor.remove(); }, 500);
                            }, 550);
                        }
                    }
                    tick();
                }, delay);
            }

            // ---- Immediate typers (hero) ----
            document.querySelectorAll('.type-slot[data-type-now]').forEach(function (slot) {
                const live = slot.querySelector('.type-live');
                if (!live) return;
                const text = slot.getAttribute('data-type-now');
                const delay = parseInt(slot.getAttribute('data-delay') || '0', 10);
                typeText(live, text, { delay: delay, speed: 38 });
            });

            // ---- On-view typers ----
            const onViewSlots = document.querySelectorAll('.type-slot[data-type-on-view]');
            if (!onViewSlots.length) return;

            if (!('IntersectionObserver' in window) || reduceMotion) {
                onViewSlots.forEach(function (slot) {
                    const live = slot.querySelector('.type-live');
                    if (live) live.textContent = slot.getAttribute('data-type-on-view');
                });
                return;
            }

            const obs = new IntersectionObserver(function (entries) {
                entries.forEach(function (en) {
                    if (!en.isIntersecting) return;
                    const slot = en.target;
                    const live = slot.querySelector('.type-live');
                    if (!live) return;
                    const text = slot.getAttribute('data-type-on-view');
                    const delay = parseInt(slot.getAttribute('data-delay') || '150', 10);
                    // Featured card is large — slightly slower, more deliberate
                    const isBig = text.length > 24;
                    typeText(live, text, {
                        delay: delay,
                        speed: isBig ? 34 : 42,
                    });
                    obs.unobserve(slot);
                });
            }, { threshold: 0.35, rootMargin: '0px 0px -40px 0px' });

            onViewSlots.forEach(function (slot) { obs.observe(slot); });
        })();
    </script>

    <!-- ============================================================
         SCRIPT 4: CURSOR + MAGNETIC
         ============================================================ -->
    <script>
        (function () {
            if (window.matchMedia('(hover: none)').matches) return;

            const dot = document.querySelector('.cursor-dot');
            const ring = document.querySelector('.cursor-ring');
            let mx = innerWidth / 2, my = innerHeight / 2;
            let rx = mx, ry = my, dx0 = mx, dy0 = my;

            addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; });
            const lerp = (a, b, n) => a + (b - a) * n;

            (function loop() {
                dx0 = lerp(dx0, mx, 0.4);
                dy0 = lerp(dy0, my, 0.4);
                rx  = lerp(rx,  mx, 0.16);
                ry  = lerp(ry,  my, 0.16);
                dot.style.transform  = `translate(${dx0}px, ${dy0}px) translate(-50%,-50%)`;
                ring.style.transform = `translate(${rx}px, ${ry}px) translate(-50%,-50%)`;
                requestAnimationFrame(loop);
            })();

            document.querySelectorAll('a, button, .card, .chip, .sticker').forEach(el => {
                el.addEventListener('mouseenter', () => ring.classList.add('is-hover'));
                el.addEventListener('mouseleave', () => ring.classList.remove('is-hover'));
            });

            document.querySelectorAll('.btn-primary, .btn-ghost').forEach(btn => {
                btn.addEventListener('mousemove', e => {
                    const r = btn.getBoundingClientRect();
                    const x = (e.clientX - r.left - r.width / 2) * 0.15;
                    const y = (e.clientY - r.top - r.height / 2) * 0.15;
                    btn.style.transform = `translate(${x}px, ${y}px)`;
                });
                btn.addEventListener('mouseleave', () => { btn.style.transform = ''; });
            });
        })();
    </script>

    <!-- ============================================================
         SCRIPT 5: NAVBAR SCROLL + COUNTERS
         ============================================================ -->
    <script>
        (function () {
            const header = document.querySelector('header');
            let lastY = scrollY;
            addEventListener('scroll', () => {
                const y = scrollY;
                if (y > 100 && y > lastY + 4) header.classList.add('is-hidden');
                else if (y < lastY - 4 || y < 80) header.classList.remove('is-hidden');
                lastY = y;
            }, { passive: true });

            const counters = document.querySelectorAll('[data-count]');
            if (!counters.length || !('IntersectionObserver' in window)) return;

            function run(el) {
                const target = parseInt(el.dataset.count, 10);
                const dur = 1400;
                const start = performance.now();
                (function tick(now) {
                    const p = Math.min((now - start) / dur, 1);
                    const e = 1 - Math.pow(1 - p, 3);
                    el.textContent = Math.round(target * e).toLocaleString('id-ID');
                    if (p < 1) requestAnimationFrame(tick);
                })(start);
            }

            const obs = new IntersectionObserver((entries) => {
                entries.forEach(en => {
                    if (en.isIntersecting) { run(en.target); obs.unobserve(en.target); }
                });
            }, { threshold: 0.55 });
            counters.forEach(c => obs.observe(c));
        })();
    </script>

</body>
</html>