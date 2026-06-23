<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1 style="color:var(--text);font-size:1rem;font-weight:600;margin:0;">Homepage Banners</h1>

    <div style="margin-left:auto;display:flex;gap:.5rem;align-items:center;"><a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a></div>
</div>

<div style="padding:1.25rem 1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start;" class="grid-cols-1 md:grid-cols-2">

    <!-- Add form -->
    <div class="card" style="padding:1.25rem;">
        <h2 style="color:var(--text);font-size:.85rem;font-weight:600;margin:0 0 1rem;">Add New Banner</h2>
        <form method="post" action="<?= site_url('admin/banners') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div style="display:grid;gap:.875rem;">
                <div><label class="form-label">Heading</label><input type="text" name="title" style="width:100%;"></div>
                <div><label class="form-label">Subheading</label><input type="text" name="subtitle" style="width:100%;"></div>
                <div><label class="form-label">Link (URL)</label><input type="text" name="link" placeholder="/shop" style="width:100%;"></div>
                <div><label class="form-label">Button Text</label><input type="text" name="btn_text" value="Shop Now" style="width:100%;"></div>
                <div><label class="form-label">Background Image</label><input type="file" name="image" accept="image/*" style="width:100%;"></div>
                <div><label class="form-label">Sort Order</label><input type="number" name="sort_order" value="0" style="width:80px;"></div>
                <button type="submit" class="btn-gold">Add Banner</button>
            </div>
        </form>
    </div>

    <!-- Existing banners -->
    <div>
        <h2 style="color:var(--text);font-size:.85rem;font-weight:600;margin:0 0 1rem;">Current Banners (<?= count($banners) ?>)</h2>
        <?php if (empty($banners)): ?>
        <p style="color:var(--dim);font-size:.8rem;">No banners yet.</p>
        <?php else: ?>
        <div style="display:grid;gap:.75rem;">
            <?php foreach ($banners as $b): ?>
            <div class="card" style="padding:1rem;display:flex;align-items:center;gap:1rem;">
                <?php if ($b['image']): ?>
                <img src="<?= media_url($b['image']) ?>" alt="" style="width:60px;height:40px;object-fit:cover;border-radius:3px;flex-shrink:0;">
                <?php else: ?>
                <div style="width:60px;height:40px;background:var(--border2);border-radius:3px;flex-shrink:0;"></div>
                <?php endif; ?>
                <div style="flex:1;min-width:0;">
                    <p style="color:var(--text);font-size:.8rem;font-weight:500;margin:0 0 .15rem;"><?= esc($b['title'] ?? 'Untitled') ?></p>
                    <p style="font-size:.7rem;color:var(--dim);margin:0;"><?= esc($b['link'] ?? '') ?></p>
                </div>
                <form method="post" action="<?= site_url('admin/banners/'.$b['id'].'/delete') ?>" onsubmit="return confirm('Delete?')"><?= csrf_field() ?><button type="submit" class="btn-danger">✕</button></form>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
