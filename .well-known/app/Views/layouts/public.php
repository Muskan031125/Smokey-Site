<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Smokey Cocktail') ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600&family=Dancing+Script:wght@600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0;}
:root{
  /* Dark+Neon mix theme */
  --bg:#0a0808;
  --bg-soft:#141010;
  --bg-light:#f5f1e8;       /* light sections */
  --bg-light2:#ebe6d8;
  --white:#ffffff;
  --black:#0a0808;
  --gold:#d4a849;
  --gold-bright:#f0c060;
  --gold-neon:#ffd966;
  --copper:#c47d4a;
  --rose:#d4878a;
  --emerald:#5fb88a;
  --ink:#1a1612;
  --ink-soft:#3a342a;
  --text:#f0e8d4;
  --text-light:#1a1612;
  --muted:#9a9080;
  --dim:#5a544a;
  --border:#2a241c;
  --border-light:#d8d2c4;
  --red:#e6504a;
  --green:#22c55e;
  --neon-glow:0 0 30px rgba(255,217,102,.5),0 0 60px rgba(255,217,102,.3),0 0 100px rgba(255,217,102,.15);
  /* Aliases used by cart/checkout pages */
  --white:#ffffff;
  --black:#1a1612;
  --cream:#f5f1e8;
  --border-soft:#d8d2c4;
  --gold-warm:#c47d4a;
}
/* btn-primary / btn-outline used by cart & checkout */
.btn-primary{background:var(--ink);color:#fff;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
  transition:all .25s;border:none;cursor:pointer;display:inline-block;text-decoration:none;border-radius:4px;}
.btn-primary:hover{background:#000;transform:translateY(-2px);box-shadow:0 8px 20px rgba(0,0,0,.4);}
.btn-outline{border:1.5px solid var(--ink);color:var(--ink);background:transparent;font-weight:600;
  letter-spacing:.07em;text-transform:uppercase;cursor:pointer;display:inline-block;text-decoration:none;
  transition:all .25s;border-radius:4px;}
.btn-outline:hover{background:var(--ink);color:#fff;}
html{scroll-behavior:smooth;}
body{background:linear-gradient(160deg,#0e0c0a 0%,#16120e 40%,#1a1510 70%,#0e0c0a 100%);color:var(--text);font-family:'Inter',sans-serif;font-size:14px;overflow-x:hidden;overflow-y:auto;}
.font-serif{font-family:'Crimson Pro',Georgia,serif;}
.font-script{font-family:'Dancing Script',cursive;}

/* ─── ANIMATIONS ───────────────────────── */
@keyframes fadeUp{0%{opacity:0;transform:translateY(30px)}100%{opacity:1;transform:translateY(0)}}
@keyframes fadeIn{0%{opacity:0}100%{opacity:1}}
@keyframes glow{0%,100%{text-shadow:0 0 15px rgba(255,217,102,.5),0 0 30px rgba(255,217,102,.3)}50%{text-shadow:0 0 25px rgba(255,217,102,.7),0 0 50px rgba(255,217,102,.4)}}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
@keyframes shimmer{0%{background-position:-200% center}100%{background-position:200% center}}
@keyframes pulse-glow{0%,100%{box-shadow:0 0 20px rgba(212,168,73,.4)}50%{box-shadow:0 0 40px rgba(212,168,73,.7),0 0 80px rgba(212,168,73,.3)}}
@keyframes spin-slow{from{transform:rotate(0)}to{transform:rotate(360deg)}}
@keyframes smoke{0%{transform:translateY(0) scale(1);opacity:.4}100%{transform:translateY(-100px) scale(1.5);opacity:0}}
@keyframes neon-line{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
@keyframes bubble-up{0%{transform:translateY(0) translateX(0);opacity:0}10%{opacity:.7}50%{transform:translateY(-300px) translateX(20px);opacity:.5}100%{transform:translateY(-600px) translateX(-20px);opacity:0}}
@keyframes ice-rotate{0%{transform:rotate(0) scale(1)}50%{transform:rotate(15deg) scale(1.08)}100%{transform:rotate(0) scale(1)}}
@keyframes icon-float{0%,100%{transform:translateY(0) rotate(0)}50%{transform:translateY(-25px) rotate(8deg)}}

.gold-orb{position:absolute;width:6px;height:6px;border-radius:50%;
  background:radial-gradient(circle,rgba(255,217,102,.9),rgba(212,168,73,.3) 60%,transparent 80%);
  box-shadow:0 0 20px rgba(255,217,102,.6),0 0 40px rgba(255,217,102,.3);
  animation:icon-float 6s ease-in-out infinite;pointer-events:none;z-index:3;}

.fade-up{opacity:0;transform:translateY(30px);transition:opacity .8s cubic-bezier(.25,.46,.45,.94),transform .8s cubic-bezier(.25,.46,.45,.94);}
.fade-up.visible{opacity:1;transform:translateY(0);}
.fade-in{opacity:0;transition:opacity .9s ease;}
.fade-in.visible{opacity:1;}
.stagger-1{transition-delay:.08s!important;}
.stagger-2{transition-delay:.16s!important;}
.stagger-3{transition-delay:.24s!important;}
.stagger-4{transition-delay:.32s!important;}
.stagger-5{transition-delay:.4s!important;}

/* ─── BUTTONS ───────────────────────── */
.btn-neon{background:linear-gradient(135deg,#d4a849,#ffd966,#d4a849);background-size:200% auto;
  color:#0a0808;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
  transition:all .3s;border:none;cursor:pointer;display:inline-block;text-decoration:none;
  position:relative;overflow:hidden;animation:shimmer 4s linear infinite;
  box-shadow:0 4px 20px rgba(212,168,73,.4);}
.btn-neon:hover{transform:translateY(-3px);box-shadow:0 8px 30px rgba(255,217,102,.6),0 0 60px rgba(255,217,102,.3);}

.btn-outline-neon{background:transparent;border:1.5px solid var(--gold);color:var(--gold);
  font-weight:600;letter-spacing:.08em;text-transform:uppercase;transition:all .3s;
  cursor:pointer;display:inline-block;text-decoration:none;position:relative;overflow:hidden;}
.btn-outline-neon::before{content:'';position:absolute;inset:0;background:linear-gradient(90deg,transparent,rgba(255,217,102,.2),transparent);
  transform:translateX(-100%);transition:transform .5s;}
.btn-outline-neon:hover::before{transform:translateX(100%);}
.btn-outline-neon:hover{border-color:var(--gold-neon);color:var(--gold-neon);
  box-shadow:0 0 25px rgba(255,217,102,.4),inset 0 0 25px rgba(255,217,102,.1);transform:translateY(-3px);}

.btn-light{background:#fff;color:var(--ink);font-weight:700;letter-spacing:.06em;
  transition:all .25s;border:none;cursor:pointer;display:inline-block;text-decoration:none;}
.btn-light:hover{background:var(--gold-neon);transform:translateY(-2px);box-shadow:0 8px 25px rgba(255,217,102,.4);}

.btn-dark{background:var(--ink);color:#fff;font-weight:600;letter-spacing:.06em;
  transition:all .25s;border:none;cursor:pointer;display:inline-block;text-decoration:none;}
.btn-dark:hover{background:#000;transform:translateY(-2px);box-shadow:0 8px 20px rgba(0,0,0,.3);}

/* ─── PRODUCT CARDS (Dark mode) ───────────────────────── */
.product-card{background:linear-gradient(180deg,#1c1812 0%,#141010 100%);
  border:1px solid var(--border);transition:all .4s cubic-bezier(.25,.46,.45,.94);
  position:relative;overflow:hidden;}
.product-card::after{content:'';position:absolute;top:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,transparent,var(--gold),transparent);
  transform:scaleX(0);transition:transform .4s;}
.product-card:hover::after{transform:scaleX(1);}
.product-card:hover{border-color:rgba(212,168,73,.5);transform:translateY(-8px);
  box-shadow:0 20px 50px rgba(0,0,0,.6),0 0 0 1px rgba(212,168,73,.2),0 0 40px rgba(212,168,73,.1);}
.card-img{transition:transform .7s cubic-bezier(.25,.46,.45,.94);width:100%;height:100%;object-fit:cover;}
.product-card:hover .card-img{transform:scale(1.08);}

/* Light card variant for light sections */
.product-card-light{background:#fff;border:1px solid var(--border-light);transition:all .4s;position:relative;overflow:hidden;}
.product-card-light:hover{border-color:var(--gold);transform:translateY(-6px);box-shadow:0 20px 40px rgba(0,0,0,.08),0 0 0 1px rgba(212,168,73,.2);}
.product-card-light:hover .card-img{transform:scale(1.06);}

/* ─── WISHLIST HEART ───────────────────────── */
.wish-btn{position:absolute;top:12px;right:12px;z-index:10;width:38px;height:38px;
  background:rgba(10,8,8,.85);border-radius:50%;border:1px solid rgba(255,217,102,.2);
  cursor:pointer;display:flex;align-items:center;justify-content:center;
  transition:all .3s;backdrop-filter:blur(10px);}
.wish-btn:hover{background:rgba(212,168,73,.2);border-color:rgba(255,217,102,.6);transform:scale(1.15);
  box-shadow:0 0 20px rgba(255,217,102,.4);}
.wish-btn svg{width:16px;height:16px;stroke:#d4a849;fill:none;transition:all .25s;}
.wish-btn.active svg{stroke:var(--red);fill:var(--red);}
.wish-btn.active{background:rgba(230,80,74,.2);border-color:var(--red);}

/* For light sections */
.product-card-light .wish-btn{background:rgba(255,255,255,.95);border-color:rgba(0,0,0,.1);}
.product-card-light .wish-btn svg{stroke:var(--ink);}

/* ─── NAVBAR ───────────────────────── */
.nav-top-bar{background:linear-gradient(90deg,var(--ink),var(--gold-bright) 50%,var(--ink));
  background-size:200% auto;animation:shimmer 6s linear infinite;
  color:#0a0808;text-align:center;padding:.5rem 1rem;font-size:.7rem;font-weight:700;letter-spacing:.15em;}

.main-nav{background:rgba(10,8,8,.92);border-bottom:1px solid rgba(212,168,73,.15);
  position:sticky;top:0;z-index:100;backdrop-filter:blur(20px) saturate(180%);}

.nav-link{color:var(--text);font-size:.78rem;letter-spacing:.08em;text-transform:uppercase;
  transition:all .25s;text-decoration:none;font-weight:500;padding:.3rem 0;white-space:nowrap;position:relative;}
.nav-link::after{content:'';position:absolute;bottom:-4px;left:50%;width:0;height:1px;
  background:var(--gold-neon);transition:all .25s;transform:translateX(-50%);}
.nav-link:hover{color:var(--gold-neon);}
.nav-link:hover::after{width:100%;box-shadow:0 0 10px rgba(255,217,102,.6);}

/* Dropdown */
.dropdown{position:relative;}
.dropdown-menu{position:absolute;top:calc(100% + 12px);left:-1rem;
  background:rgba(20,16,16,.98);border:1px solid rgba(212,168,73,.2);border-radius:10px;
  min-width:230px;padding:.6rem 0;opacity:0;visibility:hidden;
  transform:translateY(-10px) scale(.96);
  transition:all .25s cubic-bezier(.25,.46,.45,.94);z-index:200;
  box-shadow:0 25px 50px rgba(0,0,0,.7),0 0 40px rgba(212,168,73,.1);backdrop-filter:blur(20px);}
.dropdown:hover .dropdown-menu{opacity:1;visibility:visible;transform:translateY(0) scale(1);}
.dropdown-item{display:flex;align-items:center;gap:.5rem;padding:.6rem 1.1rem;color:var(--text);
  font-size:.8rem;transition:all .2s;text-decoration:none;letter-spacing:.02em;}
.dropdown-item:hover{color:var(--gold-neon);background:rgba(212,168,73,.08);padding-left:1.4rem;}
.dropdown-item::before{content:'·';color:var(--gold);}

/* Inputs */
input,select,textarea{background:rgba(20,16,16,.6)!important;border:1px solid rgba(212,168,73,.25)!important;
  color:var(--text)!important;border-radius:6px;font-family:'Inter',sans-serif;transition:all .25s;}
input:focus,select:focus,textarea:focus{border-color:var(--gold-neon)!important;outline:none!important;
  box-shadow:0 0 0 3px rgba(255,217,102,.15),0 0 20px rgba(255,217,102,.15)!important;background:rgba(20,16,16,.85)!important;}
input::placeholder{color:var(--muted)!important;}

/* Light inputs */
.input-light{background:#fff!important;border:1px solid var(--border-light)!important;color:var(--ink)!important;}
.input-light:focus{border-color:var(--gold)!important;box-shadow:0 0 0 3px rgba(212,168,73,.15)!important;}

/* Badges */
.badge-sale{background:linear-gradient(135deg,var(--red),#ff6b6b);color:#fff;
  font-size:.62rem;font-weight:800;padding:.2rem .55rem;border-radius:4px;letter-spacing:.06em;
  box-shadow:0 2px 12px rgba(230,80,74,.4);}
.badge-new{background:linear-gradient(135deg,var(--emerald),#5fd9a3);color:#0a0808;
  font-size:.62rem;font-weight:800;padding:.2rem .55rem;border-radius:4px;letter-spacing:.06em;
  box-shadow:0 2px 12px rgba(95,184,138,.4);}
.badge-sold-out{background:rgba(0,0,0,.85);color:#888;font-size:.65rem;
  font-weight:600;padding:.2rem .55rem;border-radius:4px;border:1px solid rgba(255,255,255,.1);}

/* Section titles */
.section-title{font-family:'Crimson Pro',Georgia,serif;font-size:clamp(2.2rem,4.5vw,3.5rem);
  font-weight:400;color:var(--text);line-height:1.15;letter-spacing:.01em;}
.section-title em{color:var(--gold-neon);font-style:italic;animation:glow 4s ease-in-out infinite;}
.section-subtitle{font-size:.7rem;letter-spacing:.25em;text-transform:uppercase;color:var(--gold);font-weight:600;}
.gold-line{width:60px;height:2px;background:linear-gradient(90deg,transparent,var(--gold-neon),transparent);
  box-shadow:0 0 12px rgba(255,217,102,.5);}

/* Icon badges */
.icon-badge{background:var(--gold-neon);color:#0a0808;
  border-radius:50%;font-size:.6rem;font-weight:800;min-width:18px;height:18px;
  display:inline-flex;align-items:center;justify-content:center;
  position:absolute;top:-7px;right:-7px;
  box-shadow:0 0 12px rgba(255,217,102,.6);}

/* Flash */
.flash-success{background:rgba(95,184,138,.1);border:1px solid rgba(95,184,138,.3);
  color:var(--emerald);border-radius:6px;padding:.75rem 1rem;font-size:.85rem;}
.flash-error{background:rgba(230,80,74,.1);border:1px solid rgba(230,80,74,.3);
  color:var(--red);border-radius:6px;padding:.75rem 1rem;font-size:.85rem;}

/* ─── GLOBAL RESPONSIVE IMAGES ─────────────────────────── */
img{max-width:100%;height:auto;}

/* ─── PRODUCT PAGE GRID ─────────────────────────── */
.product-page-grid{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:3.5rem;
  align-items:start;
}
/* ─── CART GRID ─────────────────────────── */
.cart-grid{
  display:grid;
  grid-template-columns:1fr 380px;
  gap:2rem;
  align-items:start;
}

/* ─── RESPONSIVE BREAKPOINTS ─────────────────────────── */
@media(max-width:900px){
  .product-page-grid{grid-template-columns:1fr;gap:2rem;}
}
@media(max-width:768px){
  /* Shop/home product grids */
  div[style*="minmax(220px"]{grid-template-columns:repeat(2,1fr)!important;}
  /* Cart */
  .cart-grid{grid-template-columns:1fr!important;}
  /* Checkout two-column */
  div[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr!important;}
  /* Bar collections */
  div[style*="minmax(230px"]{grid-template-columns:repeat(2,1fr)!important;}
  /* Footer grid */
  div[style*="2fr 1fr 1fr 1fr"]{grid-template-columns:1fr 1fr!important;}
  /* Category circles wrap correctly */
  .cat-circle{width:76px;height:76px;}
}
@media(max-width:480px){
  div[style*="minmax(220px"]{grid-template-columns:repeat(2,1fr)!important;}
  div[style*="2fr 1fr 1fr 1fr"]{grid-template-columns:1fr!important;}
  .cat-circle{width:64px;height:64px;}
  /* Stack checkout grids */
  div[style*="grid-template-columns:1fr 1fr 1fr"]{grid-template-columns:1fr 1fr!important;}
}

/* ─── SCROLLBAR ─────────────────────────── */
::-webkit-scrollbar{width:8px;height:8px;}
::-webkit-scrollbar-track{background:var(--bg);}
::-webkit-scrollbar-thumb{background:linear-gradient(180deg,var(--gold),var(--copper));border-radius:4px;}

/* Light section style */
.section-light{background:linear-gradient(180deg,var(--bg-light) 0%,var(--bg-light2) 100%);color:var(--text-light);}
.section-light .section-title{color:var(--ink);}
.section-light .section-title em{color:var(--copper);animation:none;}
.section-light .section-subtitle{color:var(--copper);}
.section-light .gold-line{background:linear-gradient(90deg,transparent,var(--gold),transparent);box-shadow:none;}

/* Circular category */
.cat-circle{width:96px;height:96px;border-radius:50%;
  background:linear-gradient(135deg,#1a1412,#0f0c0a);
  border:2px solid rgba(212,168,73,.3);
  display:flex;align-items:center;justify-content:center;color:var(--gold-neon);
  font-size:1.8rem;transition:all .4s;position:relative;}
.cat-circle::after{content:'';position:absolute;inset:-4px;border-radius:50%;
  background:linear-gradient(135deg,var(--gold-neon),var(--copper));
  opacity:0;transition:opacity .3s;z-index:-1;filter:blur(8px);}
.cat-circle:hover{transform:translateY(-6px) rotate(5deg);border-color:var(--gold-neon);
  box-shadow:0 0 30px rgba(255,217,102,.5);}
.cat-circle:hover::after{opacity:.4;}

/* Hero video */
.hero-video{position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;opacity:.22;filter:brightness(.7) contrast(1.1);}
.hero-overlay{position:absolute;inset:0;background:radial-gradient(ellipse at center,rgba(10,8,8,.4) 0%,rgba(10,8,8,.85) 70%,var(--bg) 100%),
  linear-gradient(180deg,rgba(10,8,8,.6) 0%,rgba(10,8,8,.5) 50%,var(--bg) 100%);}

/* Glow text */
.glow-text{text-shadow:0 0 30px rgba(255,217,102,.5),0 0 60px rgba(255,217,102,.3);}

/* Smoke particles */
.smoke-particle{position:absolute;width:80px;height:80px;border-radius:50%;
  background:radial-gradient(circle,rgba(212,168,73,.15) 0%,transparent 70%);
  animation:smoke 8s linear infinite;pointer-events:none;}
</style>
</head>
<body>

<!-- ═══ NAV ═══ -->
<?php $_loggedIn = auth()->loggedIn(); ?>
<nav class="main-nav">
<div style="max-width:1440px;margin:0 auto;padding:0 1.5rem;">

<?php if ($_loggedIn): ?>
<!-- ── LOGGED IN: full nav ── -->
<div class="nav-top-bar">
    ✦ Free shipping on orders above ₹5,000 &nbsp;·&nbsp; COD Available &nbsp;·&nbsp; Easy 7-day Returns ✦
</div>
    <div style="display:flex;align-items:center;justify-content:space-between;padding:.9rem 0;border-bottom:1px solid rgba(212,168,73,.08);">
        <button onclick="document.getElementById('search-form').classList.toggle('hidden')"
                style="background:none;border:none;cursor:pointer;color:var(--text);display:flex;align-items:center;gap:.3rem;font-size:.78rem;transition:color .2s;"
                onmouseover="this.style.color='var(--gold-neon)'" onmouseout="this.style.color='var(--text)'">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        </button>

        <a href="<?= site_url('/') ?>" style="text-decoration:none;display:flex;flex-direction:column;align-items:center;">
            <div class="font-serif" style="font-size:1.4rem;font-weight:600;color:var(--text);letter-spacing:.1em;">SMOKEY COCKTAIL</div>
            <div style="font-size:.6rem;letter-spacing:.5em;color:var(--gold-neon);margin-top:2px;">LET'S PARTY</div>
        </a>

        <div style="display:flex;align-items:center;gap:1.5rem;">
            <?php if (auth()->user()->inGroup('super_admin') || auth()->user()->inGroup('inventory_manager') || auth()->user()->inGroup('viewer')): ?>
            <a href="<?= site_url('admin') ?>"
               style="text-decoration:none;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
                      padding:.35rem .9rem;border-radius:50px;color:#0a0808;
                      background:linear-gradient(135deg,var(--gold),var(--gold-neon));transition:all .2s;white-space:nowrap;"
               onmouseover="this.style.boxShadow='0 0 20px rgba(255,217,102,.5)';this.style.transform='translateY(-1px)'"
               onmouseout="this.style.boxShadow='';this.style.transform=''">⚙ Admin</a>
            <?php else: ?>
            <a href="<?= site_url('account/profile') ?>" style="text-decoration:none;color:var(--text);transition:color .2s;" title="Account"
               onmouseover="this.style.color='var(--gold-neon)'" onmouseout="this.style.color='var(--text)'">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </a>
            <?php endif; ?>

            <a href="<?= site_url('wishlist') ?>" style="position:relative;text-decoration:none;color:var(--text);transition:color .2s;" title="Wishlist"
               onmouseover="this.style.color='var(--gold-neon)'" onmouseout="this.style.color='var(--text)'">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <?php
                $wModel = new \App\Models\WishlistModel();
                $wSid   = session()->get('__cart_sid') ?? '';
                $wUid   = (int)auth()->user()->id;
                $wCount = count($wModel->getProductIds($wSid, $wUid));
                ?>
                <span class="icon-badge" id="wishlist-count" style="<?= $wCount > 0 ? '' : 'display:none' ?>"><?= $wCount ?></span>
            </a>

            <a href="<?= site_url('cart') ?>" style="position:relative;text-decoration:none;color:var(--text);display:flex;align-items:center;gap:.3rem;transition:color .2s;"
               onmouseover="this.style.color='var(--gold-neon)'" onmouseout="this.style.color='var(--text)'">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <?php
                $cModel = new \App\Models\CartModel();
                $cSid   = session()->get('__cart_sid') ?? '';
                $cCount = $cModel->countItems($cSid, $wUid);
                ?>
                <span style="font-size:.78rem;font-weight:600;">(<?= $cCount ?>)</span>
            </a>

            <button id="mobile-btn" style="background:none;border:none;cursor:pointer;color:var(--text);display:flex;align-items:center;" class="md:hidden">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
        </div>
    </div>

    <!-- Search -->
    <form id="search-form" action="<?= site_url('shop') ?>" method="get" class="hidden" style="padding:.875rem 0;border-bottom:1px solid rgba(212,168,73,.1);">
        <div style="display:flex;max-width:600px;margin:0 auto;gap:.5rem;">
            <input type="text" name="q" autofocus placeholder="What are you looking for?" style="flex:1;padding:.7rem 1rem;font-size:.85rem;border-radius:6px;">
            <button type="submit" class="btn-neon" style="padding:.7rem 1.75rem;font-size:.75rem;border-radius:6px;">SEARCH</button>
        </div>
    </form>

<?php else: ?>
<!-- ── LOGGED OUT: minimal nav ── -->
    <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 0;">
        <a href="<?= site_url('/') ?>" style="text-decoration:none;display:flex;flex-direction:column;align-items:center;">
            <div class="font-serif" style="font-size:1.3rem;font-weight:600;color:var(--text);letter-spacing:.1em;">SMOKEY COCKTAIL</div>
            <div style="font-size:.58rem;letter-spacing:.5em;color:var(--gold-neon);margin-top:1px;">LET'S PARTY</div>
        </a>
        <div style="display:flex;align-items:center;gap:.75rem;">
            <a href="<?= site_url('register') ?>"
               style="font-size:.72rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);text-decoration:none;transition:color .2s;padding:.4rem .8rem;"
               onmouseover="this.style.color='var(--gold-neon)'" onmouseout="this.style.color='var(--muted)'">Register</a>
            <a href="<?= site_url('login') ?>"
               style="font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
                      padding:.45rem 1.25rem;border-radius:50px;color:#0a0808;
                      background:linear-gradient(135deg,var(--gold),var(--gold-neon));
                      text-decoration:none;transition:all .2s;"
               onmouseover="this.style.boxShadow='0 0 20px rgba(255,217,102,.4)'" onmouseout="this.style.boxShadow=''">Login →</a>
        </div>
    </div>
<?php endif; ?>

    <?php if ($_loggedIn): ?>
    <div class="hidden md:flex items-center justify-center gap-8 py-3.5">
        <a href="<?= site_url('new-arrivals') ?>" class="nav-link">New Arrivals</a>
        <a href="<?= site_url('best-sellers') ?>" class="nav-link">Best Sellers</a>

        <div class="dropdown">
            <a href="<?= site_url('shop') ?>" class="nav-link" style="display:flex;align-items:center;gap:.25rem;">
                Barware <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
            </a>
            <div class="dropdown-menu">
                <?php foreach ([
                    'bar-accessories'=>'Bar Accessories','whi-glasses'=>'Whiskey Glasses',
                    'cocktail-glass'=>'Cocktail Glasses','wine-glasses'=>'Wine & Champagne',
                    'tall-glass'=>'Tall Glasses','shot-glass'=>'Shot Glasses',
                    'decanter'=>'Decanters','beer-mug'=>'Beer Mugs','ice-maker'=>'Ice Maker',
                ] as $slug => $label): ?>
                <a href="<?= site_url('category/'.$slug) ?>" class="dropdown-item"><?= $label ?></a>
                <?php endforeach; ?>
            </div>
        </div>

        <a href="<?= site_url('category/serveware') ?>" class="nav-link">Dineware</a>

        <div class="dropdown">
            <a href="<?= site_url('shop') ?>" class="nav-link" style="display:flex;align-items:center;gap:.25rem;">
                Decor <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
            </a>
            <div class="dropdown-menu">
                <?php foreach ([
                    'sculpture'=>'Sculptures','centrepiece'=>'Centrepiece',
                    'humidifier'=>'Humidifier','lights'=>'Lights & Lamps',
                    'bath-accessories'=>'Bath Accessories','vases-planters'=>'Vases & Planters',
                    'wall-decor'=>'Wall Art','candleware'=>'Candles',
                ] as $slug => $label): ?>
                <a href="<?= site_url('category/'.$slug) ?>" class="dropdown-item"><?= $label ?></a>
                <?php endforeach; ?>
            </div>
        </div>

        <a href="<?= site_url('category/tea-coffee') ?>" class="nav-link">Tea &amp; Coffee</a>
        <a href="<?= site_url('blog') ?>" class="nav-link">Blog</a>
        <a href="<?= site_url('sale') ?>" class="nav-link" style="color:var(--red);">🔥 Sale</a>
        <a href="https://wa.me/919876543210?text=Hi%20I%27m%20interested%20in%20bulk%20orders" target="_blank" rel="noopener" class="nav-link">Bulk</a>
    </div>

    <!-- Mobile drawer (logged in) -->
    <div id="mobile-menu" class="hidden" style="background:rgba(10,8,8,.98);border-top:1px solid var(--border);padding:1rem 1.5rem;backdrop-filter:blur(20px);">
        <?php foreach ([
            ['New Arrivals','new-arrivals'],['Best Sellers','best-sellers'],['All Products','shop'],
            ['Sculptures','category/sculpture'],['Dineware','category/serveware'],['Blog','blog'],
        ] as [$l,$u]): ?>
        <a href="<?= site_url($u) ?>" class="block nav-link" style="padding:.7rem 0;border-bottom:1px solid var(--border);"><?= $l ?></a>
        <?php endforeach; ?>
        <a href="<?= site_url('sale') ?>" class="block" style="padding:.7rem 0;color:var(--red);font-weight:600;border-bottom:1px solid var(--border);">🔥 Sale</a>
        <a href="https://wa.me/919876543210?text=Hi%20I%27m%20interested%20in%20bulk%20orders" target="_blank" rel="noopener" class="block nav-link" style="padding:.7rem 0;border-bottom:1px solid var(--border);">Bulk</a>
        <a href="<?= site_url('wishlist') ?>" class="block nav-link" style="padding:.7rem 0;border-bottom:1px solid var(--border);">Wishlist (<?= $wCount ?? 0 ?>)</a>
        <a href="<?= site_url('orders') ?>" class="block nav-link" style="padding:.7rem 0;border-bottom:1px solid var(--border);">My Orders</a>
        <a href="<?= site_url('logout') ?>" class="block nav-link" style="padding:.7rem 0;color:var(--red);">Logout</a>
    </div>
    <?php endif; // logged in nav ?>
</div>
</nav>

<!-- Flash -->
<?php if (session()->has('success') || session()->has('error')): ?>
<div style="max-width:1440px;margin:.875rem auto;padding:0 1.5rem;">
    <?php if (session()->has('success')): ?><div class="flash-success"><?= esc(session('success')) ?></div><?php endif; ?>
    <?php if (session()->has('error')): ?><div class="flash-error"><?= esc(session('error')) ?></div><?php endif; ?>
</div>
<?php endif; ?>

<?= $this->renderSection('content') ?>

<!-- WhatsApp Float -->
<a href="https://wa.me/919876543210?text=Hi%20Smokey!" target="_blank" rel="noopener"
   style="position:fixed;bottom:28px;right:28px;z-index:999;width:56px;height:56px;
          background:linear-gradient(135deg,#1ebe57,#25D366);border-radius:50%;
          display:flex;align-items:center;justify-content:center;
          box-shadow:0 4px 24px rgba(37,211,102,.5),0 0 0 4px rgba(37,211,102,.15);
          text-decoration:none;animation:float 3s ease-in-out infinite;transition:transform .2s;"
   onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform=''">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
</a>

<!-- Footer -->
<footer style="background:linear-gradient(180deg,var(--bg-soft) 0%,var(--bg) 100%);border-top:1px solid rgba(212,168,73,.2);margin-top:5rem;padding:4.5rem 0 1.5rem;position:relative;overflow:hidden;">
<!-- Decorative line -->
<div style="position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--gold-neon),transparent);box-shadow:0 0 20px rgba(255,217,102,.4);"></div>

<div style="max-width:1440px;margin:0 auto;padding:0 1.5rem;">
    <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:3rem;margin-bottom:3rem;" class="grid-cols-2 md:grid-cols-4">
        <div>
            <div class="font-serif" style="font-size:1.5rem;font-weight:600;color:var(--text);letter-spacing:.05em;margin-bottom:.25rem;">SMOKEY COCKTAIL</div>
            <div style="font-size:.65rem;letter-spacing:.4em;color:var(--gold-neon);margin-bottom:1.25rem;">LET'S PARTY</div>
            <p style="color:var(--muted);font-size:.8rem;line-height:1.7;max-width:260px;margin-bottom:1.25rem;">
                Handcrafted barware, sculptures & cocktail essentials for those who take their craft seriously.
            </p>
            <div style="display:flex;gap:.625rem;">
                <?php
                $socials = [
                    ['Facebook',  'https://facebook.com/',  '<path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>'],
                    ['Instagram', 'https://instagram.com/', '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>'],
                    ['YouTube',   'https://youtube.com/',   '<path d="M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 00-1.94 2A29 29 0 001 11.75a29 29 0 00.46 5.33A2.78 2.78 0 003.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 001.94-2 29 29 0 00.46-5.25 29 29 0 00-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="currentColor"/>'],
                    ['WhatsApp',  'https://wa.me/919876543210', '<path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.64.08-.3-.15-1.26-.46-2.39-1.48-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.18.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.66-1.61-.91-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.08-.79.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.06 2.87 1.21 3.07.15.2 2.1 3.2 5.08 4.49.7.3 1.26.49 1.69.62.71.23 1.36.2 1.87.12.57-.08 1.76-.72 2-1.41.25-.7.25-1.29.18-1.41-.08-.13-.28-.2-.58-.35M12 2C6.5 2 2 6.5 2 12c0 1.7.43 3.3 1.2 4.7L2 22l5.4-1.16C8.78 21.58 10.34 22 12 22c5.5 0 10-4.5 10-10S17.5 2 12 2"/>'],
                ];
                foreach ($socials as [$name, $url, $svg]):
                ?>
                <a href="<?= $url ?>" target="_blank" rel="noopener" aria-label="<?= $name ?>"
                   style="width:38px;height:38px;border:1px solid rgba(212,168,73,.25);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--gold);text-decoration:none;transition:all .25s;"
                   onmouseover="this.style.borderColor='var(--gold-neon)';this.style.color='var(--gold-neon)';this.style.background='rgba(212,168,73,.1)';this.style.boxShadow='0 0 20px rgba(255,217,102,.4)';this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.borderColor='rgba(212,168,73,.25)';this.style.color='var(--gold)';this.style.background='';this.style.boxShadow='';this.style.transform=''">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><?= $svg ?></svg>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php if (auth()->loggedIn()): ?>
        <div>
            <h4 style="font-size:.7rem;letter-spacing:.18em;text-transform:uppercase;color:var(--gold-neon);margin-bottom:1rem;font-weight:700;">Shop</h4>
            <?php foreach ([['New Arrivals','new-arrivals'],['Best Sellers','best-sellers'],['Barware','shop'],['Sculptures','category/sculpture'],['Sale','sale']] as [$l,$u]): ?>
            <a href="<?= site_url($u) ?>" style="display:block;color:var(--muted);font-size:.8rem;margin-bottom:.55rem;text-decoration:none;transition:all .2s;" onmouseover="this.style.color='var(--gold-neon)';this.style.paddingLeft='.3rem'" onmouseout="this.style.color='var(--muted)';this.style.paddingLeft=''"><?= $l ?></a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div>
            <h4 style="font-size:.7rem;letter-spacing:.18em;text-transform:uppercase;color:var(--gold-neon);margin-bottom:1rem;font-weight:700;">Access</h4>
            <a href="<?= site_url('login') ?>" style="display:block;color:var(--muted);font-size:.8rem;margin-bottom:.55rem;text-decoration:none;" onmouseover="this.style.color='var(--gold-neon)'" onmouseout="this.style.color='var(--muted)'">Login</a>
            <a href="<?= site_url('register') ?>" style="display:block;color:var(--muted);font-size:.8rem;margin-bottom:.55rem;text-decoration:none;" onmouseover="this.style.color='var(--gold-neon)'" onmouseout="this.style.color='var(--muted)'">Register</a>
        </div>
        <?php endif; ?>
        <div>
            <h4 style="font-size:.7rem;letter-spacing:.18em;text-transform:uppercase;color:var(--gold-neon);margin-bottom:1rem;font-weight:700;">Help</h4>
            <?php foreach ([
                ['Blog','blog'],
                ['About Us','https://smokeycocktail.com/pages/about-us'],
                ['Contact','https://smokeycocktail.com/pages/contact-us'],
                ['Bulk Enquiry','https://smokeycocktail.com/pages/bulk-inquiry'],
            ] as [$l,$u]): ?>
            <?php $isExt = str_starts_with($u,'http'); ?>
            <a href="<?= $isExt ? $u : site_url($u) ?>" <?= $isExt ? 'target="_blank" rel="noopener"' : '' ?>
               style="display:block;color:var(--muted);font-size:.8rem;margin-bottom:.55rem;text-decoration:none;transition:all .2s;"
               onmouseover="this.style.color='var(--gold-neon)';this.style.paddingLeft='.3rem'"
               onmouseout="this.style.color='var(--muted)';this.style.paddingLeft=''"><?= $l ?></a>
            <?php endforeach; ?>
        </div>
        <div>
            <h4 style="font-size:.7rem;letter-spacing:.18em;text-transform:uppercase;color:var(--gold-neon);margin-bottom:1rem;font-weight:700;">Contact</h4>
            <p style="font-size:.78rem;color:var(--muted);margin-bottom:.5rem;">📧 <?= esc(brand_setting('contact_email','hello@smokeycocktail.com')) ?></p>
            <p style="font-size:.78rem;color:var(--muted);margin-bottom:.5rem;">📞 <?= esc(brand_setting('contact_phone','+91 98765 43210')) ?></p>
            <p style="font-size:.78rem;color:var(--muted);">📍 <?= esc(brand_setting('contact_address','Mumbai')) ?></p>
        </div>
    </div>

    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;padding-top:1.75rem;border-top:1px solid rgba(212,168,73,.1);">
        <p style="font-size:.7rem;color:var(--dim);">© <?= date('Y') ?> Smokey Cocktail. All rights reserved.</p>
        <div style="display:flex;gap:1.5rem;flex-wrap:wrap;">
            <?php foreach ([
                'Privacy' => 'https://smokeycocktail.com/pages/privacy-policy',
                'Terms'   => 'https://smokeycocktail.com/pages/terms-of-service',
                'Shipping'=> 'https://smokeycocktail.com/pages/shipping-returns',
                'Refund'  => 'https://smokeycocktail.com/pages/shipping-returns',
            ] as $label => $url): ?>
            <a href="<?= $url ?>" target="_blank" rel="noopener"
               style="font-size:.7rem;color:var(--dim);text-decoration:none;"
               onmouseover="this.style.color='var(--gold-neon)'"
               onmouseout="this.style.color='var(--dim)'"><?= $label ?></a>
            <?php endforeach; ?>
        </div>
        <?php if (auth()->loggedIn() && (auth()->user()->inGroup('super_admin') || auth()->user()->inGroup('inventory_manager') || auth()->user()->inGroup('viewer'))): ?>
        <a href="<?= site_url('admin') ?>" style="font-size:.7rem;color:var(--dim);text-decoration:none;">⚙ Admin</a>
        <?php endif; ?>
    </div>
</div>
</footer>

<script>
document.getElementById('mobile-btn')?.addEventListener('click',()=>{
    document.getElementById('mobile-menu').classList.toggle('hidden');
});
function updateWishlistBadge(n){
    const b=document.getElementById('wishlist-count');
    if(!b)return;
    b.textContent=n; b.style.display=n>0?'':'none';
}

// Scroll reveal
const revealObserver = new IntersectionObserver((entries)=>{
    entries.forEach(el=>{
        if(el.isIntersecting){
            el.target.classList.add('visible');
            revealObserver.unobserve(el.target);
        }
    });
},{threshold:0,rootMargin:'0px 0px -50px 0px'});
document.addEventListener('DOMContentLoaded',()=>{
    document.querySelectorAll('.fade-up,.fade-in').forEach(el=>revealObserver.observe(el));
    setTimeout(()=>{
        document.querySelectorAll('.fade-up,.fade-in').forEach(el=>{
            const rect=el.getBoundingClientRect();
            if(rect.top<window.innerHeight+100) el.classList.add('visible');
        });
    },50);

    // Add to cart AJAX
    document.querySelectorAll('.add-to-cart-form').forEach(function(form){
        form.addEventListener('submit',function(e){
            e.preventDefault();
            const btn=form.querySelector('[type=submit]');
            const orig=btn.innerHTML; btn.innerHTML='Adding…'; btn.disabled=true;
            fetch('<?= site_url('cart/add') ?>',{
                method:'POST',headers:{'X-Requested-With':'XMLHttpRequest'},body:new FormData(form)
            }).then(r=>r.json()).then(d=>{
                if(d.success){
                    btn.innerHTML='✓ Added';
                    btn.style.background='linear-gradient(135deg,#1a5c14,#22c55e)';btn.style.color='#fff';
                    setTimeout(()=>location.reload(),900);
                }
            }).catch(()=>{btn.innerHTML=orig;btn.disabled=false;});
        });
    });

    // Wishlist AJAX
    document.querySelectorAll('.wish-btn').forEach(function(btn){
        btn.addEventListener('click',function(e){
            e.preventDefault();e.stopPropagation();
            const pid=btn.dataset.pid;
            const fd=new FormData();
            fd.append('product_id',pid);
            fd.append('<?= csrf_token() ?>','<?= csrf_hash() ?>');
            fetch('<?= site_url('wishlist/toggle') ?>',{
                method:'POST',headers:{'X-Requested-With':'XMLHttpRequest'},body:fd
            }).then(r=>r.json()).then(d=>{
                if(d.success){
                    btn.classList.toggle('active',d.added);
                    updateWishlistBadge(d.count);
                    btn.style.transform='scale(1.4)';
                    setTimeout(()=>btn.style.transform='',300);
                }
            });
        });
    });
});
</script>
</body>
</html>
