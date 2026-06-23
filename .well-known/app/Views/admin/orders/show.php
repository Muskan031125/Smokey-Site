<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;">
    <div>
        <a href="<?= site_url('admin/orders') ?>" style="font-size:.75rem;color:#555;">← Orders</a>
        <h1 style="color:#e8e0d0;font-size:1.1rem;font-weight:600;margin:.25rem 0 0;"><?= esc($order['order_number']) ?></h1>
        <p style="color:#555;font-size:.75rem;margin:.2rem 0 0;"><?= app_datetime($order['created_at']) ?></p>
    </div>
    <!-- Status update form -->
    <form method="post" action="<?= site_url('admin/orders/'.$order['id'].'/status') ?>" style="display:flex;gap:.5rem;align-items:center;">
        <?= csrf_field() ?>
        <select name="status" style="padding:.45rem .875rem;font-size:.8rem;">
            <?php foreach (['pending','confirmed','processing','shipped','delivered','cancelled'] as $s): ?>
            <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn-gold btn-sm">Update Status</button>
    </form>

    <div style="margin-left:auto;display:flex;gap:.5rem;align-items:center;"><a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a></div>
</div>

<div style="padding:1.25rem 1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;max-width:1000px;">

    <!-- Customer info -->
    <div class="card" style="padding:1.25rem;">
        <h2 style="color:#c9a84c;font-size:.75rem;letter-spacing:.15em;text-transform:uppercase;margin:0 0 1rem;">Customer</h2>
        <div style="space-y:.5rem;font-size:.875rem;color:#8a8a7a;">
            <p style="color:#c0b898;font-weight:600;margin:0 0 .35rem;"><?= esc($order['customer_name']) ?></p>
            <p style="margin:0 0 .25rem;"><?= esc($order['customer_email']) ?></p>
            <p style="margin:0 0 .25rem;"><?= esc($order['customer_phone']) ?></p>
        </div>
    </div>

    <!-- Delivery address -->
    <div class="card" style="padding:1.25rem;">
        <h2 style="color:#c9a84c;font-size:.75rem;letter-spacing:.15em;text-transform:uppercase;margin:0 0 1rem;">Delivery Address</h2>
        <div style="font-size:.875rem;color:#8a8a7a;line-height:1.6;">
            <p style="margin:0;"><?= esc($order['address_line1']) ?></p>
            <?php if ($order['address_line2']): ?><p style="margin:0;"><?= esc($order['address_line2']) ?></p><?php endif; ?>
            <p style="margin:0;"><?= esc($order['city']) ?>, <?= esc($order['state']) ?> — <?= esc($order['pincode']) ?></p>
        </div>
    </div>

    <!-- Order summary -->
    <div class="card" style="padding:1.25rem;">
        <h2 style="color:#c9a84c;font-size:.75rem;letter-spacing:.15em;text-transform:uppercase;margin:0 0 1rem;">Summary</h2>
        <div style="font-size:.875rem;">
            <div style="display:flex;justify-content:space-between;margin-bottom:.5rem;">
                <span style="color:#666;">Status</span>
                <span class="badge badge-<?= $order['status'] ?>"><?= ucfirst($order['status']) ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:.5rem;">
                <span style="color:#666;">Subtotal</span>
                <span style="color:#c0b898;"><?= money($order['subtotal']) ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;font-weight:700;border-top:1px solid #2a2a2a;padding-top:.5rem;margin-top:.5rem;">
                <span style="color:#e8e0d0;">Total</span>
                <span style="color:#c9a84c;"><?= money($order['total']) ?></span>
            </div>
        </div>
        <?php if ($order['notes']): ?>
        <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid #1e1e1e;font-size:.8rem;color:#666;">
            <p style="margin:0 0 .25rem;color:#888;">Notes:</p>
            <p style="margin:0;"><?= esc($order['notes']) ?></p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Order items -->
    <div class="card" style="grid-column:1/-1;overflow:hidden;">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #1e1e1e;">
            <h2 style="color:#e8e0d0;font-size:.9rem;font-weight:600;margin:0;">Items Ordered</h2>
        </div>
        <table>
            <thead><tr><th style="width:56px;"></th><th>Product</th><th>SKU</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
            <tbody>
            <?php foreach ($order['items'] as $item): ?>
            <tr>
                <td>
                    <?php if ($item['cover_image']): ?>
                    <img src="<?= media_url($item['cover_image']) ?>" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:.25rem;">
                    <?php else: ?>
                    <div style="width:40px;height:40px;background:#1e1e1e;border-radius:.25rem;"></div>
                    <?php endif; ?>
                </td>
                <td style="color:#c0b898;"><?= esc($item['title']) ?></td>
                <td style="color:#555;"><?= esc($item['sku'] ?? '—') ?></td>
                <td><?= money($item['price']) ?></td>
                <td style="color:#e8e0d0;"><?= $item['quantity'] ?></td>
                <td style="color:#c9a84c;font-weight:600;"><?= money($item['subtotal']) ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
