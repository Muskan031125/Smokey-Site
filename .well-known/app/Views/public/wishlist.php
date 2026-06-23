<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div style="background:linear-gradient(180deg,var(--bg-soft) 0%,var(--bg) 100%);min-height:60vh;">
<div style="max-width:1440px;margin:0 auto;padding:2.5rem 1.5rem;">
    <div style="margin-bottom:2rem;">
        <p style="font-size:.7rem;letter-spacing:.15em;text-transform:uppercase;color:var(--gold);margin-bottom:.5rem;">Saved</p>
        <h1 class="font-serif" style="font-size:2.25rem;font-style:italic;font-weight:300;color:var(--text);">Your Wishlist</h1>
        <p style="color:var(--dim);font-size:.8rem;margin-top:.25rem;"><?= count($items) ?> saved item<?= count($items) !== 1 ? 's' : '' ?></p>
    </div>

    <?php if (empty($items)): ?>
    <div style="text-align:center;padding:5rem 2rem;background:var(--card);border:1px solid var(--border);border-radius:4px;">
        <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin:0 auto 1rem;opacity:.2;color:var(--gold);" stroke-width="1"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
        <p class="font-serif" style="font-size:1.5rem;font-style:italic;color:var(--dim);">Your wishlist is empty</p>
        <p style="font-size:.8rem;color:var(--dim);margin:.5rem 0 1.5rem;">Browse our collections and save your favourites</p>
        <a href="<?= site_url('shop') ?>" class="btn-neon" style="padding:.75rem 2rem;font-size:.8rem;border-radius:50px;display:inline-block;">Browse Products</a>
    </div>
    <?php else: ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(185px,1fr));gap:1rem;">
        <?php foreach ($items as $p): ?>
        <?= view('partials/product_card', ['p' => $p, 'wishlistedIds' => array_column($items, 'product_id')]) ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
</div>

<?= $this->endSection() ?>
