<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<?php if (!auth()->loggedIn()): ?>
<!-- ════════════════════════════════════════════════════════════
     LANDING PAGE — shown to guests only
     ════════════════════════════════════════════════════════════ -->

<!-- HERO -->
<section style="position:relative;min-height:94vh;display:flex;align-items:center;justify-content:center;overflow:hidden;background:var(--bg);text-align:center;">
    <video class="hero-video" autoplay muted loop playsinline preload="auto"
           poster="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=1920&q=80">
        <source src="https://videos.pexels.com/video-files/4259291/4259291-uhd_2560_1440_24fps.mp4" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div style="position:relative;z-index:5;padding:2rem 1.5rem;max-width:760px;">
        <p class="section-subtitle" style="margin-bottom:1.5rem;animation:fadeUp .8s ease both;">✦ Premium Barware & Cocktail Essentials ✦</p>
        <h1 class="font-serif glow-text" style="font-size:clamp(2.8rem,7vw,5.5rem);font-weight:300;color:var(--text);line-height:1.05;margin-bottom:1.25rem;letter-spacing:-.02em;animation:fadeUp 1s .1s ease both;">
            Craft Your <em style="color:var(--gold-neon);font-style:italic;animation:glow 4s ease-in-out infinite;">Perfect Pour</em>
        </h1>
        <p style="color:var(--muted);font-size:1.05rem;max-width:520px;margin:0 auto 2.5rem;line-height:1.75;animation:fadeUp .8s .2s ease both;">
            Handcrafted glassware, sculptural barware and cocktail tools for the discerning bartender — by invitation.
        </p>
        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;animation:fadeUp .8s .3s ease both;">
            <a href="<?= site_url('login') ?>" class="btn-neon" style="padding:1rem 2.75rem;font-size:.8rem;border-radius:50px;">Login to Shop</a>
            <a href="<?= site_url('register') ?>" class="btn-outline-neon" style="padding:1rem 2.75rem;font-size:.8rem;border-radius:50px;">Create Account</a>
        </div>
    </div>
</section>

<!-- MARQUEE -->
<div style="background:linear-gradient(90deg,var(--bg-soft),#1a1410,var(--bg-soft));border-top:1px solid rgba(212,168,73,.2);border-bottom:1px solid rgba(212,168,73,.2);padding:.85rem 0;overflow:hidden;">
    <div style="display:flex;gap:3rem;animation:marquee 25s linear infinite;white-space:nowrap;">
        <?php for($i=0;$i<3;$i++): ?>
        <?php foreach (['✦ Whiskey Glasses','✦ Cocktail Glasses','✦ Premium Decanters','✦ Sculptures & Figurines','✦ Wine Glasses','✦ Beer Mugs','✦ Bar Accessories','✦ Tea & Coffee','✦ Shot Glasses','✦ Lights & Lamps','✦ Serveware','✦ Free Shipping ₹5,000+'] as $txt): ?>
        <span style="font-size:.85rem;color:var(--gold-neon);font-weight:600;letter-spacing:.12em;text-transform:uppercase;"><?= $txt ?></span>
        <?php endforeach; ?>
        <?php endfor; ?>
    </div>
</div>

<!-- COLLECTIONS — visible but locked -->
<section style="padding:5rem 1.5rem;background:var(--bg);">
<div style="max-width:1440px;margin:0 auto;text-align:center;">
    <p class="section-subtitle fade-up" style="margin-bottom:.75rem;">The Collections</p>
    <h2 class="section-title fade-up" style="margin-bottom:.5rem;">Explore Our <em>Catalogue</em></h2>
    <p style="color:var(--muted);font-size:.85rem;margin-bottom:3rem;" class="fade-up">Login to browse 2,900+ premium barware pieces</p>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem;margin-bottom:3rem;">
        <?php foreach (array_slice($featuredCategories ?? [], 0, 6) as $i => $cat):
            $img = $cat['cover_image'] ? (str_starts_with($cat['cover_image'],'http') ? $cat['cover_image'] : base_url($cat['cover_image'])) : null;
        ?>
        <a href="<?= site_url('login') ?>"
           style="display:block;position:relative;aspect-ratio:4/5;overflow:hidden;border-radius:10px;
                  background:linear-gradient(135deg,#1c1812,#0f0c0a);border:1px solid var(--border);
                  text-decoration:none;transition:all .4s;"
           onmouseover="this.style.borderColor='rgba(212,168,73,.5)';this.style.transform='translateY(-4px)'"
           onmouseout="this.style.borderColor='var(--border)';this.style.transform=''">
            <?php if ($img): ?>
            <img src="<?= esc($img) ?>" alt="<?= esc($cat['name']) ?>"
                 style="width:100%;height:100%;object-fit:cover;transition:transform .6s;"
                 onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform=''">
            <?php else: ?>
            <div style="width:100%;height:100%;background:linear-gradient(135deg,#1c1812,#141010);display:flex;align-items:center;justify-content:center;font-size:3rem;opacity:.3;">🥃</div>
            <?php endif; ?>
            <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.82) 0%,rgba(0,0,0,.1) 60%,transparent 100%);"></div>
            <div style="position:absolute;bottom:0;left:0;right:0;padding:1.5rem;">
                <p class="font-serif" style="font-size:1.3rem;font-style:italic;font-weight:600;color:#fff;margin-bottom:.3rem;"><?= esc($cat['name']) ?></p>
                <p style="font-size:.72rem;color:rgba(255,255,255,.6);letter-spacing:.08em;">🔒 Login to browse</p>
            </div>
        </a>
        <?php endforeach; ?>
        <?php if (empty($featuredCategories ?? [])): ?>
        <?php foreach (['Whiskey Glasses','Cocktail Glasses','Sculptures','Serveware','Beer Mugs','Wine Glasses'] as $i => $name): ?>
        <a href="<?= site_url('login') ?>"
           style="display:block;position:relative;aspect-ratio:4/5;overflow:hidden;border-radius:10px;
                  background:linear-gradient(135deg,#1c1812,#0f0c0a);border:1px solid var(--border);
                  text-decoration:none;transition:all .4s;display:flex;align-items:flex-end;"
           onmouseover="this.style.borderColor='rgba(212,168,73,.5)';this.style.transform='translateY(-4px)'"
           onmouseout="this.style.borderColor='var(--border)';this.style.transform=''">
            <div style="width:100%;height:100%;position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:4rem;opacity:.15;">🥃</div>
            <div style="position:relative;padding:1.5rem;width:100%;">
                <p class="font-serif" style="font-size:1.3rem;font-style:italic;font-weight:600;color:#fff;margin-bottom:.3rem;"><?= $name ?></p>
                <p style="font-size:.72rem;color:rgba(255,255,255,.5);letter-spacing:.08em;">🔒 Login to browse</p>
            </div>
        </a>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <a href="<?= site_url('login') ?>" class="btn-neon" style="padding:.95rem 3rem;font-size:.8rem;border-radius:50px;display:inline-block;">Login to View All Products →</a>
</div>
</section>

<!-- WHY SMOKEY -->
<section style="padding:5rem 1.5rem;background:linear-gradient(180deg,var(--bg-soft) 0%,var(--bg) 100%);">
<div style="max-width:1100px;margin:0 auto;text-align:center;">
    <h2 class="section-title fade-up" style="margin-bottom:3rem;">Why <em>Smokey</em></h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.5rem;">
        <?php foreach ([
            ['🥃','2,900+ Products','Barware, sculptures, glassware & more'],
            ['✦','Premium Quality','Lead-free crystal, food-safe materials'],
            ['🚚','Free Shipping','On orders above ₹5,000 across India'],
            ['🎁','Gift Worthy','Beautifully packaged for any occasion'],
        ] as $i => [$em,$title,$desc]): ?>
        <div style="background:linear-gradient(180deg,#1c1812,#141010);border:1px solid var(--border);
                    border-radius:14px;padding:2rem 1.5rem;transition:all .3s;"
             onmouseover="this.style.borderColor='rgba(212,168,73,.4)'" onmouseout="this.style.borderColor='var(--border)'">
            <div style="font-size:2.2rem;margin-bottom:.875rem;"><?= $em ?></div>
            <h3 class="font-serif" style="font-size:1.1rem;color:var(--text);margin-bottom:.4rem;"><?= $title ?></h3>
            <p style="color:var(--muted);font-size:.8rem;line-height:1.6;"><?= $desc ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</section>

<!-- FINAL CTA -->
<section style="padding:5rem 1.5rem;background:var(--bg);text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:600px;height:300px;background:radial-gradient(ellipse,rgba(255,217,102,.12),transparent 70%);filter:blur(50px);"></div>
    <div style="max-width:560px;margin:0 auto;position:relative;">
        <p class="section-subtitle" style="margin-bottom:.75rem;">Join the Club</p>
        <h2 class="section-title" style="margin-bottom:1rem;">Ready to <em>Explore?</em></h2>
        <p style="color:var(--muted);font-size:.95rem;margin-bottom:2rem;line-height:1.7;">Create a free account and get access to our full catalogue of premium barware, sculptures & cocktail essentials.</p>
        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
            <a href="<?= site_url('register') ?>" class="btn-neon" style="padding:1rem 2.5rem;font-size:.8rem;border-radius:50px;">Create Account →</a>
            <a href="<?= site_url('login') ?>" class="btn-outline-neon" style="padding:1rem 2.5rem;font-size:.8rem;border-radius:50px;">Already have account? Login</a>
        </div>
    </div>
</section>

<?php else: ?>
<!-- ════════════════════════════════════════════════════════════
     FULL HOME — shown to logged-in users
     ════════════════════════════════════════════════════════════ -->

<!-- ═══════════ HERO with video & cocktail animations ═══════════ -->
<section style="position:relative;min-height:92vh;display:flex;align-items:center;overflow:hidden;background:var(--bg);">
    <!-- Live video background — cocktail/glass scene -->
    <video class="hero-video" autoplay muted loop playsinline preload="auto"
           poster="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=1920&q=80">
        <source src="https://videos.pexels.com/video-files/4259291/4259291-uhd_2560_1440_24fps.mp4" type="video/mp4">
        <source src="https://videos.pexels.com/video-files/8313897/8313897-uhd_2560_1440_25fps.mp4" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>

    <!-- Sophisticated golden particles -->
    <div class="gold-orb" style="top:20%;left:12%;animation-delay:0s;"></div>
    <div class="gold-orb" style="top:35%;right:8%;animation-delay:2s;width:8px;height:8px;"></div>
    <div class="gold-orb" style="bottom:25%;left:18%;animation-delay:4s;width:5px;height:5px;"></div>
    <div class="gold-orb" style="top:55%;right:22%;animation-delay:1s;width:7px;height:7px;"></div>

    <!-- Subtle smoke -->
    <div class="smoke-particle" style="bottom:0;left:15%;animation-delay:0s;"></div>
    <div class="smoke-particle" style="bottom:0;left:45%;animation-delay:3s;"></div>
    <div class="smoke-particle" style="bottom:0;left:75%;animation-delay:6s;"></div>

    <!-- Decorative side lines -->
    <div style="position:absolute;top:50%;left:8%;transform:translateY(-50%);width:1px;height:40%;background:linear-gradient(to bottom,transparent,rgba(212,168,73,.4),transparent);"></div>
    <div style="position:absolute;top:50%;right:8%;transform:translateY(-50%);width:1px;height:40%;background:linear-gradient(to bottom,transparent,rgba(212,168,73,.4),transparent);"></div>

    <!-- Decorative glow -->
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
            <a href="<?= site_url('shop') ?>" class="btn-neon" style="padding:1rem 2.75rem;font-size:.8rem;border-radius:50px;">
                Shop Collection
            </a>
            <a href="<?= site_url('new-arrivals') ?>" class="btn-outline-neon" style="padding:1rem 2.75rem;font-size:.8rem;border-radius:50px;">
                ✦ New Arrivals
            </a>
        </div>

        <!-- Slide dots -->
        <div style="display:flex;gap:.625rem;justify-content:center;margin-top:3.5rem;animation:fadeUp .8s .5s ease both;" id="hero-dots">
            <?php foreach ([0,1,2] as $di): ?>
            <button onclick="goSlide(<?= $di ?>)" id="dot-<?= $di ?>"
                    style="height:6px;border-radius:3px;border:none;cursor:pointer;transition:all .4s;
                           width:<?= $di===0?'40':'12' ?>px;background:<?= $di===0?'var(--gold-neon)':'rgba(255,217,102,.2)' ?>;
                           box-shadow:<?= $di===0?'0 0 15px rgba(255,217,102,.6)':'none' ?>;"></button>
            <?php endforeach; ?>
        </div>

        <!-- Scroll indicator -->
        <div style="position:absolute;bottom:30px;left:50%;transform:translateX(-50%);animation:float 2s ease-in-out infinite;">
            <svg width="24" height="38" viewBox="0 0 24 38" fill="none" stroke="var(--gold-neon)" stroke-width="1.5"><rect x="2" y="2" width="20" height="34" rx="10"/><line x1="12" y1="8" x2="12" y2="16" stroke-linecap="round"/></svg>
        </div>
    </div>
</section>

<!-- ═══════════ MARQUEE STRIP ═══════════ -->
<div style="background:linear-gradient(90deg,var(--bg-soft),#1a1410,var(--bg-soft));border-top:1px solid rgba(212,168,73,.2);border-bottom:1px solid rgba(212,168,73,.2);padding:.85rem 0;overflow:hidden;">
    <div style="display:flex;gap:3rem;animation:marquee 25s linear infinite;white-space:nowrap;">
        <?php for($i=0;$i<3;$i++): ?>
        <?php foreach (['✦ Whiskey Glasses','✦ Cocktail Glasses','✦ Premium Decanters','✦ Sculptures & Figurines','✦ Wine Glasses','✦ Beer Mugs','✦ Bar Accessories','✦ Tea & Coffee','✦ Shot Glasses','✦ Lights & Lamps','✦ Serveware','✦ Free Shipping ₹5,000+'] as $txt): ?>
        <span style="font-size:.85rem;color:var(--gold-neon);font-weight:600;letter-spacing:.12em;text-transform:uppercase;text-shadow:0 0 12px rgba(255,217,102,.3);"><?= $txt ?></span>
        <?php endforeach; ?>
        <?php endfor; ?>
    </div>
</div>
<style>@keyframes marquee{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}</style>

<!-- ═══════════ TRUST STRIP ═══════════ -->
<div style="background:var(--bg-soft);border-bottom:1px solid rgba(212,168,73,.15);padding:1.5rem 1.5rem;">
    <div style="max-width:1440px;margin:0 auto;display:flex;justify-content:space-around;flex-wrap:wrap;gap:1rem;">
        <?php foreach ([['🚚','Free Shipping','Orders ₹5,000+'],['💰','COD Available','Pay on delivery'],['↩','Easy Returns','7 days'],['⭐','1L+ Customers','Trusted across India']] as $i => [$ic,$h,$s]): ?>
        <div class="fade-up stagger-<?= $i+1 ?>" style="display:flex;align-items:center;gap:.75rem;">
            <span style="font-size:1.7rem;filter:drop-shadow(0 0 12px rgba(255,217,102,.5));animation:icon-float <?= 5+$i ?>s ease-in-out infinite;"><?= $ic ?></span>
            <div><div style="font-size:.8rem;font-weight:700;color:var(--text);"><?= $h ?></div><div style="font-size:.7rem;color:var(--muted);"><?= $s ?></div></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ═══════════ CIRCULAR CATEGORIES ═══════════ -->
<section style="padding:5rem 1.5rem;background:var(--bg);position:relative;overflow:hidden;">
    <!-- Glow -->
    <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:800px;height:200px;background:radial-gradient(ellipse,rgba(212,168,73,.1),transparent 70%);filter:blur(40px);pointer-events:none;"></div>

    <div style="max-width:1440px;margin:0 auto;text-align:center;position:relative;">
        <p class="section-subtitle fade-up" style="margin-bottom:.75rem;">Shop by Category</p>
        <h2 class="section-title fade-up" style="margin-bottom:.75rem;">Explore Our <em>Collections</em></h2>
        <div class="gold-line fade-up" style="margin:0 auto 3rem;"></div>

        <div style="display:flex;justify-content:center;flex-wrap:wrap;gap:1.75rem 2.25rem;">
            <?php
            $iconCats = [
                ['Best Selling',   'best-sellers',           '⭐'],
                ['New Arrivals',   'new-arrivals',           '✨'],
                ['Whiskey',        'category/whi-glasses',   '🥃'],
                ['Cocktail',       'category/cocktail-glass','🍸'],
                ['Beer Mugs',      'category/beer-mug',      '🍺'],
                ['Wine',           'category/wine-glasses',  '🍷'],
                ['Bar Accessories','category/bar-accessories','🍹'],
                ['Decanters',      'category/decanter',      '🫗'],
                ['Sculptures',     'category/sculpture',     '🗿'],
                ['Shot Glasses',   'category/shot-glass',    '🥂'],
                ['Tea & Coffee',   'category/tea-coffee',    '☕'],
                ['Serveware',      'category/serveware',     '🍽️'],
            ];
            foreach ($iconCats as $i => [$label,$url,$emoji]):
            ?>
            <a href="<?= site_url($url) ?>" class="fade-up stagger-<?= min(($i%5)+1,5) ?>"
               style="text-decoration:none;text-align:center;display:flex;flex-direction:column;align-items:center;gap:.625rem;width:120px;">
                <div class="cat-circle"><?= $emoji ?></div>
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
        <!-- Ornament -->
        <svg width="80" height="20" viewBox="0 0 80 20" fill="none" style="flex-shrink:0;">
            <path d="M2 10 L20 10" stroke="rgba(212,168,73,.6)" stroke-width="1"/>
            <circle cx="25" cy="10" r="1.5" fill="#ffd966" style="filter:drop-shadow(0 0 4px rgba(255,217,102,.8))"/>
            <path d="M30 10 L36 4 M30 10 L36 16 M30 10 L40 10" stroke="rgba(212,168,73,.8)" stroke-width="1.2" fill="none"/>
            <circle cx="40" cy="10" r="3" fill="none" stroke="#ffd966" stroke-width="1.2" style="filter:drop-shadow(0 0 6px rgba(255,217,102,.6))"/>
            <path d="M50 10 L44 4 M50 10 L44 16 M50 10 L40 10" stroke="rgba(212,168,73,.8)" stroke-width="1.2" fill="none"/>
            <circle cx="55" cy="10" r="1.5" fill="#ffd966" style="filter:drop-shadow(0 0 4px rgba(255,217,102,.8))"/>
            <path d="M60 10 L78 10" stroke="rgba(212,168,73,.6)" stroke-width="1"/>
        </svg>
        <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(212,168,73,.5),transparent);box-shadow:0 0 8px rgba(255,217,102,.3);"></div>
    </div>
</div>

<!-- ═══════════ NEW ARRIVALS (Dark) ═══════════ -->
<?php if (!empty($newArrivals)): ?>
<section style="padding:3rem 1.5rem 5rem;background:linear-gradient(180deg,var(--bg) 0%,var(--bg-soft) 100%);position:relative;">
<div style="max-width:1440px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;" class="fade-up">
        <p class="section-subtitle">Fresh In</p>
        <h2 class="section-title" style="margin:.5rem 0;">What's <em>New</em></h2>
        <div class="gold-line" style="margin:.875rem auto 0;"></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.5rem;">
        <?php foreach (array_slice($newArrivals, 0, 8) as $i => $p): ?>
        <div class="fade-up stagger-<?= min(($i%5)+1,5) ?>">
            <?= view('partials/product_card', ['p' => $p, 'wishlistedIds' => $wishlistedIds]) ?>
        </div>
        <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:3rem;">
        <a href="<?= site_url('new-arrivals') ?>" class="btn-outline-neon" style="padding:.8rem 2.5rem;font-size:.78rem;border-radius:50px;">View All Arrivals →</a>
    </div>
</div>
</section>
<?php endif; ?>

<!-- ═══════════ FEATURED IN (Light contrast strip) ═══════════ -->
<?php if (!empty($pressMentions)): ?>
<section class="section-light" style="padding:3.5rem 1.5rem;">
<div style="max-width:1440px;margin:0 auto;text-align:center;" class="fade-in">
    <p style="font-size:.7rem;letter-spacing:.25em;text-transform:uppercase;color:var(--copper);margin-bottom:2rem;font-weight:700;">— As Featured In —</p>
    <div style="display:flex;justify-content:center;align-items:center;flex-wrap:wrap;gap:1.5rem 3rem;">
        <?php foreach ($pressMentions as $pm): ?>
        <a href="<?= esc($pm['link'] ?? '#') ?>" target="_blank" rel="noopener"
           class="font-serif" style="font-size:1.15rem;color:var(--ink-soft);letter-spacing:.02em;font-weight:600;transition:all .3s;font-style:italic;text-decoration:none;border-bottom:1px solid transparent;padding-bottom:2px;"
           onmouseover="this.style.color='var(--copper)';this.style.borderBottomColor='var(--copper)'"
           onmouseout="this.style.color='var(--ink-soft)';this.style.borderBottomColor='transparent'">
            <?= esc($pm['name']) ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>
</section>
<?php endif; ?>

<!-- ═══════════ BAR ESSENTIALS (Light) ═══════════ -->
<?php if (!empty($barCollections)): ?>
<section class="section-light" style="padding:5rem 1.5rem;border-top:1px solid var(--border-light);">
<div style="max-width:1440px;margin:0 auto;text-align:center;">
    <p class="section-subtitle fade-up">Curated for You</p>
    <h2 class="section-title fade-up" style="margin:.5rem 0;">Bar <em>Essentials</em></h2>
    <div class="gold-line fade-up" style="margin:.875rem auto 3rem;"></div>
    <div style="display:flex;justify-content:center;flex-wrap:wrap;gap:1.5rem;max-width:1100px;margin:0 auto;">
        <?php foreach ($barCollections as $i => $col): ?>
        <a href="<?= site_url('category/'.$col['slug']) ?>"
           class="fade-up stagger-<?= min($i+1,5) ?>"
           style="text-decoration:none;display:block;background:#fff;border:1px solid var(--border-light);
                  padding:2.25rem 1.5rem;border-radius:12px;text-align:center;transition:all .35s;position:relative;overflow:hidden;
                  width:240px;flex-shrink:0;"
           onmouseover="this.style.borderColor='var(--gold)';this.style.transform='translateY(-6px)';this.style.boxShadow='0 18px 40px rgba(0,0,0,.1),0 0 0 1px var(--gold)'"
           onmouseout="this.style.borderColor='var(--border-light)';this.style.transform='';this.style.boxShadow=''">
            <!-- Glow -->
            <div style="position:absolute;top:-50px;right:-50px;width:120px;height:120px;border-radius:50%;background:radial-gradient(circle,rgba(212,168,73,.1),transparent 70%);"></div>
            <div style="font-size:2.2rem;margin-bottom:.75rem;"></div>
            <div class="font-serif" style="font-size:1.25rem;color:var(--ink);margin-bottom:.35rem;font-weight:500;"><?= esc($col['display_name']) ?></div>
            <div style="color:var(--copper);font-size:.72rem;letter-spacing:.12em;font-weight:700;"><?= $col['count'] ?> products</div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
</section>
<?php endif; ?>

<!-- ═══════════ BEST SELLERS (Dark) ═══════════ -->
<?php if (!empty($bestSellers)): ?>
<section style="padding:5rem 1.5rem;background:var(--bg);">
<div style="max-width:1440px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;" class="fade-up">
        <p class="section-subtitle">Most Loved</p>
        <h2 class="section-title" style="margin:.5rem 0;">Best <em>Sellers</em></h2>
        <div class="gold-line" style="margin:.875rem auto 0;"></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.5rem;">
        <?php foreach (array_slice($bestSellers, 0, 8) as $i => $p): ?>
        <div class="fade-up stagger-<?= min(($i%5)+1,5) ?>">
            <?= view('partials/product_card', ['p' => $p, 'wishlistedIds' => $wishlistedIds]) ?>
        </div>
        <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:3rem;">
        <a href="<?= site_url('best-sellers') ?>" class="btn-outline-neon" style="padding:.8rem 2.5rem;font-size:.78rem;border-radius:50px;">Explore Best Sellers →</a>
    </div>
</div>
</section>
<?php endif; ?>

<!-- ═══════════ FOUNDER'S PICK (Light) ═══════════ -->
<?php if (!empty($foundersPick)): ?>
<section class="section-light" style="padding:5rem 1.5rem;border-top:1px solid var(--border-light);">
<div style="max-width:1440px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;" class="fade-up">
        <p class="section-subtitle">Curated Selection</p>
        <h2 class="section-title" style="margin:.5rem 0;">Founder's <em>Pick</em></h2>
        <p style="color:var(--ink-soft);font-size:.95rem;margin-top:.625rem;">The very best of Smokey, handpicked for you</p>
        <div class="gold-line" style="margin:1rem auto 0;"></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:1.5rem;">
        <?php foreach ($foundersPick as $i => $p): ?>
        <div class="fade-up stagger-<?= min($i+1,5) ?>">
            <?= view('partials/product_card', ['p' => $p, 'wishlistedIds' => $wishlistedIds, 'light' => true]) ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</section>
<?php endif; ?>

<!-- ═══════════ BAR STYLING (Dark) ═══════════ -->
<section style="padding:5rem 1.5rem;background:var(--bg);">
<div style="max-width:1440px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;" class="fade-up">
        <p class="section-subtitle">Elevate Your Space</p>
        <h2 class="section-title" style="margin:.5rem 0;">Bar <em>Styling</em></h2>
        <div class="gold-line" style="margin:.875rem auto 0;"></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.5rem;">
        <?php foreach ([
            ['🗿', 'Sculptures',   'Figurines & statement pieces',  'category/sculpture'],
            ['💡', 'Lights & Lamps','Ambience that sets the mood',  'shop?q=lights'],
            ['🍽️', 'Serveware',    'Platters, trays & dineware',   'category/serveware'],
            ['☕', 'Coffee & Tea', 'Morning rituals, elevated',     'category/tea-coffee'],
        ] as $i => [$em,$title,$sub,$url]): ?>
        <a href="<?= site_url($url) ?>" class="fade-up stagger-<?= $i+1 ?>"
           style="text-decoration:none;display:flex;flex-direction:column;align-items:center;justify-content:center;
                  text-align:center;padding:2.5rem 1.5rem;border:1px solid var(--border);border-radius:14px;
                  background:linear-gradient(180deg,#1c1812,#141010);transition:all .4s;position:relative;overflow:hidden;"
           onmouseover="this.style.borderColor='rgba(212,168,73,.5)';this.style.transform='translateY(-8px)';this.style.boxShadow='0 20px 50px rgba(0,0,0,.6),0 0 40px rgba(212,168,73,.1)'"
           onmouseout="this.style.borderColor='var(--border)';this.style.transform='';this.style.boxShadow=''">
            <div style="position:absolute;top:-30px;left:50%;transform:translateX(-50%);width:120px;height:120px;border-radius:50%;background:radial-gradient(circle,rgba(212,168,73,.12),transparent 70%);filter:blur(20px);"></div>
            <div style="font-size:2.5rem;margin-bottom:1rem;animation:icon-float <?= 4+$i ?>s ease-in-out infinite;"><?= $em ?></div>
            <h3 class="font-serif" style="font-size:1.25rem;color:var(--text);margin-bottom:.35rem;font-weight:500;"><?= $title ?></h3>
            <p style="color:var(--muted);font-size:.78rem;"><?= $sub ?></p>
            <div style="margin-top:1rem;font-size:.7rem;color:var(--gold-neon);letter-spacing:.1em;font-weight:700;text-transform:uppercase;">Shop →</div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
</section>

<!-- ═══════════ ALSO AVAILABLE ON (Light) ═══════════ -->
<section class="section-light" style="padding:4rem 1.5rem;border-top:1px solid var(--border-light);">
<div style="max-width:1440px;margin:0 auto;text-align:center;" class="fade-in">
    <p style="font-size:.7rem;letter-spacing:.25em;text-transform:uppercase;color:var(--copper);margin-bottom:2rem;font-weight:700;">Also Available On</p>
    <div style="display:flex;justify-content:center;align-items:center;flex-wrap:wrap;gap:1.5rem 3rem;">
        <?php foreach ([
            ['Amazon',   'https://www.amazon.in/s?k=smokey+cocktail'],
            ['Flipkart',  'https://www.flipkart.com/search?q=smokey+cocktail'],
            ['Tata Cliq', 'https://www.tatacliq.com/search/?searchCategory=all&text=smokey%20cocktail'],
            ['Nykaa',     'https://www.nykaafashion.com/designers/smokey-cocktail/c/66844'],
            ['Myntra',    'https://www.myntra.com/smokey-cocktail'],
        ] as [$name,$url]): ?>
        <a href="<?= $url ?>" target="_blank" rel="noopener"
           class="font-serif"
           style="font-size:1.2rem;color:var(--ink-soft);letter-spacing:.02em;font-weight:600;transition:all .3s;font-style:italic;text-decoration:none;border-bottom:1px solid transparent;padding-bottom:2px;"
           onmouseover="this.style.color='var(--copper)';this.style.borderBottomColor='var(--copper)'"
           onmouseout="this.style.color='var(--ink-soft)';this.style.borderBottomColor='transparent'"><?= $name ?></a>
        <?php endforeach; ?>
    </div>
</div>
</section>

<!-- ═══════════ WHY CHOOSE US — Animated Feature Cards ═══════════ -->
<section style="padding:5rem 1.5rem;background:linear-gradient(180deg,var(--bg) 0%,var(--bg-soft) 100%);">
<div style="max-width:1440px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;" class="fade-up">
        <p class="section-subtitle">Why Smokey</p>
        <h2 class="section-title" style="margin:.5rem 0;">The <em>Difference</em></h2>
        <div class="gold-line" style="margin:.875rem auto 0;"></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem;">
        <?php
        $features = [
            ['','Master Craftsmanship','Every piece is hand-crafted by artisans with decades of experience','#d4a849'],
            ['💎','Premium Quality','Lead-free crystal, food-safe materials, built to last generations','#a07cc8'],
            ['🎁','Gift Worthy','Beautifully packaged, perfect for any occasion or celebration','#5fb88a'],
            ['🚀','Fast Delivery','Carefully packed & dispatched within 2 days across India','#5fa8d4'],
        ];
        foreach($features as $i => [$emoji,$title,$desc,$color]): ?>
        <div class="fade-up stagger-<?= $i+1 ?>"
             style="background:linear-gradient(180deg,#1c1812 0%,#141010 100%);border:1px solid var(--border);
                    border-radius:14px;padding:2rem 1.5rem;text-align:center;transition:all .4s;position:relative;overflow:hidden;cursor:pointer;"
             onmouseover="this.style.borderColor='<?= $color ?>';this.style.transform='translateY(-8px) rotateY(3deg)';this.style.boxShadow='0 20px 50px rgba(0,0,0,.5),0 0 40px <?= $color ?>33'"
             onmouseout="this.style.borderColor='var(--border)';this.style.transform='';this.style.boxShadow=''">
            <!-- Animated glow ring -->
            <div style="position:absolute;top:-30px;left:50%;transform:translateX(-50%);width:120px;height:120px;border-radius:50%;background:radial-gradient(circle,<?= $color ?>33,transparent 70%);filter:blur(20px);pointer-events:none;"></div>

            <div style="position:relative;width:80px;height:80px;margin:0 auto 1.25rem;border-radius:20px;
                        background:linear-gradient(135deg,<?= $color ?>22,<?= $color ?>11);
                        border:2px solid <?= $color ?>44;display:flex;align-items:center;justify-content:center;
                        font-size:2.5rem;transition:all .3s;animation:icon-float <?= 4+$i ?>s ease-in-out infinite;">
                <?= $emoji ?>
            </div>
            <h3 class="font-serif" style="font-size:1.2rem;color:var(--text);margin-bottom:.5rem;font-weight:500;"><?= $title ?></h3>
            <p style="color:var(--muted);font-size:.82rem;line-height:1.6;"><?= $desc ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</section>

<!-- ═══════════ NEWSLETTER (Dark + Neon) ═══════════ -->
<section style="padding:5rem 1.5rem;background:linear-gradient(135deg,var(--bg) 0%,#1a1208 50%,var(--bg) 100%);text-align:center;position:relative;overflow:hidden;">
    <!-- Glow -->
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:600px;height:300px;background:radial-gradient(ellipse,rgba(255,217,102,.15),transparent 70%);filter:blur(50px);pointer-events:none;"></div>

    <div style="max-width:620px;margin:0 auto;position:relative;" class="fade-up">
        <div style="font-size:3rem;margin-bottom:1rem;filter:drop-shadow(0 0 20px rgba(255,217,102,.5));">🎁</div>
        <p class="section-subtitle" style="margin-bottom:.75rem;">Join the Club</p>
        <h2 class="section-title" style="margin-bottom:1rem;">Get <em>10% Off</em> Your First Order</h2>
        <p style="color:var(--muted);font-size:.95rem;margin-bottom:2.25rem;line-height:1.75;">Subscribe for exclusive offers, cocktail inspiration & early access to new arrivals.</p>
        <form style="display:flex;gap:.625rem;max-width:440px;margin:0 auto;"
              onsubmit="event.preventDefault();this.innerHTML='<div style=&quot;color:var(--gold-neon);font-size:1rem;padding:1rem;text-shadow:0 0 15px rgba(255,217,102,.5)&quot;>🎉 You\'re subscribed! Check your inbox.</div>'">
            <input type="email" placeholder="Your email address" required style="flex:1;padding:.95rem 1.2rem;border-radius:50px;font-size:.875rem;">
            <button type="submit" class="btn-neon" style="padding:.95rem 2rem;font-size:.78rem;border-radius:50px;white-space:nowrap;">Subscribe</button>
        </form>
        <p style="font-size:.68rem;color:var(--dim);margin-top:1rem;">No spam. Unsubscribe anytime.</p>
    </div>
</section>

<!-- ═══════════ BLOG (Light) ═══════════ -->
<?php if (!empty($recentPosts)): ?>
<section class="section-light" style="padding:5rem 1.5rem;">
<div style="max-width:1440px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;" class="fade-up">
        <p class="section-subtitle">Stories</p>
        <h2 class="section-title" style="margin:.5rem 0;">First Look <em>Articles</em></h2>
        <div class="gold-line" style="margin:.875rem auto 0;"></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.75rem;">
        <?php foreach ($recentPosts as $i => $post): ?>
        <a href="<?= site_url('blog/'.$post['slug']) ?>"
           class="fade-up stagger-<?= $i+1 ?>"
           style="text-decoration:none;background:#fff;border:1px solid var(--border-light);border-radius:12px;
                  overflow:hidden;transition:all .35s;display:block;"
           onmouseover="this.style.borderColor='var(--gold)';this.style.transform='translateY(-6px)';this.style.boxShadow='0 18px 40px rgba(0,0,0,.1)'"
           onmouseout="this.style.borderColor='var(--border-light)';this.style.transform='';this.style.boxShadow=''">
            <?php if ($post['cover_image']): ?>
            <div style="aspect-ratio:16/9;overflow:hidden;background:var(--bg-light2);">
                <img src="<?= esc(str_starts_with($post['cover_image'],'http')?$post['cover_image']:base_url($post['cover_image'])) ?>"
                     alt="<?= esc($post['title']) ?>" loading="lazy"
                     style="width:100%;height:100%;object-fit:cover;transition:transform .6s;"
                     onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform=''">
            </div>
            <?php else: ?>
            <div style="aspect-ratio:16/9;background:var(--bg-light2);display:flex;align-items:center;justify-content:center;font-size:2.5rem;opacity:.4;">📖</div>
            <?php endif; ?>
            <div style="padding:1.5rem;">
                <p style="font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;color:var(--copper);margin-bottom:.625rem;font-weight:700;"><?= esc($post['author'] ?? 'Smokey Team') ?></p>
                <h3 class="font-serif" style="font-size:1.3rem;color:var(--ink);line-height:1.35;margin-bottom:.5rem;font-weight:500;"><?= esc($post['title']) ?></h3>
                <p style="font-size:.82rem;color:var(--ink-soft);line-height:1.65;"><?= esc(mb_substr(strip_tags($post['excerpt'] ?? ''), 0, 110)) ?>…</p>
                <span style="font-size:.78rem;color:var(--copper);display:block;margin-top:1rem;font-weight:700;">Read more →</span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
</section>
<?php endif; ?>

<!-- ═══════════ BULK CTA (Dark + Glow) ═══════════ -->
<section style="padding:5rem 1.5rem;background:var(--bg);position:relative;overflow:hidden;">
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:700px;height:400px;background:radial-gradient(ellipse,rgba(255,217,102,.08),transparent 70%);filter:blur(60px);"></div>

<div style="max-width:720px;margin:0 auto;text-align:center;position:relative;
            background:linear-gradient(135deg,rgba(28,24,18,.9),rgba(20,16,16,.8));
            border:1px solid rgba(212,168,73,.25);padding:3.5rem 3rem;border-radius:20px;
            backdrop-filter:blur(20px);box-shadow:0 25px 60px rgba(0,0,0,.5),inset 0 1px 0 rgba(212,168,73,.15);" class="fade-up">
    <div style="font-size:3rem;margin-bottom:1rem;filter:drop-shadow(0 0 20px rgba(255,217,102,.4));"></div>
    <p class="section-subtitle">For Businesses</p>
    <h2 class="section-title" style="margin:.5rem 0;">See It. Love It. <em>Buy It.</em></h2>
    <div class="gold-line" style="margin:.875rem auto;"></div>
    <p style="color:var(--muted);font-size:.95rem;margin:1rem 0 2.5rem;line-height:1.7;">Planning a bulk order or corporate gifting?<br>We'd love to help elevate every occasion.</p>
    <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;">
        <a href="https://wa.me/919876543210" target="_blank"
           style="padding:.95rem 2rem;font-size:.78rem;border-radius:50px;text-transform:uppercase;letter-spacing:.08em;display:flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,#1ebe57,#25D366);color:#fff;text-decoration:none;font-weight:700;box-shadow:0 4px 20px rgba(37,211,102,.4);transition:all .25s;"
           onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 30px rgba(37,211,102,.5)'" onmouseout="this.style.transform='';this.style.boxShadow='0 4px 20px rgba(37,211,102,.4)'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
            WhatsApp Us
        </a>
        <a href="mailto:<?= esc(brand_setting('contact_email','hello@smokeycocktail.com')) ?>"
           class="btn-outline-neon" style="padding:.95rem 2rem;font-size:.78rem;border-radius:50px;">Email Us</a>
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
        if(d){
            d.style.width = i===n ? '40px' : '12px';
            d.style.background = i===n ? 'var(--gold-neon)' : 'rgba(255,217,102,.2)';
            d.style.boxShadow = i===n ? '0 0 15px rgba(255,217,102,.6)' : 'none';
        }
    });
}
setInterval(() => goSlide((cur+1) % slides.length), 4500);
</script>

<?php endif; // end logged-in home ?>

<?= $this->endSection() ?>
