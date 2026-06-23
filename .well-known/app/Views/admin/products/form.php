<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php $isEdit = !empty($product); ?>

<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;">
    <div>
        <h1 style="color:#e8e0d0;font-size:1.1rem;font-weight:600;margin:0;"><?= $isEdit ? 'Edit Product' : 'Add Product' ?></h1>
        <?php if ($isEdit): ?>
        <p style="color:#555;font-size:.75rem;margin:.2rem 0 0;"><?= esc($product['title']) ?></p>
        <?php endif; ?>
    </div>
    <a href="<?= site_url('admin/products') ?>" class="btn-outline btn-sm">← Back</a>

    <div style="margin-left:auto;display:flex;gap:.5rem;align-items:center;"><a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a></div>
</div>

<div class="content-wrapper">
    <?php if (session()->has('errors')): ?>
    <div class="flash-error" style="margin-bottom:1rem;">
        <?php foreach ((array)session('errors') as $e): ?><div>• <?= esc($e) ?></div><?php endforeach; ?>
    </div>
    <?php endif; ?>

    <form method="post" action="<?= $isEdit ? site_url('admin/products/'.$product['id']) : site_url('admin/products') ?>">
        <?= csrf_field() ?>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">

            <!-- Title -->
            <div style="grid-column:1/-1;">
                <label style="display:block;font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Product Title *</label>
                <input type="text" name="title" required value="<?= esc(old('title', $product['title'] ?? '')) ?>" style="width:100%;font-size:1rem;padding:.75rem 1rem;" placeholder="e.g. Crystal Whisky Decanter Set">
            </div>

            <!-- Category -->
            <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Category</label>
                <select name="category_id" style="width:100%;padding:.6rem .875rem;">
                    <option value="">— None —</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (old('category_id', $product['category_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                        <?= esc($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Vendor -->
            <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Brand / Vendor</label>
                <input type="text" name="vendor" value="<?= esc(old('vendor', $product['vendor'] ?? '')) ?>" style="width:100%;" placeholder="e.g. PRHO, IMHO">
            </div>

            <!-- SKU -->
            <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">SKU</label>
                <input type="text" name="sku" value="<?= esc(old('sku', $product['sku'] ?? '')) ?>" style="width:100%;">
            </div>

            <!-- Price -->
            <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Selling Price (₹) *</label>
                <input type="number" name="price" required step="0.01" min="0" value="<?= esc(old('price', $product['price'] ?? '')) ?>" style="width:100%;" placeholder="3599.00">
            </div>

            <!-- Compare price -->
            <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Compare-at Price (₹)</label>
                <input type="number" name="compare_price" step="0.01" min="0" value="<?= esc(old('compare_price', $product['compare_price'] ?? '')) ?>" style="width:100%;" placeholder="Original price for strikethrough">
            </div>

            <!-- Cost price -->
            <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Cost per Item (₹) <span style="color:#555;">admin only</span></label>
                <input type="number" name="cost_price" step="0.01" min="0" value="<?= esc(old('cost_price', $product['cost_price'] ?? '')) ?>" style="width:100%;">
            </div>

            <!-- Inventory -->
            <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Inventory Qty</label>
                <input type="number" name="inventory_qty" min="0" value="<?= esc(old('inventory_qty', $product['inventory_qty'] ?? 0)) ?>" style="width:100%;">
            </div>

            <!-- Material -->
            <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Material</label>
                <input type="text" name="material" value="<?= esc(old('material', $product['material'] ?? '')) ?>" style="width:100%;" placeholder="e.g. Borosilicate Glass">
            </div>

            <!-- Colour -->
            <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Colour</label>
                <input type="text" name="colour" value="<?= esc(old('colour', $product['colour'] ?? '')) ?>" style="width:100%;">
            </div>

            <!-- Size -->
            <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Size / Dimensions</label>
                <input type="text" name="size" value="<?= esc(old('size', $product['size'] ?? '')) ?>" style="width:100%;" placeholder="e.g. 19×20×10 cm">
            </div>

            <!-- Tags -->
            <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Tags <span style="color:#555;font-size:.65rem;">comma-separated</span></label>
                <input type="text" name="tags" value="<?= esc(old('tags', $product['tags'] ?? '')) ?>" style="width:100%;" placeholder="cocktail, barware, glass">
            </div>

            <!-- Description -->
            <div style="grid-column:1/-1;">
                <label style="display:block;font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:.4rem;">Description</label>
                <textarea name="description" rows="4" style="width:100%;resize:vertical;"><?= esc(old('description', $product['description'] ?? '')) ?></textarea>
            </div>

            <!-- Flags -->
            <div style="display:flex;flex-wrap:wrap;gap:1.25rem 2.5rem;grid-column:1/-1;">
                <?php foreach ([
                    ['is_in_stock',    'In Stock'],
                    ['is_active',      'Active (visible on store)'],
                    ['is_new_arrival', 'New Arrival badge'],
                    ['is_best_seller', 'Best Seller badge'],
                    ['is_featured',    "Founder's Pick"],
                ] as [$key, $label]): ?>
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.78rem;color:#9a9a8a;">
                    <input type="checkbox" name="<?= $key ?>" value="1" style="accent-color:#c9a84c;width:auto!important;border:none!important;"
                           <?= old($key, $product[$key] ?? ($key === 'is_in_stock' || $key === 'is_active' ? 1 : 0)) ? 'checked' : '' ?>>
                    <?= $label ?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="margin-top:1.5rem;display:flex;gap:.75rem;">
            <button type="submit" class="btn-gold"><?= $isEdit ? 'Save Changes' : 'Create Product' ?></button>
            <a href="<?= site_url('admin/products') ?>" class="btn-outline">Cancel</a>
            <?php if ($isEdit): ?>
            <a href="<?= site_url('admin/products/'.$product['id'].'/media') ?>" class="btn-outline" style="margin-left:auto;">Manage Images →</a>
            <?php endif; ?>
        </div>
    </form>

    <?php if ($isEdit && !empty($media)): ?>
    <div style="margin-top:2rem;">
        <h3 style="color:#e8e0d0;font-size:.9rem;font-weight:600;margin:0 0 1rem;">Product Images</h3>
        <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
            <?php foreach ($media as $m): ?>
            <?php if ($m['type'] === 'image'): ?>
            <div style="position:relative;">
                <img src="<?= media_url($m['path']) ?>" alt="" style="width:80px;height:80px;object-fit:cover;border-radius:.375rem;border:<?= $m['is_cover'] ? '2px solid #c9a84c' : '1px solid #2a2a2a' ?>;">
                <?php if ($m['is_cover']): ?><span style="position:absolute;bottom:2px;left:2px;background:#c9a84c;color:#0d0d0d;font-size:.55rem;padding:1px 3px;border-radius:2px;font-weight:700;">COVER</span><?php endif; ?>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
            <a href="<?= site_url('admin/products/'.$product['id'].'/media') ?>"
               style="width:80px;height:80px;border:1px dashed #2a2a2a;border-radius:.375rem;display:flex;align-items:center;justify-content:center;color:#555;font-size:1.5rem;text-decoration:none;">+</a>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
