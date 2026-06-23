<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 class="font-serif" style="color:var(--black);font-size:1.4rem;font-weight:600;margin:0;">Products</h1>
        <p style="color:var(--text-muted);font-size:.75rem;margin:.2rem 0 0;"><?= $total ?> total</p>
    </div>
    <div style="display:flex;gap:.5rem;">
        <a href="<?= site_url('admin/bulk-import') ?>" class="btn-outline btn-sm">Bulk Import</a>
        <a href="<?= site_url('admin/products/create') ?>" class="btn-primary btn-sm">+ Add Product</a>
    </div>

    <div style="margin-left:auto;display:flex;gap:.5rem;align-items:center;"><a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a></div>
</div>

<div class="content-wrapper">
    <!-- Filters -->
    <form method="get" style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.5rem;background:var(--white);padding:1rem;border:1px solid var(--border-soft);border-radius:8px;">
        <input type="text" name="q" value="<?= esc($filters['search']) ?>" placeholder="Search title, SKU, handle..." style="flex:1;min-width:220px;padding:.5rem .875rem;">
        <select name="category" style="padding:.5rem .875rem;">
            <option value="">All Categories</option>
            <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($filters['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="status" style="padding:.5rem .875rem;">
            <option value="">All Status</option>
            <option value="1" <?= ($filters['is_active'] ?? '') === '1' ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= ($filters['is_active'] ?? '') === '0' ? 'selected' : '' ?>>Inactive</option>
        </select>
        <button type="submit" class="btn-primary btn-sm">Filter</button>
        <a href="<?= site_url('admin/products') ?>" class="btn-outline btn-sm">Clear</a>
    </form>

    <div class="card">
        <?php if (empty($products)): ?>
        <div style="padding:3rem;text-align:center;color:var(--text-muted);">
            No products found. <a href="<?= site_url('admin/products/create') ?>" style="color:var(--black);font-weight:600;">Add one →</a>
        </div>
        <?php else: ?>
        <table>
            <thead><tr><th style="width:60px;"></th><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($products as $p): ?>
            <tr>
                <td>
                    <?php if ($p['cover_image']): ?>
                    <img src="<?= esc(str_starts_with($p['cover_image'],'http')?$p['cover_image']:base_url($p['cover_image'])) ?>" alt="" style="width:44px;height:44px;object-fit:cover;border-radius:4px;background:var(--bg2);">
                    <?php else: ?>
                    <div style="width:44px;height:44px;background:var(--bg2);border-radius:4px;display:flex;align-items:center;justify-content:center;opacity:.4;font-size:1.2rem;"></div>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="color:var(--black);font-weight:600;margin-bottom:.15rem;"><?= esc($p['title']) ?></div>
                    <div style="font-size:.7rem;color:var(--text-muted);"><?= esc($p['vendor'] ?? '') ?><?= $p['sku'] ? ' · ' . esc($p['sku']) : '' ?></div>
                </td>
                <td style="color:var(--text-muted);"><?= esc($p['category_name'] ?? '—') ?></td>
                <td style="color:var(--black);font-weight:700;"><?= money($p['price']) ?></td>
                <td>
                    <form method="post" action="<?= site_url('admin/products/'.$p['id'].'/toggle-stock') ?>" style="display:inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="badge <?= $p['is_in_stock'] ? 'badge-active' : 'badge-inactive' ?>" style="cursor:pointer;border:none;font-family:inherit;">
                            <?= $p['is_in_stock'] ? 'In Stock' : 'Out of Stock' ?>
                        </button>
                    </form>
                </td>
                <td><span class="badge <?= $p['is_active'] ? 'badge-active' : 'badge-inactive' ?>"><?= $p['is_active'] ? 'Active' : 'Hidden' ?></span></td>
                <td>
                    <div style="display:flex;gap:.4rem;align-items:center;">
                        <a href="<?= site_url('admin/products/'.$p['id'].'/media') ?>" style="color:var(--text-muted);font-size:.75rem;" title="Media">📷</a>
                        <a href="<?= site_url('admin/products/'.$p['id'].'/edit') ?>" class="btn-outline btn-sm">Edit</a>
                        <form method="post" action="<?= site_url('admin/products/'.$p['id'].'/delete') ?>" onsubmit="return confirm('Delete this product?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn-danger">✕</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($total > $perPage): ?>
        <?php $totalPages = (int)ceil($total / $perPage); ?>
        <div style="padding:1rem;display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--border-soft);">
            <span style="font-size:.75rem;color:var(--text-muted);">Page <?= $page ?> of <?= $totalPages ?></span>
            <div style="display:flex;gap:.375rem;">
                <?php for ($i = 1; $i <= min($totalPages, 10); $i++): ?>
                <a href="?<?= http_build_query(array_merge(['q'=>$filters['search'],'category'=>$filters['category_id']??''],['page'=>$i])) ?>"
                   style="<?= $i === $page ? 'background:var(--black);color:#fff;font-weight:700;' : 'background:var(--white);color:var(--text-muted);border:1px solid var(--border);' ?> padding:.3rem .65rem;border-radius:4px;font-size:.75rem;text-decoration:none;">
                    <?= $i ?>
                </a>
                <?php endfor; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
