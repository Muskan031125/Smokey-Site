<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1 style="color:var(--text);font-size:1rem;font-weight:600;margin:0;">Promo Codes Display</h1>

    <div style="margin-left:auto;display:flex;gap:.5rem;align-items:center;"><a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a></div>
</div>

<div class="content-wrapper">
    <p style="color:var(--dim);font-size:.8rem;margin-bottom:1.25rem;">These codes appear on product pages to encourage purchases. No discount is applied automatically — customers enter codes at checkout manually.</p>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
        <!-- Add form -->
        <div class="card" style="padding:1.25rem;">
            <h2 style="color:var(--text);font-size:.85rem;font-weight:600;margin:0 0 1rem;">Add Code</h2>
            <form method="post" action="<?= site_url('admin/promo-codes') ?>">
                <?= csrf_field() ?>
                <div style="display:grid;gap:.875rem;">
                    <div>
                        <label class="form-label">Code</label>
                        <input type="text" name="code" placeholder="SMOKEY10" required style="width:100%;text-transform:uppercase;font-weight:700;letter-spacing:.1em;">
                    </div>
                    <div>
                        <label class="form-label">Description shown to customers</label>
                        <input type="text" name="label" placeholder="10% off + free shipping" required style="width:100%;">
                    </div>
                    <div>
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" value="<?= count($codes) ?>" style="width:80px;">
                    </div>
                    <button type="submit" class="btn-gold">Add Code</button>
                </div>
            </form>
        </div>

        <!-- Existing codes -->
        <div>
            <h2 style="color:var(--text);font-size:.85rem;font-weight:600;margin:0 0 1rem;">Active Codes</h2>
            <?php if (empty($codes)): ?>
            <p style="color:var(--dim);font-size:.8rem;">No codes yet.</p>
            <?php else: ?>
            <div style="display:grid;gap:.625rem;">
                <?php foreach ($codes as $code): ?>
                <div class="card" style="padding:.875rem;display:flex;align-items:center;gap:.875rem;">
                    <code style="background:rgba(201,168,76,.1);color:var(--gold);padding:.2rem .6rem;border-radius:3px;font-size:.8rem;font-weight:700;letter-spacing:.08em;flex-shrink:0;"><?= esc($code['code']) ?></code>
                    <span style="font-size:.75rem;color:var(--muted);flex:1;"><?= esc($code['label']) ?></span>
                    <form method="post" action="<?= site_url('admin/promo-codes/'.$code['id'].'/delete') ?>" onsubmit="return confirm('Delete?')"><?= csrf_field() ?><button type="submit" class="btn-danger">✕</button></form>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
