<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div style="background:linear-gradient(180deg,var(--bg-soft) 0%,var(--bg) 60%,var(--bg-soft) 100%);min-height:60vh;">
<div style="max-width:1440px;margin:0 auto;padding:2.5rem 1.5rem;position:relative;z-index:1;">

    <!-- Page header (centered) -->
    <div style="text-align:center;margin-bottom:2.5rem;">
        <?php if (isset($category)): ?>
        <p style="font-size:.72rem;color:var(--muted);margin-bottom:.5rem;">
            <a href="<?= site_url('shop') ?>" style="color:var(--muted);text-decoration:none;">Shop</a>
            / <span style="color:var(--gold-neon);"><?= esc($category['name'] ?? '') ?></span>
        </p>
        <?php endif; ?>
        <h1 class="font-serif" style="font-size:clamp(1.8rem,4vw,2.75rem);font-weight:400;color:var(--text);"><?= esc($pageHeading ?? 'All Products') ?></h1>
        <div class="gold-line" style="margin:.875rem auto;"></div>
        <p style="color:var(--muted);font-size:.85rem;"><?= $total ?> product<?= $total !== 1 ? 's' : '' ?></p>
    </div>

    <!-- Horizontal filter bar (no sidebar) -->
    <form id="filter-form" method="get"
          style="background:linear-gradient(180deg,rgba(28,24,18,.4),rgba(20,16,16,.6));
                 border:1px solid var(--border);border-radius:12px;padding:1rem 1.25rem;margin-bottom:2rem;
                 display:flex;flex-wrap:wrap;align-items:center;gap:.75rem;backdrop-filter:blur(10px);">

        <?php foreach (['flag'] as $k): ?>
        <?php if (!empty($filters[$k])): ?><input type="hidden" name="<?= $k ?>" value="<?= esc($filters[$k]) ?>"><?php endif; ?>
        <?php endforeach; ?>

        <!-- Search -->
        <div style="flex:1;min-width:200px;display:flex;align-items:center;background:rgba(20,16,16,.6);border:1px solid var(--border);border-radius:6px;overflow:hidden;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--muted);margin-left:.875rem;flex-shrink:0;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" name="q" value="<?= esc($filters['search'] ?? '') ?>" placeholder="Search products..." style="flex:1;padding:.55rem .75rem;font-size:.82rem;border:none!important;background:transparent!important;">
        </div>

        <!-- Category dropdown -->
        <select name="cat" onchange="this.form.submit()" style="padding:.55rem .9rem;font-size:.8rem;border-radius:6px;min-width:170px;cursor:pointer;">
            <option value="">All Categories</option>
            <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($filters['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Price -->
        <div style="display:flex;align-items:center;gap:.35rem;">
            <input type="number" name="min_price" placeholder="₹ Min" value="<?= esc($filters['min_price'] ?? '') ?>" style="width:92px;padding:.55rem .65rem;font-size:.78rem;border-radius:6px;">
            <span style="color:var(--muted);">–</span>
            <input type="number" name="max_price" placeholder="₹ Max" value="<?= esc($filters['max_price'] ?? '') ?>" style="width:92px;padding:.55rem .65rem;font-size:.78rem;border-radius:6px;">
        </div>

        <!-- Availability -->
        <label style="display:flex;align-items:center;gap:.4rem;font-size:.78rem;color:var(--text);cursor:pointer;padding:0 .5rem;">
            <input type="checkbox" name="in_stock" value="1" <?= !empty($filters['in_stock']) ? 'checked' : '' ?> onchange="this.form.submit()" style="accent-color:var(--gold-neon);width:auto!important;border:none!important;padding:0!important;"> In Stock
        </label>

        <!-- Sort -->
        <select onchange="applySort(this.value)" style="padding:.55rem .9rem;font-size:.8rem;border-radius:6px;min-width:170px;cursor:pointer;">
            <option value="newest"      <?= ($filters['sort']??'newest')==='newest'      ? 'selected':'' ?>>Sort: Newest</option>
            <option value="best_selling"<?= ($filters['sort']??'')==='best_selling'      ? 'selected':'' ?>>Best Selling</option>
            <option value="top_rated"   <?= ($filters['sort']??'')==='top_rated'         ? 'selected':'' ?>>Top Rated</option>
            <option value="price_asc"   <?= ($filters['sort']??'')==='price_asc'         ? 'selected':'' ?>>Price: Low → High</option>
            <option value="price_desc"  <?= ($filters['sort']??'')==='price_desc'        ? 'selected':'' ?>>Price: High → Low</option>
            <option value="alpha_asc"   <?= ($filters['sort']??'')==='alpha_asc'         ? 'selected':'' ?>>A → Z</option>
        </select>

        <button type="submit" class="btn-neon" style="padding:.55rem 1.25rem;font-size:.72rem;border-radius:6px;">Apply</button>

        <?php $hasFilters = !empty(array_filter([$filters['search']??'',$filters['min_price']??'',$filters['max_price']??'',$filters['in_stock']??'',$filters['colour']??''])); ?>
        <?php if ($hasFilters): ?>
        <a href="<?= isset($category) ? site_url('category/'.$category['slug']) : site_url('shop') ?>" style="font-size:.72rem;color:var(--muted);text-decoration:underline;letter-spacing:.05em;">Clear</a>
        <?php endif; ?>
    </form>

    <!-- Products grid (full width) -->
    <?php if (empty($products)): ?>
    <div style="text-align:center;padding:5rem 2rem;background:rgba(28,24,18,.4);border:1px solid var(--border);border-radius:12px;">
        <div style="font-size:3rem;margin-bottom:1rem;opacity:.3;filter:drop-shadow(0 0 20px rgba(255,217,102,.3));">✦</div>
        <p class="font-serif" style="font-size:1.5rem;color:var(--muted);">No products found</p>
        <a href="<?= site_url('shop') ?>" class="btn-outline-neon" style="display:inline-block;margin-top:1rem;padding:.6rem 1.5rem;font-size:.78rem;border-radius:50px;">Clear Filters</a>
    </div>
    <?php else: ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.5rem;">
        <?php foreach ($products as $p): ?>
        <?= view('partials/product_card', ['p' => $p, 'wishlistedIds' => $wishlistedIds ?? []]) ?>
        <?php endforeach; ?>
    </div>

    <?php if ($total > $perPage): ?>
    <?php $totalPages = (int)ceil($total / $perPage); ?>
    <div style="text-align:center;margin-top:3rem;">
        <?php if ($page < $totalPages): ?>
        <a href="?<?= http_build_query(array_merge(array_filter($filters), ['page' => $page + 1])) ?>"
           class="btn-outline-neon" style="padding:.85rem 3rem;font-size:.78rem;border-radius:50px;display:inline-block;">
            Load More Products
        </a>
        <?php endif; ?>
        <p style="font-size:.75rem;color:var(--muted);margin-top:1rem;">
            Showing <?= min($page * $perPage, $total) ?> of <?= $total ?> products
        </p>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>

<script>
function applySort(val) {
    const url = new URL(window.location);
    url.searchParams.set('sort', val);
    url.searchParams.delete('page');
    window.location = url.toString();
}
</script>
</div>
</div>

<?= $this->endSection() ?>
