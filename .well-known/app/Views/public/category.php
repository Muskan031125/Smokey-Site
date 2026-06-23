<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-10 flex items-end justify-between">
        <div>
            <p class="text-xs tracking-widest uppercase mb-2" style="color:#c9a84c;">
                <a href="<?= site_url('shop') ?>" class="hover:opacity-80">Shop</a> / <?= esc($category['name']) ?>
            </p>
            <h1 class="font-serif text-4xl font-bold" style="color:#e8e0d0;"><?= esc($category['name']) ?></h1>
            <p class="text-sm mt-2" style="color:#6b6b6b;"><?= $total ?> product<?= $total !== 1 ? 's' : '' ?></p>
        </div>
    </div>

    <?php if (empty($products)): ?>
    <div class="text-center py-24">
        <p class="font-serif text-2xl mb-3" style="color:#3a3a3a;">No products in this category yet</p>
        <a href="<?= site_url('shop') ?>" class="btn-outline inline-block mt-4 px-6 py-3 rounded text-sm">Browse All</a>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
        <?php foreach ($products as $p): ?>
        <div class="product-card rounded-lg overflow-hidden group flex flex-col">
            <a href="<?= site_url('product/'.$p['handle']) ?>">
                <div class="aspect-square overflow-hidden relative" style="background:#111;">
                    <?php if ($p['cover_image']): ?>
                    <img src="<?= media_url($p['cover_image']) ?>" alt="<?= esc($p['title']) ?>"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center opacity-20">
                        <svg class="w-12 h-12" style="color:#c9a84c;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16"/>
                        </svg>
                    </div>
                    <?php endif; ?>
                    <?php if ($p['compare_price'] && $p['compare_price'] > $p['price']): ?>
                    <?php $disc = round((($p['compare_price'] - $p['price']) / $p['compare_price']) * 100); ?>
                    <span class="absolute top-2 right-2 px-2 py-1 text-xs rounded font-bold" style="background:#c9a84c;color:#0d0d0d;"><?= $disc ?>% OFF</span>
                    <?php endif; ?>
                </div>
            </a>
            <div class="p-4 flex flex-col flex-1">
                <p class="text-xs mb-1" style="color:#6b6b6b;"><?= esc($p['vendor'] ?? '') ?></p>
                <a href="<?= site_url('product/'.$p['handle']) ?>" class="text-sm font-medium leading-snug mb-3 flex-1 hover:opacity-80 line-clamp-2" style="color:#e8e0d0;"><?= esc($p['title']) ?></a>
                <div class="flex items-center gap-2 mb-3">
                    <span class="font-semibold" style="color:#c9a84c;"><?= money($p['price']) ?></span>
                    <?php if ($p['compare_price'] && $p['compare_price'] > $p['price']): ?>
                    <span class="text-xs line-through" style="color:#555;"><?= money($p['compare_price']) ?></span>
                    <?php endif; ?>
                </div>
                <form class="add-to-cart-form" method="post" action="<?= site_url('cart/add') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-gold w-full py-2 rounded text-xs tracking-wider uppercase <?= !$p['is_in_stock'] ? 'opacity-40 cursor-not-allowed' : '' ?>" <?= !$p['is_in_stock'] ? 'disabled' : '' ?>>
                        <?= $p['is_in_stock'] ? 'Add to Cart' : 'Out of Stock' ?>
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if ($total > $perPage): ?>
    <?php $totalPages = (int)ceil($total / $perPage); ?>
    <div class="flex items-center justify-center gap-2 mt-12">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>" class="w-9 h-9 flex items-center justify-center rounded text-sm"
           style="<?= $i === $page ? 'background:#c9a84c;color:#0d0d0d;font-weight:700;' : 'background:#1a1a1a;color:#6b6b6b;border:1px solid #2a2a2a;' ?>">
            <?= $i ?>
        </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
