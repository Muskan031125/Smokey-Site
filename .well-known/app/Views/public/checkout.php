<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div style="background:linear-gradient(180deg,var(--bg-light) 0%,var(--bg-light2) 100%);min-height:60vh;">
<div style="max-width:1100px;margin:0 auto;padding:2.5rem 1.5rem;">

    <div style="text-align:center;margin-bottom:2.5rem;">
        <p style="font-size:.7rem;letter-spacing:.22em;text-transform:uppercase;color:var(--copper);margin-bottom:.5rem;font-weight:600;">Almost there</p>
        <h1 class="font-serif" style="font-size:clamp(1.8rem,4vw,2.75rem);font-weight:400;color:var(--ink);">Checkout</h1>
        <div class="gold-line" style="margin:.75rem auto 0;"></div>
    </div>

    <form method="post" action="<?= site_url('checkout/confirm') ?>">
        <?= csrf_field() ?>
        <div style="display:grid;grid-template-columns:1fr 380px;gap:2rem;align-items:start;" class="grid-cols-1 lg:grid-cols-[1fr_380px]">

            <div style="display:grid;gap:1.5rem;">

                <!-- Customer info -->
                <div style="background:var(--white);border:1px solid var(--border-soft);border-radius:10px;padding:1.75rem;">
                    <h2 class="font-serif" style="font-size:1.2rem;color:var(--black);font-weight:600;margin-bottom:1.25rem;display:flex;align-items:center;gap:.625rem;">
                        <span style="width:26px;height:26px;border-radius:50%;background:var(--black);color:#fff;font-size:.75rem;display:flex;align-items:center;justify-content:center;font-weight:700;font-family:'Inter',sans-serif;">1</span>
                        Your Details
                    </h2>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div>
                            <label style="font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-soft);display:block;margin-bottom:.4rem;font-weight:600;">Full Name *</label>
                            <input type="text" name="customer_name" required
                                   value="<?= esc(old('customer_name', $savedAddress['customer_name'] ?? $user->display_name ?? $user->username ?? '')) ?>"
                                   style="width:100%;padding:.7rem 1rem;font-size:.875rem;border-radius:4px;">
                        </div>
                        <div>
                            <label style="font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-soft);display:block;margin-bottom:.4rem;font-weight:600;">Email *</label>
                            <input type="email" name="customer_email" required
                                   value="<?= esc(old('customer_email', $savedAddress['customer_email'] ?? $user->email ?? '')) ?>"
                                   style="width:100%;padding:.7rem 1rem;font-size:.875rem;border-radius:4px;">
                        </div>
                        <div style="grid-column:1/-1;">
                            <label style="font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-soft);display:block;margin-bottom:.4rem;font-weight:600;">Phone Number *</label>
                            <input type="tel" name="customer_phone" required
                                   value="<?= esc(old('customer_phone', $savedAddress['customer_phone'] ?? $user->phone ?? '')) ?>"
                                   style="width:100%;padding:.7rem 1rem;font-size:.875rem;border-radius:4px;" placeholder="+91 98765 43210">
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div style="background:var(--white);border:1px solid var(--border-soft);border-radius:10px;padding:1.75rem;">
                    <h2 class="font-serif" style="font-size:1.2rem;color:var(--black);font-weight:600;margin-bottom:1.25rem;display:flex;align-items:center;gap:.625rem;">
                        <span style="width:26px;height:26px;border-radius:50%;background:var(--black);color:#fff;font-size:.75rem;display:flex;align-items:center;justify-content:center;font-weight:700;font-family:'Inter',sans-serif;">2</span>
                        Delivery Address
                    </h2>
                    <div style="display:grid;gap:1rem;">
                        <div>
                            <label style="font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-soft);display:block;margin-bottom:.4rem;font-weight:600;">Address Line 1 *</label>
                            <input type="text" name="address_line1" required
                                   value="<?= esc(old('address_line1', $savedAddress['address_line1'] ?? '')) ?>"
                                   style="width:100%;padding:.7rem 1rem;font-size:.875rem;border-radius:4px;" placeholder="House / Flat / Street">
                        </div>
                        <div>
                            <label style="font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-soft);display:block;margin-bottom:.4rem;font-weight:600;">Address Line 2</label>
                            <input type="text" name="address_line2"
                                   value="<?= esc(old('address_line2', $savedAddress['address_line2'] ?? '')) ?>"
                                   style="width:100%;padding:.7rem 1rem;font-size:.875rem;border-radius:4px;" placeholder="Area / Landmark (optional)">
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
                            <div>
                                <label style="font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-soft);display:block;margin-bottom:.4rem;font-weight:600;">City *</label>
                                <input type="text" name="city" required value="<?= esc(old('city', $savedAddress['city'] ?? '')) ?>" style="width:100%;padding:.7rem 1rem;font-size:.875rem;border-radius:4px;">
                            </div>
                            <div>
                                <label style="font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-soft);display:block;margin-bottom:.4rem;font-weight:600;">State *</label>
                                <input type="text" name="state" required value="<?= esc(old('state', $savedAddress['state'] ?? '')) ?>" style="width:100%;padding:.7rem 1rem;font-size:.875rem;border-radius:4px;">
                            </div>
                            <div>
                                <label style="font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-soft);display:block;margin-bottom:.4rem;font-weight:600;">Pincode *</label>
                                <input type="text" name="pincode" required value="<?= esc(old('pincode', $savedAddress['pincode'] ?? '')) ?>" style="width:100%;padding:.7rem 1rem;font-size:.875rem;border-radius:4px;" placeholder="400001">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div style="background:var(--white);border:1px solid var(--border-soft);border-radius:10px;padding:1.75rem;">
                    <h2 class="font-serif" style="font-size:1.2rem;color:var(--black);font-weight:600;margin-bottom:1.25rem;display:flex;align-items:center;gap:.625rem;">
                        <span style="width:26px;height:26px;border-radius:50%;background:var(--black);color:#fff;font-size:.75rem;display:flex;align-items:center;justify-content:center;font-weight:700;font-family:'Inter',sans-serif;">3</span>
                        Order Notes
                        <span style="font-size:.72rem;color:var(--ink-soft);font-weight:400;font-family:'Inter',sans-serif;">(optional)</span>
                    </h2>
                    <textarea name="notes" rows="3" style="width:100%;padding:.7rem 1rem;font-size:.875rem;border-radius:4px;resize:vertical;" placeholder="Any special instructions for your order..."><?= esc(old('notes')) ?></textarea>
                </div>
            </div>

            <!-- Order summary -->
            <div style="position:sticky;top:160px;background:var(--white);border:1px solid var(--border-soft);border-radius:10px;padding:1.5rem;box-shadow:0 4px 16px rgba(0,0,0,.04);">
                <h2 class="font-serif" style="font-size:1.25rem;color:var(--black);margin-bottom:1.25rem;font-weight:500;">Your Order</h2>

                <div style="display:grid;gap:.875rem;margin-bottom:1.25rem;">
                    <?php foreach ($items as $item): ?>
                    <div style="display:flex;gap:.75rem;">
                        <div style="width:48px;height:48px;border-radius:4px;overflow:hidden;background:var(--cream);flex-shrink:0;">
                            <?php if ($item['cover_image']): ?>
                            <img src="<?= esc(str_starts_with($item['cover_image'],'http')?$item['cover_image']:base_url($item['cover_image'])) ?>" alt="" style="width:100%;height:100%;object-fit:cover;">
                            <?php endif; ?>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <p style="font-size:.78rem;color:var(--black);line-height:1.4;font-weight:500;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= esc($item['title']) ?></p>
                            <p style="font-size:.7rem;color:var(--ink-soft);">Qty: <?= $item['quantity'] ?> × <?= money($item['price']) ?></p>
                        </div>
                        <div style="font-size:.85rem;font-weight:600;color:var(--black);flex-shrink:0;"><?= money($item['price'] * $item['quantity']) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div style="border-top:1px solid var(--border-soft);padding-top:1rem;display:grid;gap:.5rem;">
                    <div style="display:flex;justify-content:space-between;font-size:.85rem;color:var(--ink);"><span>Subtotal</span><span><?= money($subtotal) ?></span></div>
                    <div style="display:flex;justify-content:space-between;font-size:.85rem;color:var(--ink-soft);"><span>Shipping</span><span>To be confirmed</span></div>
                    <div style="display:flex;justify-content:space-between;font-weight:700;font-size:1.1rem;color:var(--black);padding-top:.75rem;margin-top:.5rem;border-top:1px solid var(--border-soft);"><span>Total</span><span><?= money($subtotal) ?></span></div>
                </div>

                <button type="submit" class="btn-primary" style="width:100%;padding:1rem;font-size:.8rem;border-radius:6px;text-transform:uppercase;letter-spacing:.1em;font-weight:700;margin-top:1.5rem;">Confirm Order →</button>

                <p style="font-size:.7rem;color:var(--ink-soft);text-align:center;margin-top:1rem;line-height:1.5;">No payment required now.<br>Our team will contact you to confirm.</p>

                <a href="<?= site_url('cart') ?>" style="display:block;text-align:center;font-size:.75rem;color:var(--ink-soft);margin-top:1rem;text-decoration:none;">← Back to Cart</a>
            </div>
        </div>
    </form>
</div>
</div>

<?= $this->endSection() ?>
