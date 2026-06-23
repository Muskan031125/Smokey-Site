<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div style="max-width:520px;margin:0 auto;padding:3rem 1.5rem;">

    <div style="text-align:center;margin-bottom:2rem;">
        <a href="<?= site_url('account/profile') ?>" style="font-size:.75rem;color:var(--muted);text-decoration:none;letter-spacing:.05em;">← Back to Profile</a>
        <p style="font-size:.7rem;letter-spacing:.25em;text-transform:uppercase;color:var(--gold);font-weight:600;margin:1rem 0 .5rem;">Security</p>
        <h1 class="font-serif" style="font-size:clamp(1.6rem,3.5vw,2.2rem);font-weight:400;color:var(--text);">
            Change <em style="color:var(--gold-neon);">Password</em>
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

    <div style="background:linear-gradient(180deg,rgba(28,24,18,.6),rgba(20,16,16,.85));
                border:1px solid var(--border);border-radius:14px;padding:2rem;backdrop-filter:blur(20px);
                box-shadow:0 20px 50px rgba(0,0,0,.4);">
        <form method="post" action="<?= site_url('account/change-password') ?>">
            <?= csrf_field() ?>

            <div style="margin-bottom:1.1rem;">
                <label style="display:block;font-size:.68rem;letter-spacing:.15em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;font-weight:600;">Current Password</label>
                <input type="password" name="current_password" required autocomplete="current-password" placeholder="••••••••" style="width:100%;padding:.85rem 1rem;font-size:.875rem;border-radius:6px;">
            </div>

            <div style="margin-bottom:1.1rem;">
                <label style="display:block;font-size:.68rem;letter-spacing:.15em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;font-weight:600;">New Password</label>
                <input type="password" name="new_password" required autocomplete="new-password" placeholder="••••••••" style="width:100%;padding:.85rem 1rem;font-size:.875rem;border-radius:6px;">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="display:block;font-size:.68rem;letter-spacing:.15em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;font-weight:600;">Confirm New Password</label>
                <input type="password" name="confirm_password" required autocomplete="new-password" placeholder="••••••••" style="width:100%;padding:.85rem 1rem;font-size:.875rem;border-radius:6px;">
            </div>

            <div style="display:flex;gap:.625rem;">
                <button type="submit" class="btn-neon" style="flex:1;padding:.85rem 1.5rem;font-size:.78rem;border-radius:6px;">Update Password</button>
                <a href="<?= site_url('account/profile') ?>" class="btn-outline-neon" style="flex:1;padding:.85rem 1.5rem;font-size:.78rem;border-radius:6px;text-align:center;">Cancel</a>
            </div>
        </form>
    </div>

</div>

<?= $this->endSection() ?>
