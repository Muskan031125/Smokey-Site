<?php
/**
 * Product card.
 * @var array $p
 * @var array $wishlistedIds
 * @var bool  $light  Optional - render in light theme
 */
$light    = $light ?? false;
$wished   = in_array($p['id'], $wishlistedIds ?? []);
$onSale   = !empty($p['compare_price']) && (float)$p['compare_price'] > (float)$p['price'];
$disc     = $onSale ? round((((float)$p['compare_price'] - (float)$p['price']) / (float)$p['compare_price']) * 100) : 0;
$isNew    = !empty($p['is_new_arrival']);
$rating   = (float)($p['avg_rating'] ?? 0);
$reviews  = (int)($p['review_count'] ?? 0);
$inStock  = (bool)($p['is_in_stock'] ?? true);

$img = $p['cover_image'] ?? null;
$imgUrl = null;
if ($img) {
    if (str_starts_with($img, 'http')) {
        $imgUrl = $img;
    } elseif (file_exists(ROOTPATH . 'public/' . ltrim($img, '/'))) {
        $imgUrl = base_url($img);
    } else {
        $imgUrl = $img;
    }
}

$cardClass = $light ? 'product-card-light' : 'product-card';
$titleColor = $light ? 'var(--ink)' : 'var(--text)';
$titleHover = $light ? 'var(--copper)' : 'var(--gold-neon)';
$priceColor = $light ? 'var(--ink)' : 'var(--gold-neon)';
$starColor = $light ? '#d4a849' : 'var(--gold-neon)';
$dimColor = $light ? 'var(--ink-soft)' : 'var(--muted)';
$infoBg = $light ? '#fff' : 'transparent';
$btnClass = $light ? 'btn-dark' : 'btn-neon';
?>
<div class="<?= $cardClass ?>" style="border-radius:10px;overflow:hidden;display:flex;flex-direction:column;height:100%;">
    <a href="<?= site_url('product/'.$p['handle']) ?>" style="text-decoration:none;display:block;position:relative;aspect-ratio:1;overflow:hidden;background:<?= $light ? 'var(--bg-light2)' : 'var(--bg-soft)' ?>;flex-shrink:0;">
        <?php if ($imgUrl): ?>
        <img src="<?= esc($imgUrl) ?>" alt="<?= esc($p['title']) ?>"
             class="card-img" loading="lazy"
             onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
        <div style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:3rem;opacity:.2;position:absolute;inset:0;"></div>
        <?php else: ?>
        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:3rem;opacity:.2;"></div>
        <?php endif; ?>

        <div style="position:absolute;top:10px;left:10px;display:flex;flex-direction:column;gap:5px;z-index:2;">
            <?php if (!$inStock): ?><span class="badge-sold-out">Sold Out</span><?php endif; ?>
            <?php if ($isNew && $inStock): ?><span class="badge-new">NEW</span><?php endif; ?>
            <?php if ($onSale && $inStock): ?><span class="badge-sale"><?= $disc ?>% OFF</span><?php endif; ?>
        </div>

        <button class="wish-btn <?= $wished ? 'active' : '' ?>" data-pid="<?= $p['id'] ?>" aria-label="Wishlist">
            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </button>
    </a>

    <div style="padding:1rem 1.1rem;flex:1;display:flex;flex-direction:column;background:<?= $infoBg ?>;">
        <?php if (!empty($p['vendor']) && $p['vendor'] !== 'Smokey Cocktail'): ?>
        <p style="font-size:.62rem;letter-spacing:.12em;text-transform:uppercase;color:<?= $dimColor ?>;margin-bottom:.25rem;font-weight:600;"><?= esc($p['vendor']) ?></p>
        <?php endif; ?>

        <a href="<?= site_url('product/'.$p['handle']) ?>" style="text-decoration:none;flex:1;">
            <h3 style="font-size:.85rem;color:<?= $titleColor ?>;line-height:1.4;margin-bottom:.5rem;
                       display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
                       transition:color .2s;font-weight:500;"
                onmouseover="this.style.color='<?= $titleHover ?>'" onmouseout="this.style.color='<?= $titleColor ?>'"><?= esc($p['title']) ?></h3>
        </a>

        <?php if ($reviews > 0): ?>
        <div style="display:flex;align-items:center;gap:.3rem;margin-bottom:.5rem;">
            <span style="display:inline-flex;gap:1px;">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                <span style="color:<?= $i <= round($rating) ? $starColor : ($light ? '#d8d3c5' : 'rgba(255,255,255,.15)') ?>;font-size:.72rem;">★</span>
                <?php endfor; ?>
            </span>
            <span style="font-size:.65rem;color:<?= $dimColor ?>;">(<?= $reviews ?>)</span>
        </div>
        <?php endif; ?>

        <div style="display:flex;align-items:baseline;gap:.5rem;margin-bottom:.75rem;flex-wrap:wrap;">
            <span style="font-size:1rem;font-weight:700;color:<?= $priceColor ?>;<?= !$light ? 'text-shadow:0 0 12px rgba(255,217,102,.3);' : '' ?>"><?= money($p['price']) ?></span>
            <?php if ($onSale): ?>
            <span style="font-size:.75rem;text-decoration:line-through;color:<?= $dimColor ?>;"><?= money($p['compare_price']) ?></span>
            <?php endif; ?>
        </div>

        <form class="add-to-cart-form" method="post" action="<?= site_url('cart/add') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="<?= $btnClass ?>"
                    style="width:100%;padding:.625rem .75rem;font-size:.7rem;border-radius:6px;text-transform:uppercase;letter-spacing:.1em;
                           <?= !$inStock ? 'opacity:.4;pointer-events:none;' : '' ?>"
                    <?= !$inStock ? 'disabled' : '' ?>>
                <?= $inStock ? 'Add to Cart' : 'Out of Stock' ?>
            </button>
        </form>
    </div>
</div>
