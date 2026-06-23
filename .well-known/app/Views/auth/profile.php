<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div style="max-width:680px;margin:0 auto;padding:3rem 1.5rem;">

    <div style="text-align:center;margin-bottom:2.5rem;">
        <p style="font-size:.7rem;letter-spacing:.25em;text-transform:uppercase;color:var(--gold);font-weight:600;margin-bottom:.5rem;">My Account</p>
        <h1 class="font-serif" style="font-size:clamp(1.8rem,4vw,2.5rem);font-weight:400;color:var(--text);">
            Account <em style="color:var(--gold-neon);">Settings</em>
        </h1>
        <div class="gold-line" style="margin:.875rem auto 0;"></div>
    </div>

    <?php if (session()->has('success')): ?>
    <div class="flash-success" style="margin-bottom:1rem;"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->has('errors')): ?>
    <div class="flash-error" style="margin-bottom:1rem;">
        <?php foreach ((array)session('errors') as $e): ?><div>• <?= esc($e) ?></div><?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Quick links -->
    <div style="display:flex;gap:.5rem;justify-content:center;margin-bottom:2rem;flex-wrap:wrap;">
        <a href="<?= site_url('orders') ?>" style="font-size:.78rem;padding:.5rem 1rem;color:var(--text);background:rgba(212,168,73,.08);border:1px solid rgba(212,168,73,.25);border-radius:50px;text-decoration:none;letter-spacing:.06em;text-transform:uppercase;font-weight:600;transition:all .2s;"
           onmouseover="this.style.background='rgba(212,168,73,.18)';this.style.borderColor='var(--gold-neon)'" onmouseout="this.style.background='rgba(212,168,73,.08)';this.style.borderColor='rgba(212,168,73,.25)'">📦 My Orders</a>
        <a href="<?= site_url('wishlist') ?>" style="font-size:.78rem;padding:.5rem 1rem;color:var(--text);background:rgba(212,168,73,.08);border:1px solid rgba(212,168,73,.25);border-radius:50px;text-decoration:none;letter-spacing:.06em;text-transform:uppercase;font-weight:600;transition:all .2s;"
           onmouseover="this.style.background='rgba(212,168,73,.18)';this.style.borderColor='var(--gold-neon)'" onmouseout="this.style.background='rgba(212,168,73,.08)';this.style.borderColor='rgba(212,168,73,.25)'">❤ Wishlist</a>
        <?php if (auth()->user()->inGroup('super_admin') || auth()->user()->inGroup('inventory_manager') || auth()->user()->inGroup('viewer')): ?>
        <a href="<?= site_url('admin') ?>" style="font-size:.78rem;padding:.5rem 1rem;color:#0a0808;background:linear-gradient(135deg,var(--gold),var(--gold-neon));border:none;border-radius:50px;text-decoration:none;letter-spacing:.06em;text-transform:uppercase;font-weight:700;">⚙ Admin Panel</a>
        <?php endif; ?>
        <a href="<?= site_url('logout') ?>" style="font-size:.78rem;padding:.5rem 1rem;color:var(--red);background:rgba(230,80,74,.08);border:1px solid rgba(230,80,74,.3);border-radius:50px;text-decoration:none;letter-spacing:.06em;text-transform:uppercase;font-weight:600;">⎋ Logout</a>
    </div>

    <!-- Profile card -->
    <div style="background:linear-gradient(180deg,rgba(28,24,18,.6),rgba(20,16,16,.85));
                border:1px solid var(--border);border-radius:14px;padding:2rem;backdrop-filter:blur(20px);
                box-shadow:0 20px 50px rgba(0,0,0,.4);">
        <form method="post" action="<?= site_url('account/profile') ?>">
            <?= csrf_field() ?>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">
                <div>
                    <label style="display:block;font-size:.68rem;letter-spacing:.15em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;font-weight:600;">Name</label>
                    <input type="text" name="display_name" value="<?= esc(old('display_name', $user['display_name'] ?? '')) ?>" placeholder="Your name" style="width:100%;padding:.7rem 1rem;font-size:.875rem;border-radius:6px;">
                </div>
                <div>
                    <label style="display:block;font-size:.68rem;letter-spacing:.15em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;font-weight:600;">Phone</label>
                    <input type="tel" name="phone" value="<?= esc(old('phone', $user['phone'] ?? '')) ?>" placeholder="+91 98765 43210" style="width:100%;padding:.7rem 1rem;font-size:.875rem;border-radius:6px;">
                </div>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="display:block;font-size:.68rem;letter-spacing:.15em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;font-weight:600;">Email</label>
                <input type="email" name="email" required value="<?= esc(old('email', $user['email'])) ?>" style="width:100%;padding:.7rem 1rem;font-size:.875rem;border-radius:6px;">
            </div>

            <input type="hidden" name="username" value="<?= esc($user['username']) ?>">

            <div style="display:flex;gap:.625rem;flex-wrap:wrap;">
                <button type="submit" class="btn-neon" style="flex:1;padding:.85rem 1.5rem;font-size:.78rem;border-radius:6px;min-width:160px;">Save Changes</button>
                <a href="<?= site_url('account/change-password') ?>" class="btn-outline-neon" style="flex:1;padding:.85rem 1.5rem;font-size:.78rem;border-radius:6px;text-align:center;min-width:160px;">Change Password</a>
            </div>
        </form>
    </div>

</div>

<?= $this->endSection() ?>
