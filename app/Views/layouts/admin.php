<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Admin — Smokey Cocktail') ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0;}
:root{
  --bg:#f5f3ed;           /* light page bg */
  --bg2:#ebe8e0;          /* secondary */
  --white:#ffffff;
  --black:#0f0f0f;
  --sidebar:#1a1a1a;      /* DARK sidebar */
  --sidebar-active:#252525;
  --gold:#c9a84c;
  --gold-warm:#b88a2c;
  --text:#1a1a1a;
  --text-muted:#5a5650;
  --dim:#9b968a;
  --border:#d6d2c8;
  --border-soft:#e8e4d8;
  --green:#1f9d55;
  --red:#d63939;
  --blue:#3b82f6;
  --orange:#f59e0b;
  --purple:#8b5cf6;
}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);font-size:13px;margin:0;}

/* SIDEBAR (stays dark) */
.sidebar{background:var(--sidebar);border-right:1px solid #2a2520;width:220px;height:100vh;
  position:fixed;top:0;left:0;z-index:40;display:flex;flex-direction:column;overflow-y:auto;}
.main-content{margin-left:220px;min-height:100vh;background:var(--bg);}
.nav-section{font-size:.6rem;letter-spacing:.2em;text-transform:uppercase;color:#5a544a;padding:.875rem 1rem .3rem;font-weight:700;}
.nav-link{display:flex;align-items:center;gap:.55rem;padding:.55rem 1rem;font-size:.78rem;color:#a8a39a;
  border-left:2px solid transparent;transition:all .15s;text-decoration:none;}
.nav-link svg{flex-shrink:0;opacity:.65;}
.nav-link:hover{background:var(--sidebar-active);color:var(--gold);border-left-color:var(--gold);}
.nav-link:hover svg{opacity:1;}
.nav-link.active{background:var(--sidebar-active);color:var(--gold);border-left-color:var(--gold);}
.nav-link.active svg{opacity:1;}

/* PAGE CONTENT (centered, light) */
.page-header{background:var(--white);border-bottom:1px solid var(--border-soft);padding:1rem 2rem;
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;
  position:sticky;top:0;z-index:30;box-shadow:0 1px 0 rgba(0,0,0,.02);}
.header-actions{display:flex;align-items:center;gap:.5rem;}
.header-logout{font-size:.7rem;color:var(--red);background:#fee;border:1px solid #fcc;
  padding:.45rem .85rem;border-radius:4px;text-decoration:none;letter-spacing:.05em;
  text-transform:uppercase;font-weight:700;transition:all .2s;display:inline-flex;align-items:center;gap:.3rem;}
.header-logout:hover{background:var(--red);color:#fff;border-color:var(--red);}
.content-wrapper{max-width:1200px;margin:0 auto;padding:1.5rem 2rem;}

/* CARDS */
.card{background:var(--white);border:1px solid var(--border-soft);border-radius:8px;
  box-shadow:0 1px 3px rgba(0,0,0,.04);}

/* BUTTONS */
.btn-gold{background:var(--gold);color:#000;font-weight:700;padding:.5rem 1rem;border-radius:4px;
  font-size:.75rem;letter-spacing:.06em;text-transform:uppercase;cursor:pointer;border:none;
  text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;transition:all .2s;}
.btn-gold:hover{background:#d4b560;transform:translateY(-1px);}
.btn-sm{padding:.3rem .65rem;font-size:.7rem;}
.btn-primary{background:var(--black);color:#fff;font-weight:600;padding:.5rem 1rem;border-radius:4px;
  font-size:.75rem;letter-spacing:.06em;text-transform:uppercase;cursor:pointer;border:none;
  text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;transition:all .2s;}
.btn-primary:hover{background:#000;transform:translateY(-1px);}
.btn-outline{border:1.5px solid var(--black);color:var(--black);padding:.45rem 1rem;border-radius:4px;
  font-size:.75rem;letter-spacing:.06em;cursor:pointer;background:transparent;text-decoration:none;
  display:inline-flex;align-items:center;gap:.4rem;transition:all .2s;font-weight:600;}
.btn-outline:hover{background:var(--black);color:#fff;}
.btn-ghost{border:1px solid var(--border);color:var(--text-muted);padding:.35rem .65rem;border-radius:4px;
  font-size:.72rem;cursor:pointer;background:var(--white);text-decoration:none;
  display:inline-flex;align-items:center;gap:.3rem;transition:all .2s;}
.btn-ghost:hover{color:var(--black);border-color:var(--black);}
.btn-danger{background:#fee;color:var(--red);border:1px solid #fcc;padding:.3rem .65rem;border-radius:4px;
  font-size:.7rem;cursor:pointer;text-decoration:none;display:inline-flex;transition:all .2s;}
.btn-danger:hover{background:var(--red);color:#fff;border-color:var(--red);}

/* TABLES */
table{width:100%;border-collapse:collapse;}
th{text-align:left;font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;
  color:var(--text-muted);padding:.75rem 1rem;border-bottom:1px solid var(--border-soft);font-weight:700;background:var(--bg2);}
td{padding:.85rem 1rem;border-bottom:1px solid var(--border-soft);font-size:.8rem;color:var(--text);vertical-align:middle;}
tr:hover td{background:#fafaf6;}

/* INPUTS */
input,select,textarea{background:#fff!important;border:1px solid var(--border)!important;
  color:var(--text)!important;padding:.55rem .8rem;border-radius:4px;font-size:.85rem;font-family:'Inter',sans-serif;}
input:focus,select:focus,textarea:focus{border-color:var(--black)!important;outline:none!important;
  box-shadow:0 0 0 3px rgba(0,0,0,.05)!important;}
input[type=checkbox],input[type=radio]{width:auto!important;border:none!important;accent-color:var(--black);}
input[type=file]{padding:.45rem .65rem;cursor:pointer;background:var(--bg2)!important;}
label.form-label{font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;color:var(--text-muted);
  display:block;margin-bottom:.4rem;font-weight:700;}

/* BADGES */
.badge{display:inline-block;padding:.2rem .6rem;border-radius:99px;font-size:.65rem;font-weight:700;letter-spacing:.04em;}
.badge-pending   {background:#fff8e1;border:1px solid #ffe082;color:#a87900;}
.badge-confirmed {background:#e8f5e9;border:1px solid #a5d6a7;color:#1f7a30;}
.badge-processing{background:#e3f2fd;border:1px solid #90caf9;color:#1565c0;}
.badge-shipped   {background:#f3e5f5;border:1px solid #ce93d8;color:#6a1b9a;}
.badge-delivered {background:#e0f2f1;border:1px solid #80cbc4;color:#00695c;}
.badge-cancelled {background:#ffebee;border:1px solid #ef9a9a;color:#b71c1c;}
.badge-active    {background:#e8f5e9;border:1px solid #a5d6a7;color:#1f7a30;}
.badge-inactive  {background:#f5f3ed;border:1px solid var(--border);color:#5a564c;}
.badge-approved  {background:#e8f5e9;border:1px solid #a5d6a7;color:#1f7a30;}
.badge-pending-rv{background:#fff8e1;border:1px solid #ffe082;color:#a87900;}

/* FLASH */
.flash-success{background:#e8f5e9;border:1px solid #a5d6a7;color:#1f7a30;border-radius:5px;
  padding:.75rem 1rem;font-size:.85rem;margin-bottom:1rem;}
.flash-error{background:#ffebee;border:1px solid #ef9a9a;color:#b71c1c;border-radius:5px;
  padding:.75rem 1rem;font-size:.85rem;margin-bottom:1rem;}

/* STAT CARDS */
.stat-card{background:var(--white);border:1px solid var(--border-soft);border-radius:8px;
  padding:1.25rem 1.5rem;box-shadow:0 1px 3px rgba(0,0,0,.04);transition:all .2s;}
.stat-card:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(0,0,0,.08);}

.font-serif{font-family:'Crimson Pro',Georgia,serif;}

/* Scrollbar */
::-webkit-scrollbar{width:8px;height:8px;}
::-webkit-scrollbar-track{background:var(--bg);}
::-webkit-scrollbar-thumb{background:var(--border);border-radius:4px;}
::-webkit-scrollbar-thumb:hover{background:var(--dim);}
</style>
</head>
<body>

<!-- Sidebar (DARK) -->
<aside class="sidebar">
    <div style="padding:1.1rem 1rem;border-bottom:1px solid #2a2520;flex-shrink:0;">
        <div class="font-serif" style="font-size:1.15rem;color:#fff;font-weight:600;letter-spacing:.05em;">SMOKEY COCKTAIL</div>
        <div style="font-size:.6rem;letter-spacing:.25em;color:var(--gold);text-transform:uppercase;margin-top:2px;">Admin Panel</div>
        <a href="<?= site_url('shop') ?>" target="_blank"
           style="display:inline-flex;align-items:center;gap:.3rem;margin-top:.625rem;font-size:.68rem;color:#a8a39a;text-decoration:none;letter-spacing:.05em;transition:color .2s;"
           onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='#a8a39a'">
            <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            View Live Store
        </a>
    </div>

    <nav style="flex:1;padding:.5rem 0;">
        <?php $u = uri_string(); ?>

        <div class="nav-section">Overview</div>
        <a href="<?= site_url('admin') ?>" class="nav-link <?= $u==='admin'?'active':'' ?>">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>

        <div class="nav-section">Catalogue</div>
        <a href="<?= site_url('admin/products') ?>" class="nav-link <?= str_starts_with($u,'admin/products')?'active':'' ?>">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
            Products
        </a>
        <a href="<?= site_url('admin/products/create') ?>" class="nav-link">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M12 4v16m8-8H4"/></svg>
            Add Product
        </a>
        <a href="<?= site_url('admin/categories') ?>" class="nav-link <?= str_starts_with($u,'admin/categories')?'active':'' ?>">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            Categories
        </a>
        <a href="<?= site_url('admin/bulk-import') ?>" class="nav-link">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            Bulk Import
        </a>

        <div class="nav-section">Orders & CRM</div>
        <a href="<?= site_url('admin/orders') ?>" class="nav-link <?= str_starts_with($u,'admin/orders')?'active':'' ?>">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            All Orders
            <?php $pending = (new \App\Models\OrderModel())->where('status','pending')->countAllResults(); ?>
            <?php if ($pending > 0): ?><span style="background:var(--gold);color:#000;border-radius:99px;font-size:.6rem;font-weight:700;padding:.1rem .45rem;margin-left:auto;"><?= $pending ?></span><?php endif; ?>
        </a>
        <a href="<?= site_url('admin/wishlists') ?>" class="nav-link <?= $u==='admin/wishlists'?'active':'' ?>">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            Wishlists
        </a>

        <div class="nav-section">Content</div>
        <a href="<?= site_url('admin/reviews') ?>" class="nav-link <?= str_starts_with($u,'admin/reviews')?'active':'' ?>">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M11.05 2.93c.3-.92 1.6-.92 1.9 0l1.52 4.67a1 1 0 00.95.7h4.91c.97 0 1.37 1.24.59 1.81l-3.98 2.89a1 1 0 00-.36 1.12l1.52 4.67c.3.92-.76 1.69-1.54 1.12L12 16.4l-3.98 2.89c-.78.57-1.84-.2-1.54-1.12l1.52-4.67a1 1 0 00-.36-1.12L3.66 9.49c-.78-.57-.38-1.81.59-1.81h4.91a1 1 0 00.95-.7l1.52-4.67z"/></svg>
            Reviews
            <?php $pendingRv = (new \App\Models\ReviewModel())->where('is_approved', 0)->countAllResults(); ?>
            <?php if ($pendingRv > 0): ?><span style="background:var(--red);color:#fff;border-radius:99px;font-size:.6rem;font-weight:700;padding:.1rem .45rem;margin-left:auto;"><?= $pendingRv ?></span><?php endif; ?>
        </a>
        <a href="<?= site_url('admin/blog') ?>" class="nav-link <?= str_starts_with($u,'admin/blog')?'active':'' ?>">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            Blog Posts
        </a>
        <a href="<?= site_url('admin/banners') ?>" class="nav-link <?= str_starts_with($u,'admin/banners')?'active':'' ?>">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
            Banners
        </a>
        <a href="<?= site_url('admin/promo-codes') ?>" class="nav-link <?= str_starts_with($u,'admin/promo-codes')?'active':'' ?>">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M7 7h.01M7 3h5c.51 0 1.02.2 1.41.59l7 7a2 2 0 010 2.83l-7 7a2 2 0 01-2.83 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
            Promo Codes
        </a>

        <div class="nav-section">Settings</div>
        <a href="<?= site_url('admin/staff') ?>" class="nav-link">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M17 20h5v-2a3 3 0 00-5.36-1.86M17 20H7m10 0v-2c0-.66-.13-1.28-.36-1.86M7 20H2v-2a3 3 0 015.36-1.86M7 20v-2c0-.66.13-1.28.36-1.86m0 0a5 5 0 019.29 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Staff
        </a>
        <a href="<?= site_url('admin/settings') ?>" class="nav-link <?= str_starts_with($u,'admin/settings')?'active':'' ?>">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path d="M10.32 4.32c.43-1.76 2.93-1.76 3.35 0a1.72 1.72 0 002.57 1.07c1.54-.94 3.31.83 2.37 2.37a1.72 1.72 0 001.07 2.57c1.76.43 1.76 2.93 0 3.35a1.72 1.72 0 00-1.07 2.57c.94 1.54-.83 3.31-2.37 2.37a1.72 1.72 0 00-2.57 1.07c-.43 1.76-2.93 1.76-3.35 0a1.72 1.72 0 00-2.57-1.07c-1.54.94-3.31-.83-2.37-2.37a1.72 1.72 0 00-1.07-2.57c-1.76-.43-1.76-2.93 0-3.35a1.72 1.72 0 001.07-2.57c-.94-1.54.83-3.31 2.37-2.37 1 .61 2.3.07 2.57-1.07z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Site Settings
        </a>
    </nav>

    <div style="padding:.875rem 1rem;border-top:1px solid #2a2520;flex-shrink:0;background:#0d0d0d;">
        <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.625rem;">
            <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--gold),#b88a2c);display:flex;align-items:center;justify-content:center;color:#0a0808;font-weight:700;font-size:.85rem;flex-shrink:0;"><?= strtoupper(mb_substr(auth()->user()->email ?? 'A', 0, 1)) ?></div>
            <div style="flex:1;min-width:0;">
                <p style="font-size:.72rem;color:#fff;font-weight:600;margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">Admin</p>
                <p style="font-size:.65rem;color:#7a7468;margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= esc(auth()->user()->email ?? '') ?></p>
            </div>
        </div>
        <div style="display:flex;gap:.4rem;">
            <a href="<?= site_url('logout') ?>" style="flex:1;text-align:center;font-size:.68rem;color:#fff;background:#3a2a2a;border:1px solid #4a3a3a;padding:.45rem;border-radius:4px;text-decoration:none;letter-spacing:.05em;text-transform:uppercase;font-weight:600;transition:all .2s;" onmouseover="this.style.background='#e6504a';this.style.borderColor='#e6504a'" onmouseout="this.style.background='#3a2a2a';this.style.borderColor='#4a3a3a'">
                ⎋ Logout
            </a>
            <a href="<?= site_url('shop') ?>" target="_blank" style="flex:1;text-align:center;font-size:.68rem;color:#fff;background:#252525;border:1px solid #3a3530;padding:.45rem;border-radius:4px;text-decoration:none;letter-spacing:.05em;text-transform:uppercase;font-weight:600;transition:all .2s;" onmouseover="this.style.background='var(--gold)';this.style.color='#000';this.style.borderColor='var(--gold)'" onmouseout="this.style.background='#252525';this.style.color='#fff';this.style.borderColor='#3a3530'">
                Store ↗
            </a>
        </div>
    </div>
</aside>

<!-- Main content (centered light) -->
<div class="main-content">
    <?php if (session()->has('success') || session()->has('error')): ?>
    <div class="content-wrapper" style="padding-bottom:0;">
        <?php if (session()->has('success')): ?><div class="flash-success"><?= esc(session('success')) ?></div><?php endif; ?>
        <?php if (session()->has('error')): ?><div class="flash-error"><?= esc(session('error')) ?></div><?php endif; ?>
    </div>
    <?php endif; ?>
    <?= $this->renderSection('content') ?>
</div>

<script>
function confirmDelete(form, msg) { if(confirm(msg||'Delete this item?')) form.submit(); return false; }
</script>
</body>
</html>
