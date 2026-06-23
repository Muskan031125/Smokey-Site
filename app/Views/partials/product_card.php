<?php
/**
 * Elegant Product Card — Smokey Cocktail
 * @var array $p
 * @var array $wishlistedIds
 * @var bool  $light
 */
$light      = $light ?? false;
$wished     = in_array($p['id'], $wishlistedIds ?? []);
$productUrl = auth()->loggedIn() ? site_url('product/'.$p['handle']) : site_url('login');
$onSale  = !empty($p['compare_price']) && (float)$p['compare_price'] > (float)$p['price'];
$disc    = $onSale ? round((((float)$p['compare_price'] - (float)$p['price']) / (float)$p['compare_price']) * 100) : 0;
$isNew   = !empty($p['is_new_arrival']);
$rating  = (float)($p['avg_rating'] ?? 0);
$reviews = (int)($p['review_count'] ?? 0);
$inStock = (bool)($p['is_in_stock'] ?? true);

$img = $p['cover_image'] ?? null;
$imgUrl = null;
if ($img) {
    $imgUrl = str_starts_with($img, 'http') ? $img : base_url($img);
}
?>

<div style="position:relative;display:flex;flex-direction:column;height:100%;
            background:linear-gradient(180deg,#2e2820 0%,#221c14 100%);
            border:1px solid rgba(212,168,73,.18);
            border-radius:12px;overflow:hidden;
            transition:all .4s cubic-bezier(.25,.46,.45,.94);"
     onmouseover="this.style.borderColor='rgba(212,168,73,.5)';this.style.transform='translateY(-6px)';this.style.boxShadow='0 24px 48px rgba(0,0,0,.45),0 0 0 1px rgba(212,168,73,.2)'"
     onmouseout="this.style.borderColor='rgba(212,168,73,.18)';this.style.transform='';this.style.boxShadow=''">

    <!-- IMAGE -->
    <a href="<?= $productUrl ?>"
       style="display:block;position:relative;aspect-ratio:3/4;overflow:hidden;
              background:#0e0c0a;flex-shrink:0;text-decoration:none;">

        <?php if ($imgUrl): ?>
        <img src="<?= esc($imgUrl) ?>" alt="<?= esc($p['title']) ?>" loading="lazy"
             style="width:100%;height:100%;object-fit:cover;transition:transform .7s cubic-bezier(.25,.46,.45,.94);"
             onmouseover="this.style.transform='scale(1.07)'" onmouseout="this.style.transform='scale(1)'">
        <?php else: ?>
        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:3.5rem;opacity:.12;">🥃</div>
        <?php endif; ?>

        <!-- Gradient overlay at bottom for text readability -->
        <div style="position:absolute;bottom:0;left:0;right:0;height:40%;
                    background:linear-gradient(to top,rgba(0,0,0,.55) 0%,transparent 100%);pointer-events:none;"></div>

        <!-- Badges top-left -->
        <?php if (!$inStock || $isNew || $onSale): ?>
        <div style="position:absolute;top:12px;left:12px;display:flex;flex-direction:column;gap:5px;z-index:3;">
            <?php if (!$inStock): ?>
            <span style="background:rgba(0,0,0,.75);color:#999;font-size:.58rem;font-weight:700;padding:.2rem .6rem;border-radius:3px;letter-spacing:.06em;backdrop-filter:blur(8px);">SOLD OUT</span>
            <?php elseif ($isNew): ?>
            <span style="background:linear-gradient(135deg,#5fb88a,#3d9e72);color:#fff;font-size:.58rem;font-weight:800;padding:.2rem .6rem;border-radius:3px;letter-spacing:.06em;">NEW</span>
            <?php endif; ?>
            <?php if ($onSale && $inStock): ?>
            <span style="background:linear-gradient(135deg,#d4a849,#ffd966);color:#0a0808;font-size:.58rem;font-weight:800;padding:.2rem .6rem;border-radius:3px;letter-spacing:.06em;"><?= $disc ?>% OFF</span>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Wishlist heart top-right -->
        <button class="wish-btn <?= $wished ? 'active' : '' ?>" data-pid="<?= $p['id'] ?>"
                aria-label="Add to wishlist"
                style="position:absolute;top:12px;right:12px;z-index:3;width:36px;height:36px;
                       background:rgba(10,8,8,.7);border-radius:50%;border:1px solid rgba(255,217,102,.15);
                       cursor:pointer;display:flex;align-items:center;justify-content:center;
                       backdrop-filter:blur(12px);transition:all .25s;"
                onmouseover="this.style.background='rgba(212,168,73,.25)';this.style.borderColor='rgba(255,217,102,.6)'"
                onmouseout="this.style.background='rgba(10,8,8,.7)';this.style.borderColor='rgba(255,217,102,.15)'">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="<?= $wished ? 'var(--red)' : 'none' ?>" stroke="<?= $wished ? 'var(--red)' : 'rgba(255,217,102,.8)' ?>" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </button>
    </a>

    <!-- INFO -->
    <div style="padding:.875rem 1rem 1rem;flex:1;display:flex;flex-direction:column;gap:.35rem;">

        <!-- Title -->
        <a href="<?= $productUrl ?>" style="text-decoration:none;">
            <h3 style="font-size:.82rem;font-weight:500;line-height:1.45;
                       color:var(--text);
                       display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
                       transition:color .2s;"
                onmouseover="this.style.color='var(--gold-neon)'" onmouseout="this.style.color='var(--text)'">
                <?= esc($p['title']) ?>
            </h3>
        </a>

        <!-- Stars -->
        <?php if ($reviews > 0): ?>
        <div style="display:flex;align-items:center;gap:.3rem;">
            <div style="display:flex;gap:1px;">
                <?php for ($s = 1; $s <= 5; $s++): ?>
                <span style="font-size:.65rem;color:<?= $s <= round($rating) ? 'var(--gold-neon)' : 'rgba(255,255,255,.12)' ?>;">★</span>
                <?php endfor; ?>
            </div>
            <span style="font-size:.62rem;color:var(--muted);">(<?= $reviews ?>)</span>
        </div>
        <?php endif; ?>

        <!-- Spacer -->
        <div style="flex:1;"></div>

        <!-- Price row -->
        <div style="display:flex;align-items:center;justify-content:space-between;gap:.5rem;margin-top:.25rem;">
            <div style="display:flex;align-items:baseline;gap:.4rem;flex-wrap:wrap;">
                <span style="font-size:.95rem;font-weight:700;color:var(--gold-neon);letter-spacing:.01em;"><?= money($p['price']) ?></span>
                <?php if ($onSale): ?>
                <span style="font-size:.72rem;color:var(--muted);text-decoration:line-through;"><?= money($p['compare_price']) ?></span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Add to cart -->
        <form class="add-to-cart-form" method="post" action="<?= site_url('cart/add') ?>" style="margin-top:.5rem;">
            <?= csrf_field() ?>
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
            <input type="hidden" name="quantity" value="1">
            <button type="submit"
                    style="width:100%;padding:.6rem;font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
                           border:1px solid rgba(212,168,73,.35);border-radius:6px;cursor:pointer;
                           background:transparent;color:var(--gold-neon);transition:all .25s;
                           <?= !$inStock ? 'opacity:.35;pointer-events:none;' : '' ?>"
                    onmouseover="<?= $inStock ? "this.style.background='rgba(212,168,73,.15)';this.style.borderColor='var(--gold-neon)'" : '' ?>"
                    onmouseout="this.style.background='transparent';this.style.borderColor='rgba(212,168,73,.35)'"
                    <?= !$inStock ? 'disabled' : '' ?>>
                <?= $inStock ? '+ Add to Cart' : 'Out of Stock' ?>
            </button>
        </form>
    </div>
</div>
