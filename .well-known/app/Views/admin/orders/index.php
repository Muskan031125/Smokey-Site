<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 class="font-serif" style="color:var(--black);font-size:1.4rem;font-weight:600;margin:0;">Orders</h1>
        <p style="color:var(--text-muted);font-size:.75rem;margin:.2rem 0 0;"><?= $total ?> total orders</p>
    </div>

    <div style="margin-left:auto;display:flex;gap:.5rem;align-items:center;"><a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a></div>
</div>

<div class="content-wrapper">
    <!-- Status tabs -->
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1.25rem;">
        <a href="<?= site_url('admin/orders') ?>" style="font-size:.75rem;padding:.4rem .85rem;border-radius:4px;text-decoration:none;font-weight:600;<?= empty($filters['status']) ? 'background:var(--black);color:#fff;' : 'background:var(--white);color:var(--text-muted);border:1px solid var(--border);' ?>">
            All (<?= array_sum($statusCounts) ?>)
        </a>
        <?php foreach ($statusCounts as $s => $count): ?>
        <a href="?status=<?= $s ?>" style="font-size:.75rem;padding:.4rem .85rem;border-radius:4px;text-decoration:none;font-weight:600;<?= ($filters['status'] === $s) ? 'background:var(--black);color:#fff;' : 'background:var(--white);color:var(--text-muted);border:1px solid var(--border);' ?>">
            <?= ucfirst($s) ?> (<?= $count ?>)
        </a>
        <?php endforeach; ?>
    </div>

    <form method="get" style="display:flex;gap:.75rem;margin-bottom:1.25rem;">
        <?php if (!empty($filters['status'])): ?>
        <input type="hidden" name="status" value="<?= esc($filters['status']) ?>">
        <?php endif; ?>
        <input type="text" name="q" value="<?= esc($filters['search']) ?>" placeholder="Search order #, customer name, email..." style="flex:1;max-width:400px;">
        <button type="submit" class="btn-primary btn-sm">Search</button>
    </form>

    <div class="card">
        <?php if (empty($orders)): ?>
        <div style="padding:3rem;text-align:center;color:var(--text-muted);">📭 No orders found.</div>
        <?php else: ?>
        <table>
            <thead><tr><th>Order #</th><th>Customer</th><th>Items</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($orders as $o): ?>
            <tr>
                <td><a href="<?= site_url('admin/orders/'.$o['id']) ?>" style="color:var(--black);font-weight:700;text-decoration:none;"><?= esc($o['order_number']) ?></a></td>
                <td>
                    <div style="color:var(--black);"><?= esc($o['customer_name']) ?></div>
                    <div style="font-size:.7rem;color:var(--text-muted);"><?= esc($o['customer_email']) ?></div>
                </td>
                <td style="color:var(--text-muted);">
                    <?php
                    $db = \Config\Database::connect();
                    $itemCount = $db->table('order_items')->where('order_id', $o['id'])->countAllResults();
                    echo $itemCount . ' item' . ($itemCount !== 1 ? 's' : '');
                    ?>
                </td>
                <td style="color:var(--black);font-weight:700;"><?= money($o['total']) ?></td>
                <td><span class="badge badge-<?= $o['status'] ?>"><?= ucfirst($o['status']) ?></span></td>
                <td style="color:var(--text-muted);font-size:.75rem;"><?= app_datetime($o['created_at']) ?></td>
                <td><a href="<?= site_url('admin/orders/'.$o['id']) ?>" class="btn-outline btn-sm">View</a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
