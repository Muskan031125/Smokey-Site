<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 style="font-size:1.1rem;font-weight:700;color:var(--text);">Change Password</h1>
        <p style="font-size:.75rem;color:var(--text-muted);margin-top:2px;">Update your login credentials</p>
    </div>
    <div class="header-actions">
        <a href="<?= site_url('account/profile') ?>" class="btn-ghost">← Back to Profile</a>
        <a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a>
    </div>
</div>

<div class="content-wrapper" style="max-width:520px;">

    <?php if (session()->has('success')): ?>
    <div class="flash-success"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->has('error')): ?>
    <div class="flash-error"><?= esc(session('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->has('errors')): ?>
    <div class="flash-error">
        <?php foreach ((array)session('errors') as $e): ?><div>• <?= esc($e) ?></div><?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="card" style="padding:1.75rem;">
        <form method="post" action="<?= site_url('account/change-password') ?>">
            <?= csrf_field() ?>

            <div style="margin-bottom:1rem;">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" required autocomplete="current-password" placeholder="••••••••" style="width:100%;">
            </div>

            <div style="margin-bottom:1rem;">
                <label class="form-label">New Password</label>
                <input type="password" name="new_password" required autocomplete="new-password" placeholder="••••••••" style="width:100%;">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="confirm_password" required autocomplete="new-password" placeholder="••••••••" style="width:100%;">
            </div>

            <div style="display:flex;gap:.75rem;">
                <button type="submit" class="btn-gold">Update Password</button>
                <a href="<?= site_url('account/profile') ?>" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>

</div>

<?= $this->endSection() ?>
