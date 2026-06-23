<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div style="max-width:1200px;margin:0 auto;padding:2rem 1.5rem;">

    <!-- Breadcrumb -->
    <p style="font-size:.72rem;color:var(--ink-soft);margin-bottom:1.5rem;text-align:center;">
        <a href="<?= site_url('shop') ?>" style="color:var(--ink-soft);text-decoration:none;">Shop</a>
        <?php if ($product['category_name']): ?>
        / <a href="<?= site_url('category/'.$product['category_slug']) ?>" style="color:var(--ink-soft);text-decoration:none;"><?= esc($product['category_name']) ?></a>
        <?php endif; ?>
        / <span style="color:var(--black);"><?= esc($product['title']) ?></span>
    </p>

    <div class="product-page-grid">

        <!-- IMAGE GALLERY -->
        <div>
            <div style="aspect-ratio:1;background:var(--cream);border-radius:10px;overflow:hidden;margin-bottom:.875rem;position:relative;border:1px solid var(--border-soft);">
                <?php
                $cover = current(array_filter($media, fn($m) => $m['is_cover'] && $m['type'] === 'image')) ?: ($media[0] ?? null);
                ?>
                <?php if ($cover && $cover['type'] === 'image'): ?>
                <img src="<?= esc(str_starts_with($cover['path'],'http')?$cover['path']:base_url($cover['path'])) ?>" alt="<?= esc($product['title']) ?>"
                     id="main-img" style="width:100%;height:100%;object-fit:cover;cursor:zoom-in;" onclick="openZoom(this.src)">
                <?php else: ?>
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;opacity:.2;font-size:3rem;"></div>
                <?php endif; ?>

                <?php if (count($media) > 1): ?>
                <button onclick="prevImg()" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.95);border:1px solid var(--border-soft);color:var(--black);width:38px;height:38px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1.2rem;box-shadow:0 2px 8px rgba(0,0,0,.08);">‹</button>
                <button onclick="nextImg()" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.95);border:1px solid var(--border-soft);color:var(--black);width:38px;height:38px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1.2rem;box-shadow:0 2px 8px rgba(0,0,0,.08);">›</button>
                <?php endif; ?>
            </div>

            <?php if (count($media) > 1): ?>
            <div style="display:flex;gap:.5rem;overflow-x:auto;padding-bottom:.25rem;" id="thumb-strip">
                <?php foreach ($media as $mi => $m): if ($m['type'] !== 'image') continue; ?>
                <button onclick="setImg(<?= $mi ?>, '<?= esc(str_starts_with($m['path'],'http')?$m['path']:base_url($m['path'])) ?>')"
                        style="width:70px;height:70px;border-radius:6px;overflow:hidden;border:2px solid <?= $m['is_cover'] ? 'var(--black)' : 'var(--border-soft)' ?>;flex-shrink:0;cursor:pointer;background:var(--cream);padding:0;transition:border-color .2s;"
                        class="thumb-btn" data-idx="<?= $mi ?>">
                    <img src="<?= esc(str_starts_with($m['path'],'http')?$m['path']:base_url($m['path'])) ?>" alt="" style="width:100%;height:100%;object-fit:cover;">
                </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Share buttons -->
            <div style="display:flex;align-items:center;gap:.75rem;margin-top:1.5rem;">
                <span style="font-size:.7rem;color:var(--ink-soft);letter-spacing:.1em;text-transform:uppercase;">Share</span>
                <?php
                $shareUrl   = urlencode(current_url());
                $shareTitle = urlencode($product['title']);
                $shareLinks = [
                    ['WhatsApp','https://wa.me/?text='.$shareTitle.'%20'.$shareUrl,'#25D366'],
                    ['Facebook','https://www.facebook.com/sharer/sharer.php?u='.$shareUrl,'#1877F2'],
                    ['Twitter','https://twitter.com/intent/tweet?url='.$shareUrl.'&text='.$shareTitle,'#1DA1F2'],
                ];
                foreach ($shareLinks as [$name, $url, $color]):
                ?>
                <a href="<?= $url ?>" target="_blank" rel="noopener" aria-label="<?= $name ?>"
                   style="width:34px;height:34px;border-radius:50%;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--ink-soft);text-decoration:none;font-size:.7rem;font-weight:600;transition:all .2s;"
                   onmouseover="this.style.borderColor='<?= $color ?>';this.style.color='<?= $color ?>'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--ink-soft)'">
                    <?= mb_substr($name,0,1) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- PRODUCT INFO -->
        <div>
            <?php if ($product['vendor'] && $product['vendor'] !== 'Smokey Cocktail'): ?>
            <p style="font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-soft);margin-bottom:.5rem;font-weight:600;"><?= esc($product['vendor']) ?></p>
            <?php endif; ?>

            <h1 class="font-serif" style="font-size:clamp(1.6rem,3vw,2.2rem);font-weight:500;color:var(--black);line-height:1.2;margin-bottom:.875rem;"><?= esc($product['title']) ?></h1>

            <?php if ($ratingStats['count'] > 0): ?>
            <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:1rem;">
                <span>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span style="color:<?= $i <= round($ratingStats['avg']) ? 'var(--gold)' : '#d8d3c5' ?>;font-size:.9rem;">★</span>
                    <?php endfor; ?>
                </span>
                <span style="font-size:.8rem;color:var(--ink-soft);"><?= number_format($ratingStats['avg'], 1) ?> · <?= $ratingStats['count'] ?> review<?= $ratingStats['count'] !== 1 ? 's' : '' ?></span>
                <a href="#reviews" style="font-size:.75rem;color:var(--black);text-decoration:underline;">See reviews →</a>
            </div>
            <?php endif; ?>

            <div style="display:flex;align-items:baseline;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
                <span id="display-price" style="font-size:2rem;font-weight:700;color:var(--black);font-family:'Inter',sans-serif;"><?= money($product['price']) ?></span>
                <?php if ($product['compare_price'] && $product['compare_price'] > $product['price']): ?>
                <span style="font-size:1rem;text-decoration:line-through;color:var(--ink-soft);"><?= money($product['compare_price']) ?></span>
                <?php $disc = round((($product['compare_price'] - $product['price']) / $product['compare_price']) * 100); ?>
                <span style="background:var(--red);color:#fff;font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:3px;letter-spacing:.05em;"><?= $disc ?>% OFF</span>
                <?php endif; ?>
            </div>

            <?php if (!empty($promoCodes)): ?>
            <div style="background:#fffbf0;border:1px dashed var(--gold);border-radius:6px;padding:.875rem 1rem;margin-bottom:1.5rem;">
                <p style="font-size:.65rem;letter-spacing:.1em;text-transform:uppercase;color:var(--gold-warm);margin-bottom:.5rem;font-weight:700;">💸 Available Offers</p>
                <?php foreach ($promoCodes as $pc): ?>
                <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.4rem;">
                    <code style="background:#fff;color:var(--black);padding:.2rem .55rem;border:1px dashed var(--gold);border-radius:3px;font-size:.72rem;font-weight:700;letter-spacing:.06em;cursor:pointer;font-family:'Inter',monospace;" onclick="navigator.clipboard.writeText('<?= esc($pc['code']) ?>');this.textContent='Copied!';setTimeout(()=>this.textContent='<?= esc($pc['code']) ?>',1500);"><?= esc($pc['code']) ?></code>
                    <span style="font-size:.75rem;color:var(--ink);"><?= esc($pc['label']) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div style="height:1px;background:var(--border-soft);margin-bottom:1.5rem;"></div>

            <?php foreach ($variantGroups as $optName => $variants): ?>
            <div style="margin-bottom:1.25rem;">
                <p style="font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-soft);margin-bottom:.5rem;font-weight:600;">
                    <?= esc($optName) ?>: <strong id="selected-<?= esc(str_replace(' ','-',$optName)) ?>" style="color:var(--black);">Select</strong>
                </p>
                <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
                    <?php foreach ($variants as $v): ?>
                    <button type="button" class="variant-btn" data-option="<?= esc($optName) ?>" data-value="<?= esc($v['option_value']) ?>" data-modifier="<?= $v['price_modifier'] ?>"
                            style="padding:.5rem 1rem;border:1.5px solid var(--border);border-radius:4px;font-size:.8rem;color:var(--ink);cursor:pointer;background:#fff;transition:all .2s;font-weight:500;">
                        <?= esc($v['option_value']) ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if ($product['is_in_stock']): ?>
            <form class="add-to-cart-form" method="post" action="<?= site_url('cart/add') ?>" style="margin-bottom:.75rem;">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div style="display:flex;gap:.75rem;margin-bottom:.75rem;">
                    <div style="display:flex;align-items:center;border:1.5px solid var(--border);border-radius:4px;overflow:hidden;background:#fff;">
                        <button type="button" onclick="changeQty(-1)" style="width:42px;height:50px;border:none;background:transparent;color:var(--black);font-size:1.2rem;cursor:pointer;font-weight:600;">−</button>
                        <input type="number" name="quantity" id="qty-input" value="1" min="1" max="99"
                               style="width:48px;text-align:center;border:none!important;background:transparent!important;font-size:.95rem;height:50px;padding:0;font-weight:600;">
                        <button type="button" onclick="changeQty(1)" style="width:42px;height:50px;border:none;background:transparent;color:var(--black);font-size:1.2rem;cursor:pointer;font-weight:600;">+</button>
                    </div>
                    <button type="submit" class="btn-neon" style="flex:1;padding:.85rem;font-size:.8rem;border-radius:4px;height:50px;text-transform:uppercase;letter-spacing:.08em;font-weight:700;">Add to Cart</button>
                </div>
            </form>

            <div style="display:flex;gap:.75rem;margin-bottom:1.5rem;">
                <button class="wish-btn <?= $isWishlisted ? 'active' : '' ?>" data-pid="<?= $product['id'] ?>"
                        style="position:static;width:auto;height:auto;border-radius:4px;background:#fff;border:1.5px solid var(--border);padding:.7rem 1rem;display:flex;align-items:center;gap:.4rem;font-size:.78rem;color:var(--black);cursor:pointer;transition:all .2s;font-weight:500;">
                    <svg viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    <?= $isWishlisted ? 'Wishlisted' : 'Add to Wishlist' ?>
                </button>
                <a href="<?= site_url('cart') ?>" class="btn-outline-neon" style="flex:1;padding:.7rem 1rem;font-size:.78rem;border-radius:4px;text-align:center;text-transform:uppercase;">View Cart →</a>
            </div>
            <?php else: ?>
            <div style="padding:1rem;background:var(--cream);border:1px solid var(--border);border-radius:6px;text-align:center;margin-bottom:1.5rem;">
                <p style="color:var(--ink-soft);font-size:.9rem;font-weight:600;">Sold Out</p>
            </div>
            <?php endif; ?>

            <div style="height:1px;background:var(--border-soft);margin-bottom:1.25rem;"></div>

            <?php
            $details = array_filter([
                'SKU'       => $product['sku'] ?? null,
                'Material'  => $product['material'] ?? null,
                'Colour'    => $product['colour'] ?? null,
                'Size'      => $product['size'] ?? null,
            ]);
            ?>
            <?php foreach ($details as $label => $val): ?>
            <div style="display:flex;font-size:.8rem;margin-bottom:.5rem;">
                <span style="width:80px;flex-shrink:0;color:var(--ink-soft);"><?= $label ?></span>
                <span style="color:var(--ink);font-weight:500;"><?= esc($val) ?></span>
            </div>
            <?php endforeach; ?>

            <div style="margin-top:1.5rem;padding:1rem;background:var(--cream2);border-radius:6px;font-size:.8rem;color:var(--ink);">
                🚚 Dispatched in 2 days &nbsp;·&nbsp; 💰 COD available &nbsp;·&nbsp; ↩ 7-day returns
            </div>
        </div>
    </div>

    <!-- DESCRIPTION TABS -->
    <?php if ($product['description']): ?>
    <div style="margin-top:4rem;border-top:1px solid var(--border-soft);padding-top:2.5rem;max-width:850px;margin-left:auto;margin-right:auto;">
        <div style="display:flex;gap:2.5rem;border-bottom:1px solid var(--border-soft);margin-bottom:2rem;" id="tabs">
            <?php foreach (['Description', 'Care Instructions', 'Shipping & Returns'] as $ti => $tab): ?>
            <button onclick="switchTab(<?= $ti ?>)" class="tab-btn" data-tab="<?= $ti ?>"
                    style="font-size:.78rem;letter-spacing:.08em;text-transform:uppercase;color:<?= $ti === 0 ? 'var(--black)' : 'var(--ink-soft)' ?>;background:none;border:none;cursor:pointer;padding:.875rem 0;border-bottom:2px solid <?= $ti === 0 ? 'var(--black)' : 'transparent' ?>;margin-bottom:-1px;font-weight:600;">
                <?= $tab ?>
            </button>
            <?php endforeach; ?>
        </div>

        <div id="tab-description" class="tab-content" style="font-size:.9rem;color:var(--ink);line-height:1.8;">
            <?= $product['description'] ?>
        </div>
        <div id="tab-care" class="tab-content" style="display:none;font-size:.9rem;color:var(--ink);line-height:1.8;">
            <ul style="list-style:disc;padding-left:1.5rem;">
                <li>Clean with a soft, damp cloth</li>
                <li>Avoid harsh chemicals or abrasive cleaners</li>
                <li>Handle with care — fragile materials</li>
                <li>Keep away from direct sunlight to prevent fading</li>
            </ul>
        </div>
        <div id="tab-shipping" class="tab-content" style="display:none;font-size:.9rem;color:var(--ink);line-height:1.8;">
            <ul style="list-style:disc;padding-left:1.5rem;">
                <li><strong>Dispatch:</strong> Orders dispatched within 2 working days</li>
                <li><strong>Free shipping</strong> on orders above ₹5,000</li>
                <li><strong>Returns:</strong> 7-day easy returns on unused products</li>
                <li><strong>COD:</strong> Cash on Delivery available across India</li>
            </ul>
        </div>
    </div>
    <?php endif; ?>

    <!-- REVIEWS -->
    <div id="reviews" style="margin-top:4rem;border-top:1px solid var(--border-soft);padding-top:2.5rem;max-width:1000px;margin-left:auto;margin-right:auto;">
        <div style="text-align:center;margin-bottom:2rem;">
            <h2 class="font-serif" style="font-size:1.75rem;font-weight:500;color:var(--black);">Customer Reviews</h2>
            <?php if ($ratingStats['count'] > 0): ?>
            <div style="display:flex;align-items:center;justify-content:center;gap:.75rem;margin-top:1rem;">
                <span style="font-size:2.5rem;font-weight:700;color:var(--black);"><?= number_format($ratingStats['avg'],1) ?></span>
                <div style="text-align:left;">
                    <div style="font-size:1.1rem;">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span style="color:<?= $i <= round($ratingStats['avg']) ? 'var(--gold)' : '#d8d3c5' ?>;">★</span>
                        <?php endfor; ?>
                    </div>
                    <p style="font-size:.75rem;color:var(--ink-soft);"><?= $ratingStats['count'] ?> verified review<?= $ratingStats['count'] !== 1 ? 's' : '' ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($reviews)): ?>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.25rem;margin-bottom:2.5rem;">
            <?php foreach ($reviews as $rv): ?>
            <div style="background:var(--white);border:1px solid var(--border-soft);border-radius:8px;padding:1.25rem;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.625rem;">
                    <div>
                        <p style="font-weight:600;color:var(--black);font-size:.875rem;margin-bottom:.15rem;"><?= esc($rv['name']) ?></p>
                        <div style="font-size:.85rem;">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span style="color:<?= $i <= $rv['rating'] ? 'var(--gold)' : '#d8d3c5' ?>;">★</span>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <span style="font-size:.7rem;color:var(--ink-soft);"><?= app_date($rv['created_at']) ?></span>
                </div>
                <?php if ($rv['title']): ?><p style="font-weight:600;font-size:.85rem;color:var(--black);margin-bottom:.35rem;">"<?= esc($rv['title']) ?>"</p><?php endif; ?>
                <?php if ($rv['body']): ?><p style="font-size:.8rem;color:var(--ink);line-height:1.6;"><?= esc($rv['body']) ?></p><?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Write review -->
        <div style="background:var(--cream2);border:1px solid var(--border-soft);border-radius:10px;padding:2rem;max-width:600px;margin:0 auto;">
            <h3 class="font-serif" style="font-size:1.25rem;color:var(--black);margin-bottom:1.25rem;font-weight:500;text-align:center;">Write a Review</h3>
            <form method="post" action="<?= site_url('reviews/submit') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                    <div>
                        <label style="font-size:.7rem;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-soft);display:block;margin-bottom:.4rem;font-weight:600;">Name *</label>
                        <input type="text" name="name" required value="<?= esc(old('name', auth()->loggedIn() ? (auth()->user()->display_name ?? auth()->user()->username) : '')) ?>" style="width:100%;padding:.6rem .875rem;font-size:.85rem;border-radius:4px;">
                    </div>
                    <div>
                        <label style="font-size:.7rem;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-soft);display:block;margin-bottom:.4rem;font-weight:600;">Email</label>
                        <input type="email" name="email" value="<?= esc(old('email', auth()->loggedIn() ? auth()->user()->email : '')) ?>" style="width:100%;padding:.6rem .875rem;font-size:.85rem;border-radius:4px;">
                    </div>
                </div>
                <div style="margin-bottom:1rem;text-align:center;">
                    <label style="font-size:.7rem;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-soft);display:block;margin-bottom:.5rem;font-weight:600;">Your Rating *</label>
                    <div style="display:inline-flex;gap:.3rem;">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <button type="button" onclick="setRating(<?= $i ?>)" class="star-pick" data-r="<?= $i ?>"
                                style="font-size:1.8rem;background:none;border:none;cursor:pointer;color:#d8d3c5;line-height:1;padding:0;">★</button>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="5">
                </div>
                <div style="margin-bottom:1rem;">
                    <input type="text" name="title" placeholder="Review title (optional)" style="width:100%;padding:.6rem .875rem;font-size:.85rem;border-radius:4px;">
                </div>
                <div style="margin-bottom:1.25rem;">
                    <textarea name="body" rows="4" placeholder="Share your thoughts..." style="width:100%;padding:.6rem .875rem;font-size:.85rem;border-radius:4px;resize:vertical;"></textarea>
                </div>
                <button type="submit" class="btn-neon" style="width:100%;padding:.85rem;font-size:.78rem;border-radius:4px;text-transform:uppercase;letter-spacing:.08em;">Submit Review</button>
            </form>
        </div>
    </div>

    <!-- RELATED -->
    <?php if (!empty($related)): ?>
    <div style="margin-top:4rem;border-top:1px solid var(--border-soft);padding-top:2.5rem;">
        <h2 class="font-serif" style="font-size:1.75rem;font-weight:500;color:var(--black);text-align:center;margin-bottom:2rem;">You Might Also Like</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(195px,1fr));gap:1.25rem;">
            <?php foreach ($related as $r): ?>
            <?= view('partials/product_card', ['p' => $r, 'wishlistedIds' => [$isWishlisted ? $product['id'] : -1]]) ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Zoom modal -->
<div id="zoom-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.9);align-items:center;justify-content:center;cursor:zoom-out;" onclick="document.getElementById('zoom-modal').style.display='none'">
    <img id="zoom-img" src="" alt="" style="max-width:90vw;max-height:90vh;object-fit:contain;">
</div>

<script>
const imgs = <?= json_encode(array_values(array_map(fn($m) => str_starts_with($m['path'],'http')?$m['path']:base_url($m['path']), array_filter($media, fn($m) => $m['type'] === 'image')))) ?>;
let curIdx = 0;
function setImg(idx, src) {
    curIdx = idx;
    document.getElementById('main-img').src = src;
    document.querySelectorAll('.thumb-btn').forEach(b => b.style.borderColor = b.dataset.idx == idx ? 'var(--black)' : 'var(--border-soft)');
}
function nextImg() { if(imgs.length){curIdx=(curIdx+1)%imgs.length;setImg(curIdx,imgs[curIdx]);} }
function prevImg() { if(imgs.length){curIdx=(curIdx-1+imgs.length)%imgs.length;setImg(curIdx,imgs[curIdx]);} }
function openZoom(src) { document.getElementById('zoom-img').src=src; document.getElementById('zoom-modal').style.display='flex'; }
function changeQty(d) {
    const inp = document.getElementById('qty-input');
    inp.value = Math.max(1, parseInt(inp.value||1)+d);
}
function switchTab(n) {
    document.querySelectorAll('.tab-content').forEach((el,i) => el.style.display = i===n ? '' : 'none');
    document.querySelectorAll('.tab-btn').forEach((btn,i) => {
        btn.style.color = i===n ? 'var(--black)' : 'var(--ink-soft)';
        btn.style.borderBottomColor = i===n ? 'var(--black)' : 'transparent';
    });
}
function setRating(n) {
    document.getElementById('rating-input').value = n;
    document.querySelectorAll('.star-pick').forEach(s => s.style.color = parseInt(s.dataset.r) <= n ? 'var(--gold)' : '#d8d3c5');
}
setRating(5);

let priceModifier = 0;
const basePrice = <?= (float)$product['price'] ?>;
document.querySelectorAll('.variant-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const optName = this.dataset.option;
        document.querySelectorAll(`.variant-btn[data-option="${optName}"]`).forEach(b => {
            b.style.borderColor = 'var(--border)'; b.style.background = '#fff'; b.style.color = 'var(--ink)';
        });
        this.style.borderColor = 'var(--black)'; this.style.background = 'var(--black)'; this.style.color = '#fff';
        document.getElementById('selected-' + optName.replace(/ /g,'-')).textContent = this.dataset.value;
        priceModifier = parseFloat(this.dataset.modifier || 0);
        const newPrice = basePrice + priceModifier;
        document.getElementById('display-price').textContent = '₹ ' + newPrice.toLocaleString('en-IN');
    });
});
</script>

<?= $this->endSection() ?>
