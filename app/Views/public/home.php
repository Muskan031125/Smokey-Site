<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>
<?php
$loggedIn = auth()->loggedIn();
// For guests: all internal navigation redirects to login
$L = fn(string $path) => $loggedIn ? site_url($path) : site_url('login');
?>

<!-- ═══════════ HERO ═══════════ -->
<section style="position:relative;min-height:92vh;display:flex;align-items:center;overflow:hidden;background:var(--bg);">
    <video class="hero-video" autoplay muted loop playsinline preload="auto"
           poster="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=1920&q=80">
        <source src="https://videos.pexels.com/video-files/4259291/4259291-uhd_2560_1440_24fps.mp4" type="video/mp4">
        <source src="https://videos.pexels.com/video-files/8313897/8313897-uhd_2560_1440_25fps.mp4" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="gold-orb" style="top:20%;left:12%;animation-delay:0s;"></div>
    <div class="gold-orb" style="top:35%;right:8%;animation-delay:2s;width:8px;height:8px;"></div>
    <div class="gold-orb" style="bottom:25%;left:18%;animation-delay:4s;width:5px;height:5px;"></div>
    <div class="gold-orb" style="top:55%;right:22%;animation-delay:1s;width:7px;height:7px;"></div>
    <div class="smoke-particle" style="bottom:0;left:15%;animation-delay:0s;"></div>
    <div class="smoke-particle" style="bottom:0;left:45%;animation-delay:3s;"></div>
    <div class="smoke-particle" style="bottom:0;left:75%;animation-delay:6s;"></div>
    <div style="position:absolute;top:50%;left:8%;transform:translateY(-50%);width:1px;height:40%;background:linear-gradient(to bottom,transparent,rgba(212,168,73,.4),transparent);"></div>
    <div style="position:absolute;top:50%;right:8%;transform:translateY(-50%);width:1px;height:40%;background:linear-gradient(to bottom,transparent,rgba(212,168,73,.4),transparent);"></div>
    <div style="position:absolute;top:20%;left:-10%;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(212,168,73,.15),transparent 70%);filter:blur(60px);pointer-events:none;"></div>
    <div style="position:absolute;bottom:10%;right:-10%;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(196,125,74,.1),transparent 70%);filter:blur(80px);pointer-events:none;"></div>

    <div style="position:relative;max-width:1440px;margin:0 auto;padding:5rem 1.5rem;width:100%;z-index:5;text-align:center;">
        <p class="section-subtitle" style="margin-bottom:1.5rem;animation:fadeUp .8s ease both;">✦ Premium Barware & Cocktail Essentials ✦</p>
        <h1 class="font-serif glow-text" style="font-size:clamp(2.8rem,7vw,6rem);font-weight:300;color:var(--text);line-height:1.05;margin-bottom:1.5rem;letter-spacing:-.02em;animation:fadeUp 1s .1s ease both;">
            <span id="hero-slide-title">Craft Your <em style="color:var(--gold-neon);font-style:italic;animation:glow 4s ease-in-out infinite;">Perfect Pour</em></span>
        </h1>
        <p style="color:var(--muted);font-size:1.05rem;max-width:560px;margin:0 auto 2.5rem;line-height:1.75;animation:fadeUp .8s .2s ease both;" id="hero-slide-sub">
            Handcrafted glassware, sculptural barware and cocktail tools for the discerning bartender.
        </p>
        <div style="display:flex;gap:1.25rem;justify-content:center;flex-wrap:wrap;animation:fadeUp .8s .3s ease both;">
            <?php if($loggedIn): ?>
            <a href="<?= site_url('shop') ?>" class="btn-neon" style="padding:1rem 2.75rem;font-size:.8rem;border-radius:50px;">Shop Collection</a>
            <a href="<?= site_url('new-arrivals') ?>" class="btn-outline-neon" style="padding:1rem 2.75rem;font-size:.8rem;border-radius:50px;">✦ New Arrivals</a>
            <?php else: ?>
            <a href="<?= site_url('login') ?>" class="btn-neon" style="padding:1rem 2.75rem;font-size:.8rem;border-radius:50px;">Login to Shop</a>
            <a href="<?= site_url('register') ?>" class="btn-outline-neon" style="padding:1rem 2.75rem;font-size:.8rem;border-radius:50px;">✦ Create Account</a>
            <?php endif; ?>
        </div>
        <div style="display:flex;gap:.625rem;justify-content:center;margin-top:3.5rem;animation:fadeUp .8s .5s ease both;" id="hero-dots">
            <?php foreach([0,1,2] as $di): ?>
            <button onclick="goSlide(<?= $di ?>)" id="dot-<?= $di ?>"
                    style="height:6px;border-radius:3px;border:none;cursor:pointer;transition:all .4s;
                           width:<?= $di===0?'40':'12' ?>px;background:<?= $di===0?'var(--gold-neon)':'rgba(255,217,102,.2)' ?>;
                           box-shadow:<?= $di===0?'0 0 15px rgba(255,217,102,.6)':'none' ?>;"></button>
            <?php endforeach; ?>
        </div>
        <div style="position:absolute;bottom:30px;left:50%;transform:translateX(-50%);animation:float 2s ease-in-out infinite;">
            <svg width="24" height="38" viewBox="0 0 24 38" fill="none" stroke="var(--gold-neon)" stroke-width="1.5"><rect x="2" y="2" width="20" height="34" rx="10"/><line x1="12" y1="8" x2="12" y2="16" stroke-linecap="round"/></svg>
        </div>
    </div>
</section>

<script>
const slides = [
    {title:'Craft Your <em style="color:var(--gold-neon);animation:glow 4s ease-in-out infinite">Perfect Pour</em>', sub:'Handcrafted glassware, sculptural barware and cocktail tools for the discerning bartender.'},
    {title:'Exclusive Elegance <em style="color:var(--gold-neon);animation:glow 4s ease-in-out infinite">Designs</em>', sub:'Sculptures, figurines and art pieces that transform every space into a statement.'},
    {title:'Top-notch Quality <em style="color:var(--gold-neon);animation:glow 4s ease-in-out infinite">Barware</em>', sub:'Elevate your home bar with our curated collection of premium glassware and tools.'},
];
let cur = 0;
function goSlide(n) {
    cur = n;
    document.getElementById('hero-slide-title').innerHTML = slides[n].title;
    document.getElementById('hero-slide-sub').textContent = slides[n].sub.replace(/<[^>]+>/g,'');
    slides.forEach((_,i) => {
        const d = document.getElementById('dot-'+i);
        if(d){ d.style.width=i===n?'40px':'12px'; d.style.background=i===n?'var(--gold-neon)':'rgba(255,217,102,.2)'; d.style.boxShadow=i===n?'0 0 15px rgba(255,217,102,.6)':'none'; }
    });
}
setInterval(() => goSlide((cur+1) % slides.length), 1500);
</script>

<!-- ═══════════ MARQUEE STRIP ═══════════ -->
<div style="background:linear-gradient(90deg,var(--bg-soft),#1a1410,var(--bg-soft));border-top:1px solid rgba(212,168,73,.2);border-bottom:1px solid rgba(212,168,73,.2);padding:.85rem 0;overflow:hidden;">
    <div style="display:flex;gap:3rem;animation:marquee 25s linear infinite;white-space:nowrap;">
        <?php for($i=0;$i<3;$i++): foreach(['✦ Whiskey Glasses','✦ Cocktail Glasses','✦ Premium Decanters','✦ Sculptures & Figurines','✦ Wine Glasses','✦ Beer Mugs','✦ Bar Accessories','✦ Tea & Coffee','✦ Shot Glasses','✦ Lights & Lamps','✦ Serveware','✦ Free Shipping ₹5,000+'] as $txt): ?>
        <span style="font-size:.85rem;color:var(--gold-neon);font-weight:600;letter-spacing:.12em;text-transform:uppercase;text-shadow:0 0 12px rgba(255,217,102,.3);"><?= $txt ?></span>
        <?php endforeach; endfor; ?>
    </div>
</div>
<style>@keyframes marquee{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}</style>

<!-- ═══════════ TRUST STRIP ═══════════ -->
<div style="background:var(--bg-soft);border-bottom:1px solid rgba(212,168,73,.15);padding:1.5rem 1.5rem;">
    <div style="max-width:1440px;margin:0 auto;display:flex;justify-content:space-around;flex-wrap:wrap;gap:1rem;">
        <?php foreach([
            ['<rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>','Free Shipping','Orders ₹5,000+'],
            ['<rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>','COD Available','Pay on delivery'],
            ['<polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/>','Easy Returns','7 days'],
            ['<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>','1L+ Customers','Trusted across India'],
        ] as $i=>[$svg,$h,$s]): ?>
        <div class="fade-up stagger-<?= $i+1 ?>" style="display:flex;align-items:center;gap:.75rem;">
            <div style="flex-shrink:0;width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:rgba(212,168,73,.1);border:1px solid rgba(212,168,73,.2);animation:icon-float <?= 5+$i ?>s ease-in-out infinite;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--gold-neon)" stroke-width="1.5"><?= $svg ?></svg>
            </div>
            <div><div style="font-size:.8rem;font-weight:700;color:var(--text);"><?= $h ?></div><div style="font-size:.7rem;color:var(--muted);"><?= $s ?></div></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ═══════════ CIRCULAR CATEGORIES ═══════════ -->
<section style="padding:5rem 1.5rem;background:var(--bg);position:relative;overflow:hidden;">
    <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:800px;height:200px;background:radial-gradient(ellipse,rgba(212,168,73,.1),transparent 70%);filter:blur(40px);pointer-events:none;"></div>
    <div style="max-width:1440px;margin:0 auto;text-align:center;position:relative;">
        <p class="section-subtitle fade-up" style="margin-bottom:.75rem;">Shop by Category</p>
        <h2 class="section-title fade-up" style="margin-bottom:.75rem;">Explore Our <em>Collections</em></h2>
        <div class="gold-line fade-up" style="margin:0 auto 3rem;"></div>
        <div style="display:flex;justify-content:center;flex-wrap:wrap;gap:1.75rem 2.25rem;">
            <?php
            // [label, path, svg, loginOnly] — loginOnly=true means hidden for guests
            $allCats = [
                ['Best Selling',    'best-sellers',              '<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>',                                                                                                                                                                                                                                                                                                           true],
                ['New Arrivals',    'new-arrivals',              '<line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/>',                                                 true],
                ['Whiskey Glasses', 'category/whi-glasses',     '<path d="M8 2l1 14h6l1-14H8z"/><line x1="10" y1="16" x2="10" y2="20"/><line x1="14" y1="16" x2="14" y2="20"/><line x1="8" y1="20" x2="16" y2="20"/>',                                                                                                                                                                                                                                                            false],
                ['Cocktail Glasses','category/cocktail-glass',  '<path d="M3 3l9 9 9-9H3z"/><line x1="12" y1="12" x2="12" y2="20"/><line x1="8" y1="20" x2="16" y2="20"/>',                                                                                                                                                                                                                                                                                                        false],
                ['Wine Glasses',    'category/wine-glasses',    '<path d="M6 2c0 5 6 8 6 12"/><path d="M18 2c0 5-6 8-6 12"/><line x1="12" y1="14" x2="12" y2="20"/><line x1="9" y1="20" x2="15" y2="20"/>',                                                                                                                                                                                                                                                                       false],
                ['Beer Mugs',       'category/beer-mug',        '<path d="M5 3h11a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/><path d="M18 8h2a2 2 0 0 1 0 4h-2"/><line x1="5" y1="8" x2="16" y2="8"/>',                                                                                                                                                                                                                                                 false],
                ['Shot Glasses',    'category/shot-glass',      '<path d="M7 3h10l-1 14H8L7 3z"/><line x1="10" y1="17" x2="10" y2="21"/><line x1="14" y1="17" x2="14" y2="21"/><line x1="8" y1="21" x2="16" y2="21"/>',                                                                                                                                                                                                                                                           false],
                ['Tall Glasses',    'category/tall-glass',      '<rect x="8" y="2" width="8" height="20" rx="3"/><line x1="8" y1="8" x2="16" y2="8"/>',                                                                                                                                                                                                                                                                                                                             false],
                ['Dessert Glasses', 'category/dessert',         '<path d="M6 3h12l-2 10H8L6 3z"/><path d="M8 13v5"/><path d="M16 13v5"/><line x1="6" y1="18" x2="18" y2="18"/>',                                                                                                                                                                                                                                                                                                   false],
                ['Decanters',       'category/decanter',        '<path d="M9 2h6v4l3 5v9a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-9l3-5V2z"/><line x1="6" y1="11" x2="18" y2="11"/>',                                                                                                                                                                                                                                                                                                       false],
                ['Bar Accessories', 'category/bar-accessories', '<rect x="8" y="2" width="8" height="6" rx="1"/><path d="M6 8h12l-2 12H8L6 8z"/><line x1="6" y1="12" x2="18" y2="12"/>',                                                                                                                                                                                                                                                                                           false],
                ['Ice Maker',       'category/ice-maker',       '<rect x="3" y="3" width="8" height="8" rx="1"/><rect x="13" y="3" width="8" height="8" rx="1"/><rect x="3" y="13" width="8" height="8" rx="1"/><rect x="13" y="13" width="8" height="8" rx="1"/>',                                                                                                                                                                                                                false],
                ['Juice & Water',   'category/water-juice-glass','<path d="M12 2L6 12h12L12 2z"/><path d="M6 12c0 4 2 8 6 8s6-4 6-8"/>',                                                                                                                                                                                                                                                                                                                                            false],
                ['Sculptures',      'category/sculpture',       '<circle cx="12" cy="5" r="3"/><path d="M12 8v4"/><path d="M8 16c0-3 2-5 4-4s4 1 4 4"/><line x1="8" y1="16" x2="16" y2="16"/><line x1="6" y1="22" x2="18" y2="22"/><line x1="8" y1="16" x2="6" y2="22"/><line x1="16" y1="16" x2="18" y2="22"/>',                                                                                                                                                               false],
                ['Centrepiece',     'category/centrepiece',     '<path d="M12 2c-4 0-7 3-7 7 0 3 2 6 5 7v4H9v2h6v-2h-1v-4c3-1 5-4 5-7 0-4-3-7-7-7z"/>',                                                                                                                                                                                                                                                                                                                            false],
                ['Lights & Lamps',  'category/lights',          '<path d="M9 18h6"/><path d="M10 22h4"/><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8a6 6 0 1 0-12 0c0 1.33.47 2.5 1.5 3.5.75.76 1.23 1.52 1.41 2.5"/>',                                                                                                                                                                                                                                     false],
                ['Humidifier',      'category/humidifier',      '<path d="M12 2v6"/><path d="M4.93 10.93l4.24 4.24"/><path d="M2 18h4"/><path d="M12 22v-2"/><path d="M19.07 10.93l-4.24 4.24"/><path d="M22 18h-4"/><path d="M12 10a5 5 0 0 1 5 5"/>',                                                                                                                                                                                                                           false],
                ['Vases & Planters','category/planters',        '<path d="M8 3h8l1 8H7L8 3z"/><path d="M7 11c0 5 2 8 5 9s5-4 5-9"/>',                                                                                                                                                                                                                                                                                                                                               false],
                ['Wall Art',        'category/wall-decor',      '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9l5-5 4 4 4-4 5 5"/><circle cx="7.5" cy="7.5" r="1.5"/>',                                                                                                                                                                                                                                                                                             false],
                ['Candles',         'category/candleware',      '<line x1="12" y1="2" x2="12" y2="5"/><path d="M9 5h6v15a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V5z"/><line x1="9" y1="11" x2="15" y2="11"/>',                                                                                                                                                                                                                                                                             false],
                ['Bath Accessories','category/bath-accessories', '<path d="M9 6L6 3v4"/><path d="M3 11h18v4a6 6 0 0 1-6 6H9a6 6 0 0 1-6-6v-4z"/>',                                                                                                                                                                                                                                                                                                                                 false],
                ['Tea & Coffee',    'category/tea-coffee',      '<path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/>',                                                                                                                                                                                                     false],
                ['Serveware',       'category/serveware',       '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/><line x1="12" y1="3" x2="12" y2="8"/>',                                                                                                                                                                                                                                                                                                              false],
                ['Trays & Platters','category/trays-platters',  '<rect x="2" y="7" width="20" height="10" rx="2"/><line x1="6" y1="12" x2="18" y2="12"/>',                                                                                                                                                                                                                                                                                                                          false],
            ];
            $ci = 0;
            foreach($allCats as [$label,$path,$svg,$loginOnly]):
                if(($loginOnly ?? false) && !$loggedIn) continue;
                $ci++;
            ?>
            <a href="<?= $L($path) ?>" class="fade-up stagger-<?= min(($ci%5)+1,5) ?>"
               style="text-decoration:none;text-align:center;display:flex;flex-direction:column;align-items:center;gap:.625rem;width:120px;">
                <div class="cat-circle" style="transition:transform .3s,box-shadow .3s;"
                     onmouseover="this.style.transform='translateY(-6px) scale(1.1)';this.style.boxShadow='0 14px 32px rgba(212,168,73,.4),0 0 0 3px rgba(212,168,73,.25)'"
                     onmouseout="this.style.transform='';this.style.boxShadow=''">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><?= $svg ?></svg>
                </div>
                <span style="font-size:.78rem;color:var(--text);font-weight:500;line-height:1.3;transition:color .2s;"><?= $label ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════ DECORATIVE DIVIDER ═══════════ -->
<div style="padding:2.5rem 1.5rem;background:var(--bg);display:flex;justify-content:center;align-items:center;">
    <div style="display:flex;align-items:center;gap:1.5rem;max-width:600px;width:100%;" class="fade-up">
        <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(212,168,73,.5));box-shadow:0 0 8px rgba(255,217,102,.3);"></div>
        <svg width="80" height="20" viewBox="0 0 80 20" fill="none" style="flex-shrink:0;">
            <path d="M2 10 L20 10" stroke="rgba(212,168,73,.6)" stroke-width="1"/>
            <circle cx="25" cy="10" r="1.5" fill="#ffd966"/>
            <path d="M30 10 L36 4 M30 10 L36 16 M30 10 L40 10" stroke="rgba(212,168,73,.8)" stroke-width="1.2" fill="none"/>
            <circle cx="40" cy="10" r="3" fill="none" stroke="#ffd966" stroke-width="1.2"/>
            <path d="M50 10 L44 4 M50 10 L44 16 M50 10 L40 10" stroke="rgba(212,168,73,.8)" stroke-width="1.2" fill="none"/>
            <circle cx="55" cy="10" r="1.5" fill="#ffd966"/>
            <path d="M60 10 L78 10" stroke="rgba(212,168,73,.6)" stroke-width="1"/>
        </svg>
        <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(212,168,73,.5),transparent);box-shadow:0 0 8px rgba(255,217,102,.3);"></div>
    </div>
</div>

<!-- ═══════════ NEW ARRIVALS ═══════════ -->
<?php if(!empty($newArrivals) && $loggedIn): ?>
<section style="padding:3rem 1.5rem 5rem;background:linear-gradient(180deg,var(--bg) 0%,var(--bg-soft) 100%);position:relative;">
<div style="max-width:1440px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;" class="fade-up">
        <p class="section-subtitle">Fresh In</p>
        <div style="display:flex;align-items:center;justify-content:center;gap:1.25rem;margin:.5rem 0;">
            <div style="width:50px;height:1px;background:linear-gradient(90deg,transparent,rgba(212,168,73,.6));"></div>
            <h2 class="section-title" style="margin:0;">What's <em>New</em></h2>
            <div style="width:50px;height:1px;background:linear-gradient(90deg,rgba(212,168,73,.6),transparent);"></div>
        </div>
        <div class="gold-line" style="margin:.875rem auto 0;"></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.5rem;">
        <?php foreach(array_slice($newArrivals,0,8) as $i=>$p): ?>
        <div class="fade-up stagger-<?= min(($i%5)+1,5) ?>"><?= view('partials/product_card',['p'=>$p,'wishlistedIds'=>$wishlistedIds]) ?></div>
        <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:3rem;">
        <a href="<?= $L('new-arrivals') ?>" class="btn-outline-neon" style="padding:.8rem 2.5rem;font-size:.78rem;border-radius:50px;">View All Arrivals →</a>
    </div>
</div>
</section>
<?php endif; ?>

<!-- ═══════════ FEATURED IN (always visible — external links) ═══════════ -->
<?php if(!empty($pressMentions)): ?>
<section class="section-light" style="padding:3.5rem 1.5rem;">
<div style="max-width:1440px;margin:0 auto;text-align:center;" class="fade-in">
    <p style="font-size:.7rem;letter-spacing:.25em;text-transform:uppercase;color:var(--copper);margin-bottom:2rem;font-weight:700;">— As Featured In —</p>
    <div style="display:flex;justify-content:center;align-items:center;flex-wrap:wrap;gap:1.5rem 3rem;">
        <?php foreach($pressMentions as $pm): ?>
        <a href="<?= esc($pm['link']??'#') ?>" target="_blank" rel="noopener"
           class="font-serif" style="font-size:1.15rem;color:var(--ink-soft);font-weight:600;transition:all .3s;font-style:italic;text-decoration:none;border-bottom:1px solid transparent;padding-bottom:2px;"
           onmouseover="this.style.color='var(--copper)';this.style.borderBottomColor='var(--copper)'"
           onmouseout="this.style.color='var(--ink-soft)';this.style.borderBottomColor='transparent'"><?= esc($pm['name']) ?></a>
        <?php endforeach; ?>
    </div>
</div>
</section>
<?php endif; ?>

<!-- ═══════════ BAR ESSENTIALS ═══════════ -->
<?php if(!empty($barCollections)): ?>
<section style="padding:5rem 1.5rem;background:var(--bg);border-top:1px solid rgba(212,168,73,.1);">
<div style="max-width:1440px;margin:0 auto;text-align:center;">
    <p class="section-subtitle fade-up">Curated for You</p>
    <h2 class="section-title fade-up" style="margin:.5rem 0;">Bar <em>Essentials</em></h2>
    <div class="gold-line fade-up" style="margin:.875rem auto 3rem;"></div>
    <div style="display:flex;justify-content:center;flex-wrap:wrap;gap:1.5rem;max-width:1100px;margin:0 auto;">
        <?php foreach($barCollections as $i=>$col): ?>
        <a href="<?= $L('category/'.$col['slug']) ?>" class="fade-up stagger-<?= min($i+1,5) ?>"
           style="text-decoration:none;background:#fff;border:1px solid rgba(212,168,73,.15);border-top:3px solid transparent;
                  border-radius:8px;overflow:hidden;transition:all .35s;display:block;width:260px;flex-shrink:0;"
           onmouseover="this.style.borderColor='rgba(212,168,73,.5)';this.style.borderTopColor='var(--copper)';this.style.transform='translateY(-6px)';this.style.boxShadow='0 20px 40px rgba(0,0,0,.3)'"
           onmouseout="this.style.borderColor='rgba(212,168,73,.15)';this.style.borderTopColor='transparent';this.style.transform='';this.style.boxShadow=''">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:2px;aspect-ratio:1;background:#1a1612;">
                <?php
                $imgs = $col['preview_images'] ?? [];
                for($gi=0;$gi<4;$gi++):
                    $src = $imgs[$gi] ?? null;
                    $srcUrl = $src ? (str_starts_with($src,'http') ? $src : base_url($src)) : null;
                ?>
                <div style="overflow:hidden;background:#2a2018;">
                    <?php if($srcUrl): ?>
                    <img src="<?= esc($srcUrl) ?>" alt="" loading="lazy" style="width:100%;height:100%;object-fit:cover;transition:transform .5s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform=''">
                    <?php else: ?>
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;opacity:.15;"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.3"><path d="M8 2l1 14h6l1-14H8z"/></svg></div>
                    <?php endif; ?>
                </div>
                <?php endfor; ?>
            </div>
            <div style="padding:1rem 1.25rem;background:rgba(26,22,18,.95);display:flex;align-items:center;justify-content:space-between;border-left:3px solid var(--copper);">
                <span style="font-family:'Crimson Pro',Georgia,serif;font-size:1.1rem;font-weight:600;color:#fff;font-style:italic;"><?= esc($col['display_name']) ?></span>
                <span style="font-size:.65rem;color:var(--gold-neon);letter-spacing:.1em;font-weight:700;">Shop →</span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
</section>
<?php endif; ?>

<!-- ═══════════ BEST SELLERS ═══════════ -->
<?php if(!empty($bestSellers) && $loggedIn): ?>
<section style="padding:5rem 1.5rem;background:var(--bg-soft);">
<div style="max-width:1440px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;" class="fade-up">
        <p class="section-subtitle">Most Loved</p>
        <div style="display:flex;align-items:center;justify-content:center;gap:1.25rem;margin:.5rem 0;">
            <div style="width:50px;height:1px;background:linear-gradient(90deg,transparent,rgba(212,168,73,.6));"></div>
            <h2 class="section-title" style="margin:0;">Best <em>Sellers</em></h2>
            <div style="width:50px;height:1px;background:linear-gradient(90deg,rgba(212,168,73,.6),transparent);"></div>
        </div>
        <div class="gold-line" style="margin:.875rem auto 0;"></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.5rem;">
        <?php foreach(array_slice($bestSellers,0,8) as $i=>$p): ?>
        <div class="fade-up stagger-<?= min(($i%5)+1,5) ?>"><?= view('partials/product_card',['p'=>$p,'wishlistedIds'=>$wishlistedIds]) ?></div>
        <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:3rem;">
        <a href="<?= $L('best-sellers') ?>" class="btn-outline-neon" style="padding:.8rem 2.5rem;font-size:.78rem;border-radius:50px;">Explore Best Sellers →</a>
    </div>
</div>
</section>
<?php endif; ?>

<!-- ═══════════ FOUNDER'S PICK ═══════════ -->
<?php if(!empty($foundersPick)): ?>
<section style="padding:5rem 1.5rem;background:var(--bg);">
<div style="max-width:1440px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;" class="fade-up">
        <p class="section-subtitle">Curated Selection</p>
        <h2 class="section-title" style="margin:.5rem 0;">Founder's <em>Pick</em></h2>
        <p style="color:var(--muted);font-size:.95rem;margin-top:.625rem;">The very best of Smokey, handpicked for you</p>
        <div class="gold-line" style="margin:1rem auto 0;"></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:1.5rem;">
        <?php foreach($foundersPick as $i=>$p): ?>
        <div class="fade-up stagger-<?= min($i+1,5) ?>"><?= view('partials/product_card',['p'=>$p,'wishlistedIds'=>$wishlistedIds]) ?></div>
        <?php endforeach; ?>
    </div>
</div>
</section>
<?php endif; ?>

<!-- ═══════════ BAR STYLING ═══════════ -->
<section style="padding:5rem 1.5rem;background:var(--bg-soft);">
<div style="max-width:1440px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;" class="fade-up">
        <p class="section-subtitle">Elevate Your Space</p>
        <svg width="60" height="12" viewBox="0 0 60 12" fill="none" style="display:block;margin:.5rem auto;">
            <line x1="0" y1="6" x2="22" y2="6" stroke="rgba(212,168,73,.4)" stroke-width="1"/>
            <circle cx="27" cy="6" r="2" fill="rgba(212,168,73,.7)"/>
            <circle cx="33" cy="6" r="3" fill="none" stroke="#ffd966" stroke-width="1.2"/>
            <circle cx="39" cy="6" r="2" fill="rgba(212,168,73,.7)"/>
            <line x1="44" y1="6" x2="60" y2="6" stroke="rgba(212,168,73,.4)" stroke-width="1"/>
        </svg>
        <h2 class="section-title" style="margin:.5rem 0;">Bar <em>Styling</em></h2>
        <div class="gold-line" style="margin:.875rem auto 0;"></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.5rem;">
        <?php foreach([
            ['<circle cx="12" cy="5" r="3"/><path d="M12 8v4"/><path d="M8 16c0-3 2-5 4-4s4 1 4 4"/><line x1="8" y1="16" x2="16" y2="16"/><line x1="6" y1="22" x2="18" y2="22"/><line x1="8" y1="16" x2="6" y2="22"/><line x1="16" y1="16" x2="18" y2="22"/>','Sculptures',   'Figurines & statement pieces','category/sculpture'],
            ['<path d="M9 18h6"/><path d="M10 22h4"/><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8a6 6 0 1 0-12 0c0 1.33.47 2.5 1.5 3.5.75.76 1.23 1.52 1.41 2.5"/>','Lights & Lamps','Ambience that sets the mood','shop?q=lights'],
            ['<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/><line x1="12" y1="3" x2="12" y2="8"/>','Serveware',    'Platters, trays & dineware',  'category/serveware'],
            ['<path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/>','Coffee & Tea', 'Morning rituals, elevated',    'category/tea-coffee'],
        ] as $i=>[$svg,$title,$sub,$path]): ?>
        <a href="<?= $L($path) ?>" class="fade-up stagger-<?= $i+1 ?>"
           style="text-decoration:none;display:flex;flex-direction:column;align-items:center;justify-content:center;
                  text-align:center;padding:2.5rem 1.5rem;border:1px solid var(--border);border-top:3px solid transparent;border-radius:14px;
                  background:linear-gradient(180deg,#1c1812,#141010);transition:all .4s;position:relative;overflow:hidden;"
           onmouseover="this.style.borderColor='rgba(212,168,73,.5)';this.style.borderTopColor='var(--gold)';this.style.transform='translateY(-10px)';this.style.boxShadow='0 24px 60px rgba(0,0,0,.7),0 0 40px rgba(212,168,73,.15)'"
           onmouseout="this.style.borderColor='var(--border)';this.style.borderTopColor='transparent';this.style.transform='';this.style.boxShadow=''">
            <div style="position:absolute;top:-30px;left:50%;transform:translateX(-50%);width:120px;height:120px;border-radius:50%;background:radial-gradient(circle,rgba(212,168,73,.12),transparent 70%);filter:blur(20px);"></div>
            <div style="width:64px;height:64px;margin-bottom:1rem;display:flex;align-items:center;justify-content:center;border-radius:50%;background:rgba(212,168,73,.1);border:1px solid rgba(212,168,73,.25);animation:icon-float <?= 4+$i ?>s ease-in-out infinite;">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="var(--gold-neon)" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><?= $svg ?></svg>
            </div>
            <h3 class="font-serif" style="font-size:1.25rem;color:var(--text);margin-bottom:.35rem;font-weight:500;"><?= $title ?></h3>
            <p style="color:var(--muted);font-size:.78rem;"><?= $sub ?></p>
            <div style="margin-top:1rem;font-size:.7rem;color:var(--gold-neon);letter-spacing:.1em;font-weight:700;text-transform:uppercase;">Shop →</div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
</section>

<!-- ═══════════ ALSO AVAILABLE ON (always open — external) ═══════════ -->
<section style="padding:4rem 1.5rem;background:var(--bg);border-top:1px solid rgba(212,168,73,.1);">
<div style="max-width:1440px;margin:0 auto;text-align:center;" class="fade-in">
    <p style="font-size:.7rem;letter-spacing:.25em;text-transform:uppercase;color:var(--copper);margin-bottom:2rem;font-weight:700;">Also Available On</p>
    <div style="display:flex;justify-content:center;align-items:center;flex-wrap:wrap;gap:1.5rem 3rem;">
        <?php foreach([
            ['Amazon',   'https://www.amazon.in/s?k=smokey+cocktail'],
            ['Flipkart', 'https://www.flipkart.com/search?q=smokey+cocktail'],
            ['Tata Cliq','https://www.tatacliq.com/search/?searchCategory=all&text=smokey%20cocktail'],
            ['Nykaa',    'https://www.nykaafashion.com/designers/smokey-cocktail/c/66844'],
            ['Myntra',   'https://www.myntra.com/smokey-cocktail'],
        ] as [$name,$url]): ?>
        <a href="<?= $url ?>" target="_blank" rel="noopener" class="font-serif"
           style="font-size:1.2rem;color:var(--text);font-weight:600;transition:all .3s;font-style:italic;text-decoration:none;border-bottom:1px solid transparent;padding-bottom:2px;"
           onmouseover="this.style.color='var(--gold-neon)';this.style.borderBottomColor='var(--gold-neon)'"
           onmouseout="this.style.color='var(--text)';this.style.borderBottomColor='transparent'"><?= $name ?></a>
        <?php endforeach; ?>
    </div>
</div>
</section>

<!-- ═══════════ WHY CHOOSE US ═══════════ -->
<section style="padding:5rem 1.5rem;background:linear-gradient(180deg,var(--bg-soft) 0%,var(--bg) 100%);">
<div style="max-width:1440px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;" class="fade-up">
        <p class="section-subtitle">Why Smokey</p>
        <h2 class="section-title" style="margin:.5rem 0;">The <em>Difference</em></h2>
        <div class="gold-line" style="margin:.875rem auto 0;"></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem;">
        <?php foreach([
            ['<path d="M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z"/><path d="M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/><path d="M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z"/><path d="M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z"/><path d="M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z"/><path d="M15.5 19H14v1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"/><path d="M10 9.5C10 8.67 9.33 8 8.5 8h-5C2.67 8 2 8.67 2 9.5S2.67 11 3.5 11h5c.83 0 1.5-.67 1.5-1.5z"/><path d="M8.5 5H10V3.5C10 2.67 9.33 2 8.5 2S7 2.67 7 3.5 7.67 5 8.5 5z"/>','Master Craftsmanship','Every piece is hand-crafted by artisans with decades of experience','#d4a849'],
            ['<polyline points="20 6 9 17 4 12"/>','Premium Quality','Lead-free crystal, food-safe materials, built to last generations','#a07cc8'],
            ['<polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>','Gift Worthy','Beautifully packaged, perfect for any occasion or celebration','#5fb88a'],
            ['<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>','Fast Delivery','Carefully packed & dispatched within 2 days across India','#5fa8d4'],
        ] as $i=>[$svg,$title,$desc,$color]): ?>
        <div class="fade-up stagger-<?= $i+1 ?>"
             style="background:linear-gradient(180deg,#1c1812 0%,#141010 100%);border:1px solid var(--border);
                    border-radius:14px;padding:2rem 1.5rem;text-align:center;transition:all .4s;position:relative;overflow:hidden;cursor:pointer;"
             onmouseover="this.style.borderColor='<?= $color ?>';this.style.transform='translateY(-8px) rotateY(3deg)';this.style.boxShadow='0 20px 50px rgba(0,0,0,.5),0 0 40px <?= $color ?>33'"
             onmouseout="this.style.borderColor='var(--border)';this.style.transform='';this.style.boxShadow=''">
            <div style="position:absolute;top:-30px;left:50%;transform:translateX(-50%);width:120px;height:120px;border-radius:50%;background:radial-gradient(circle,<?= $color ?>33,transparent 70%);filter:blur(20px);pointer-events:none;"></div>
            <div style="position:relative;width:80px;height:80px;margin:0 auto 1.25rem;border-radius:20px;
                        background:linear-gradient(135deg,<?= $color ?>22,<?= $color ?>11);
                        border:2px solid <?= $color ?>44;display:flex;align-items:center;justify-content:center;
                        animation:icon-float <?= 4+$i ?>s ease-in-out infinite;">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="<?= $color ?>" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><?= $svg ?></svg>
            </div>
            <h3 class="font-serif" style="font-size:1.2rem;color:var(--text);margin-bottom:.5rem;font-weight:500;"><?= $title ?></h3>
            <p style="color:var(--muted);font-size:.82rem;line-height:1.6;"><?= $desc ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</section>

<!-- ═══════════ NEWSLETTER ═══════════ -->
<section style="padding:5rem 1.5rem;background:linear-gradient(135deg,var(--bg) 0%,#1a1208 50%,var(--bg) 100%);text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:600px;height:300px;background:radial-gradient(ellipse,rgba(255,217,102,.15),transparent 70%);filter:blur(50px);pointer-events:none;"></div>
    <div class="gold-orb" style="top:20%;left:10%;animation-delay:0s;width:5px;height:5px;"></div>
    <div class="gold-orb" style="top:60%;right:12%;animation-delay:2s;width:7px;height:7px;"></div>
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);opacity:.03;pointer-events:none;user-select:none;"><svg width="200" height="200" viewBox="0 0 24 24" fill="var(--gold-neon)" stroke="none"><path d="M3 3l9 9 9-9H3z"/><path d="M12 12v8"/><path d="M9 20h6"/></svg></div>
    <div style="max-width:620px;margin:0 auto;position:relative;" class="fade-up">
        <div style="margin-bottom:1rem;display:flex;justify-content:center;filter:drop-shadow(0 0 20px rgba(255,217,102,.5));"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gold-neon)" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg></div>
        <p class="section-subtitle" style="margin-bottom:.75rem;">Join the Club</p>
        <h2 class="section-title" style="margin-bottom:1rem;">Get <em>10% Off</em> Your First Order</h2>
        <p style="color:var(--muted);font-size:.95rem;margin-bottom:2.25rem;line-height:1.75;">Subscribe for exclusive offers, cocktail inspiration & early access to new arrivals.</p>
        <form style="display:flex;gap:0;max-width:440px;margin:0 auto;"
              onsubmit="event.preventDefault();this.innerHTML='<div style=&quot;color:var(--gold-neon);font-size:1rem;padding:1rem;&quot;>You\'re subscribed! Check your inbox.</div>'">
            <input type="email" placeholder="Your email address" required
                   style="flex:1;padding:.95rem 1.2rem;border-radius:50px 0 0 50px;font-size:.875rem;background:rgba(255,255,255,.07);border:1.5px solid rgba(212,168,73,.3);border-right:none;color:var(--text);outline:none;transition:border-color .2s;"
                   onfocus="this.style.borderColor='rgba(212,168,73,.7)'" onblur="this.style.borderColor='rgba(212,168,73,.3)'">
            <button type="submit" class="btn-neon" style="padding:.95rem 2rem;font-size:.78rem;border-radius:0 50px 50px 0;white-space:nowrap;">Subscribe</button>
        </form>
        <p style="font-size:.68rem;color:var(--muted);margin-top:1rem;opacity:.6;">No spam. Unsubscribe anytime.</p>
    </div>
</section>

<!-- ═══════════ BLOG ═══════════ -->
<?php if(!empty($recentPosts)): ?>
<section style="padding:5rem 1.5rem;background:var(--bg-soft);">
<div style="max-width:1440px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;" class="fade-up">
        <p class="section-subtitle">Stories</p>
        <h2 class="section-title" style="margin:.5rem 0;">First Look <em>Articles</em></h2>
        <div class="gold-line" style="margin:.875rem auto 0;"></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.75rem;">
        <?php foreach($recentPosts as $i=>$post): ?>
        <a href="<?= $L('blog/'.$post['slug']) ?>" class="fade-up stagger-<?= $i+1 ?>"
           style="text-decoration:none;background:linear-gradient(180deg,#1c1812,#141010);border:1px solid var(--border);border-left:3px solid transparent;border-radius:12px;overflow:hidden;transition:all .35s;display:block;"
           onmouseover="this.style.borderColor='rgba(212,168,73,.5)';this.style.borderLeftColor='var(--copper)';this.style.transform='translateY(-6px)';this.style.boxShadow='0 18px 40px rgba(0,0,0,.4)'"
           onmouseout="this.style.borderColor='var(--border)';this.style.borderLeftColor='transparent';this.style.transform='';this.style.boxShadow=''">
            <?php if($post['cover_image']): ?>
            <div style="aspect-ratio:16/9;overflow:hidden;background:var(--bg);">
                <img src="<?= esc(str_starts_with($post['cover_image'],'http')?$post['cover_image']:base_url($post['cover_image'])) ?>"
                     alt="<?= esc($post['title']) ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover;transition:transform .6s;"
                     onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform=''">
            </div>
            <?php else: ?>
            <div style="aspect-ratio:16/9;background:var(--bg);display:flex;align-items:center;justify-content:center;opacity:.2;"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.3"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
            <?php endif; ?>
            <div style="padding:1.5rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.625rem;">
                    <p style="font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;color:var(--copper);font-weight:700;margin:0;"><?= esc($post['author']??'Smokey Team') ?></p>
                    <?php if(!empty($post['created_at'])): ?>
                    <span style="font-size:.65rem;color:var(--muted);letter-spacing:.05em;"><?= date('M j, Y', strtotime($post['created_at'])) ?></span>
                    <?php endif; ?>
                </div>
                <h3 class="font-serif" style="font-size:1.3rem;color:var(--text);line-height:1.35;margin-bottom:.5rem;font-weight:500;"><?= esc($post['title']) ?></h3>
                <p style="font-size:.82rem;color:var(--muted);line-height:1.65;"><?= esc(mb_substr(strip_tags($post['excerpt']??''),0,110)) ?>…</p>
                <span style="font-size:.78rem;color:var(--copper);display:block;margin-top:1rem;font-weight:700;">Read more →</span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
</section>
<?php endif; ?>

<!-- ═══════════ BULK / CONTACT CTA ═══════════ -->
<section style="padding:5rem 1.5rem;background:var(--bg);position:relative;overflow:hidden;">
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:700px;height:400px;background:radial-gradient(ellipse,rgba(255,217,102,.08),transparent 70%);filter:blur(60px);"></div>
<div style="max-width:720px;margin:0 auto;text-align:center;position:relative;
            background:linear-gradient(135deg,rgba(28,24,18,.9),rgba(20,16,16,.8));
            border:1px solid rgba(212,168,73,.25);padding:3.5rem 3rem;border-radius:20px;
            backdrop-filter:blur(20px);box-shadow:0 25px 60px rgba(0,0,0,.5),inset 0 1px 0 rgba(212,168,73,.15);" class="fade-up">
    <div style="margin-bottom:1rem;display:flex;justify-content:center;filter:drop-shadow(0 0 20px rgba(255,217,102,.4));"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gold-neon)" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
    <p class="section-subtitle">For Businesses</p>
    <h2 class="section-title" style="margin:.5rem 0;">See It. Love It. <em>Buy It.</em></h2>
    <div class="gold-line" style="margin:.875rem auto;"></div>
    <p style="color:var(--muted);font-size:.95rem;margin:1rem 0 2.5rem;line-height:1.7;">Planning a bulk order or corporate gifting?<br>We'd love to help elevate every occasion.</p>
    <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;">
        <a href="https://wa.me/919876543210" target="_blank"
           style="padding:.95rem 2rem;font-size:.78rem;border-radius:50px;text-transform:uppercase;letter-spacing:.08em;display:flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,#1ebe57,#25D366);color:#fff;text-decoration:none;font-weight:700;box-shadow:0 4px 20px rgba(37,211,102,.4);transition:all .25s;"
           onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform=''">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
            WhatsApp Us
        </a>
        <a href="mailto:<?= esc(brand_setting('contact_email','hello@smokeycocktail.com')) ?>"
           class="btn-outline-neon" style="padding:.95rem 2rem;font-size:.78rem;border-radius:50px;">Email Us</a>
    </div>
</div>
</section>

<?= $this->endSection() ?>
