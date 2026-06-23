<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div style="background:linear-gradient(180deg,var(--bg-light) 0%,var(--bg-light2) 100%);min-height:60vh;">
<div style="max-width:1100px;margin:0 auto;padding:2.5rem 1.5rem;">

    <div style="text-align:center;margin-bottom:2.5rem;">
        <p style="font-size:.7rem;letter-spacing:.22em;text-transform:uppercase;color:var(--copper);margin-bottom:.5rem;font-weight:600;">Your Selection</p>
        <h1 class="font-serif" style="font-size:clamp(1.8rem,4vw,2.75rem);font-weight:400;color:var(--ink);">Shopping Cart</h1>
        <div class="gold-line" style="margin:.75rem auto 0;"></div>
    </div>

    <?php if (empty($items)): ?>
    <div style="text-align:center;padding:4rem 2rem;background:var(--white);border:1px solid var(--border-soft);border-radius:10px;">
        <svg width="60" height="60" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin:0 auto 1.25rem;opacity:.25;color:var(--ink);" stroke-width="1"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        <p class="font-serif" style="font-size:1.5rem;color:var(--ink-soft);margin-bottom:.5rem;">Your cart is empty</p>
        <p style="font-size:.85rem;color:var(--ink-soft);margin-bottom:2rem;">Discover our handcrafted cocktail essentials</p>
        <a href="<?= site_url('shop') ?>" class="btn-primary" style="padding:.85rem 2.5rem;font-size:.78rem;border-radius:4px;text-transform:uppercase;letter-spacing:.08em;display:inline-block;">Browse Products</a>
    </div>
    <?php else: ?>

    <div class="cart-grid">

        <!-- Cart items -->
        <div style="display:grid;gap:1rem;">
            <?php foreach ($items as $item): ?>
            <div style="display:flex;gap:1rem;padding:1.25rem;background:var(--white);border:1px solid var(--border-soft);border-radius:8px;" id="cart-item-<?= $item['product_id'] ?>">
                <a href="<?= site_url('product/'.$item['handle']) ?>" style="width:90px;height:90px;flex-shrink:0;border-radius:6px;overflow:hidden;background:var(--cream);">
                    <?php if ($item['cover_image']): ?>
                    <img src="<?= esc(str_starts_with($item['cover_image'],'http')?$item['cover_image']:base_url($item['cover_image'])) ?>" alt="" style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;opacity:.2;font-size:2rem;"></div>
                    <?php endif; ?>
                </a>

                <div style="flex:1;min-width:0;">
                    <a href="<?= site_url('product/'.$item['handle']) ?>" style="text-decoration:none;color:var(--black);font-weight:500;font-size:.9rem;line-height:1.4;display:block;margin-bottom:.35rem;"><?= esc($item['title']) ?></a>
                    <p style="font-size:.78rem;color:var(--ink-soft);margin-bottom:.875rem;"><?= money($item['price']) ?> each</p>

                    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;">
                        <div style="display:flex;align-items:center;border:1px solid var(--border);border-radius:4px;overflow:hidden;background:#fff;">
                            <button onclick="updateQty(<?= $item['product_id'] ?>, -1)" style="padding:.3rem .75rem;background:none;border:none;font-size:1rem;cursor:pointer;color:var(--black);font-weight:600;">−</button>
                            <span style="padding:0 .75rem;font-size:.85rem;color:var(--black);font-weight:600;" id="qty-<?= $item['product_id'] ?>"><?= $item['quantity'] ?></span>
                            <button onclick="updateQty(<?= $item['product_id'] ?>, 1)" style="padding:.3rem .75rem;background:none;border:none;font-size:1rem;cursor:pointer;color:var(--black);font-weight:600;">+</button>
                        </div>

                        <div style="display:flex;align-items:center;gap:1rem;">
                            <span style="font-weight:700;color:var(--black);font-size:.95rem;"><?= money($item['price'] * $item['quantity']) ?></span>
                            <button onclick="removeItem(<?= $item['product_id'] ?>)" style="font-size:.72rem;background:none;border:none;cursor:pointer;color:var(--red);text-decoration:underline;">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <div style="display:flex;justify-content:space-between;align-items:center;padding-top:.5rem;">
                <a href="<?= site_url('shop') ?>" style="font-size:.85rem;color:var(--ink-soft);text-decoration:none;">← Continue Shopping</a>
                <form method="post" action="<?= site_url('cart/clear') ?>">
                    <?= csrf_field() ?>
                    <button type="submit" style="font-size:.75rem;color:var(--red);background:none;border:none;cursor:pointer;text-decoration:underline;">Clear Cart</button>
                </form>
            </div>
        </div>

        <!-- Order summary -->
        <div style="position:sticky;top:160px;background:var(--white);border:1px solid var(--border-soft);border-radius:10px;padding:1.5rem;box-shadow:0 4px 16px rgba(0,0,0,.04);">
            <h2 class="font-serif" style="font-size:1.4rem;color:var(--black);margin-bottom:1.25rem;font-weight:500;">Order Summary</h2>

            <div style="display:grid;gap:.625rem;margin-bottom:1.25rem;padding-bottom:1.25rem;border-bottom:1px solid var(--border-soft);">
                <?php foreach ($items as $item): ?>
                <div style="display:flex;justify-content:space-between;font-size:.8rem;">
                    <span style="color:var(--ink);flex:1;padding-right:.5rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= esc($item['title']) ?> × <?= $item['quantity'] ?></span>
                    <span style="color:var(--black);font-weight:600;"><?= money($item['price'] * $item['quantity']) ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <div style="display:flex;justify-content:space-between;font-weight:700;font-size:1.05rem;margin-bottom:.5rem;color:var(--black);">
                <span>Subtotal</span>
                <span><?= money($subtotal) ?></span>
            </div>
            <p style="font-size:.7rem;color:var(--ink-soft);margin-bottom:1.5rem;">Shipping & taxes calculated at checkout</p>

            <?php if (auth()->loggedIn()): ?>
            <a href="<?= site_url('checkout') ?>" class="btn-primary" style="display:block;text-align:center;padding:1rem;font-size:.8rem;border-radius:6px;text-transform:uppercase;letter-spacing:.1em;font-weight:700;">Proceed to Checkout →</a>
            <?php else: ?>
            <a href="<?= site_url('login?redirect=checkout') ?>" class="btn-primary" style="display:block;text-align:center;padding:1rem;font-size:.8rem;border-radius:6px;text-transform:uppercase;letter-spacing:.1em;font-weight:700;margin-bottom:.625rem;">Login to Checkout</a>
            <a href="<?= site_url('register') ?>" class="btn-outline" style="display:block;text-align:center;padding:.85rem;font-size:.78rem;border-radius:6px;text-transform:uppercase;">Create Account</a>
            <?php endif; ?>

            <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid var(--border-soft);text-align:center;">
                <p style="font-size:.7rem;color:var(--ink-soft);line-height:1.6;">🔒 Secure checkout · COD available<br>Free shipping above ₹5,000</p>
            </div>
        </div>
    </div>

    <?php endif; ?>
</div>
</div>

<script>
const CSRF_TOKEN = '<?= csrf_hash() ?>';
const CSRF_NAME  = '<?= csrf_token() ?>';

function updateQty(productId, delta) {
    const qtyEl = document.getElementById('qty-' + productId);
    let qty = parseInt(qtyEl.textContent) + delta;
    if (qty < 1) { removeItem(productId); return; }
    qtyEl.textContent = qty;

    const fd = new FormData();
    fd.append('product_id', productId);
    fd.append('quantity', qty);
    fd.append(CSRF_NAME, CSRF_TOKEN);

    fetch('<?= site_url('cart/update') ?>', {
        method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: fd,
    }).then(r => r.json()).then(d => { if (d.success) location.reload(); });
}

function removeItem(productId) {
    const fd = new FormData();
    fd.append('product_id', productId);
    fd.append(CSRF_NAME, CSRF_TOKEN);

    fetch('<?= site_url('cart/remove') ?>', {
        method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: fd,
    }).then(r => r.json()).then(d => {
        if (d.success) {
            const el = document.getElementById('cart-item-' + productId);
            if (el) el.remove();
            if (d.count === 0) location.reload();
            else location.reload();
        }
    });
}
</script>

<?= $this->endSection() ?>
