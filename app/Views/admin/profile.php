<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 style="font-size:1.1rem;font-weight:700;color:var(--text);">My Profile</h1>
        <p style="font-size:.75rem;color:var(--text-muted);margin-top:2px;">Update your account information</p>
    </div>
    <div class="header-actions">
        <a href="<?= site_url('admin') ?>" class="btn-ghost">← Back to Dashboard</a>
        <a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a>
    </div>
</div>

<div class="content-wrapper" style="max-width:680px;">

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

    <!-- Role badge -->
    <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:1.5rem;">
        <?php foreach ($user['groups'] as $g): ?>
        <span class="badge" style="background:#fff8e1;border:1px solid #ffe082;color:#a87900;text-transform:capitalize;">
            <?= esc(str_replace('_', ' ', $g)) ?>
        </span>
        <?php endforeach; ?>
        <span style="font-size:.72rem;color:var(--text-muted);">Member since <?= date('M Y', strtotime($user['created_at'])) ?></span>
    </div>

    <!-- Profile form -->
    <div class="card" style="padding:1.75rem;">
        <h2 style="font-size:.85rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-muted);margin-bottom:1.25rem;">Account Details</h2>
        <form method="post" action="<?= site_url('account/profile') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="username" value="<?= esc($user['username']) ?>">

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                <div>
                    <label class="form-label">Display Name</label>
                    <input type="text" name="display_name" value="<?= esc(old('display_name', $user['display_name'] ?? '')) ?>" placeholder="Your name" style="width:100%;">
                </div>
                <div>
                    <label class="form-label">Phone</label>
                    <input type="tel" name="phone" value="<?= esc(old('phone', $user['phone'] ?? '')) ?>" placeholder="+91 98765 43210" style="width:100%;">
                </div>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" required value="<?= esc(old('email', $user['email'])) ?>" style="width:100%;">
            </div>

            <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
                <button type="submit" class="btn-gold">Save Changes</button>
                <a href="<?= site_url('account/change-password') ?>" class="btn-outline">Change Password</a>
            </div>
        </form>
    </div>

    <!-- Danger / session info -->
    <div class="card" style="padding:1.25rem 1.75rem;margin-top:1.25rem;">
        <h2 style="font-size:.85rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-muted);margin-bottom:.75rem;">Session Info</h2>
        <p style="font-size:.8rem;color:var(--text-muted);">Last active: <?= $user['last_active'] ? date('d M Y H:i', strtotime($user['last_active'])) : '—' ?></p>
    </div>

</div>

<?= $this->endSection() ?>
