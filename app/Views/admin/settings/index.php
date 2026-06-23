<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php $get = fn (string $k, $def = '') => $settings[$k]['value'] ?? $def; ?>

<div class="page-header">
    <h1 style="color:#e8e0d0;font-size:1.1rem;font-weight:600;margin:0;">Settings</h1>
    <p style="color:#555;font-size:.75rem;margin:.2rem 0 0;">Site configuration</p>

    <div style="margin-left:auto;display:flex;gap:.5rem;align-items:center;"><a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a></div>
</div>

<div class="content-wrapper">
    <form method="post" action="<?= site_url('admin/settings') ?>">
        <?= csrf_field() ?>

        <div class="card" style="padding:1.5rem;margin-bottom:1.25rem;">
            <h2 style="color:#c9a84c;font-size:.75rem;letter-spacing:.15em;text-transform:uppercase;margin:0 0 1rem;">Site Identity</h2>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Site Name</label>
                    <input type="text" name="setting[site_name]" value="<?= esc($get('site_name', 'Smokey Cocktail')) ?>" style="width:100%;">
                </div>
                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Tagline</label>
                    <input type="text" name="setting[site_tagline]" value="<?= esc($get('site_tagline')) ?>" style="width:100%;">
                </div>
                <div>
                    <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Currency Symbol</label>
                    <input type="text" name="setting[currency_symbol]" value="<?= esc($get('currency_symbol', '₹')) ?>" style="width:100%;">
                </div>
                <div>
                    <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Currency Code</label>
                    <input type="text" name="setting[currency]" value="<?= esc($get('currency', 'INR')) ?>" style="width:100%;" placeholder="INR">
                </div>
            </div>
        </div>

        <div class="card" style="padding:1.5rem;margin-bottom:1.25rem;">
            <h2 style="color:#c9a84c;font-size:.75rem;letter-spacing:.15em;text-transform:uppercase;margin:0 0 1rem;">Contact Information</h2>
            <div style="display:grid;gap:1rem;">
                <div>
                    <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Contact Email</label>
                    <input type="email" name="setting[contact_email]" value="<?= esc($get('contact_email')) ?>" style="width:100%;">
                </div>
                <div>
                    <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Contact Phone</label>
                    <input type="text" name="setting[contact_phone]" value="<?= esc($get('contact_phone')) ?>" style="width:100%;">
                </div>
                <div>
                    <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Address</label>
                    <input type="text" name="setting[contact_address]" value="<?= esc($get('contact_address')) ?>" style="width:100%;">
                </div>
            </div>
        </div>

        <div class="card" style="padding:1.5rem;margin-bottom:1.25rem;">
            <h2 style="color:#c9a84c;font-size:.75rem;letter-spacing:.15em;text-transform:uppercase;margin:0 0 1rem;">Display</h2>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div>
                    <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Date Format</label>
                    <input type="text" name="setting[date_format]" value="<?= esc($get('date_format', 'd M Y')) ?>" style="width:100%;" placeholder="d M Y">
                </div>
                <div>
                    <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Timezone</label>
                    <input type="text" name="setting[timezone]" value="<?= esc($get('timezone', 'Asia/Kolkata')) ?>" style="width:100%;" placeholder="Asia/Kolkata">
                </div>
            </div>
        </div>

        <button type="submit" class="btn-gold">Save Settings</button>
    </form>
</div>

<?= $this->endSection() ?>
