<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 class="font-serif" style="color:var(--black);font-size:1.5rem;font-weight:600;margin:0;">Dashboard</h1>
        <p style="color:var(--text-muted);font-size:.78rem;margin:.2rem 0 0;">Smokey Cocktail — <?= date('l, d F Y') ?></p>
    </div>
    <div class="header-actions">
        <a href="<?= site_url('shop') ?>" target="_blank" class="btn-gold btn-sm">🛍 View Catalogue ↗</a>
        <a href="<?= site_url('account/profile') ?>" class="btn-outline btn-sm">My Profile</a>
        <a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a>
    </div>
</div>

<div class="content-wrapper">

    <!-- Stats grid -->
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:1rem;margin-bottom:2rem;">
        <?php foreach ([
            ['Products', $productCount, 'admin/products', 'var(--black)', '📦'],
            ['Categories', $categoryCount, 'admin/categories', 'var(--purple)', '🏷️'],
            ['Total Orders', $totalOrders, 'admin/orders', 'var(--blue)', '🛒'],
            ['Pending Orders', $pendingOrders, 'admin/orders?status=pending', 'var(--orange)', '⏳'],
            ['Pending Reviews', $pendingReviews ?? 0, 'admin/reviews?status=0', 'var(--red)', '⭐'],
            ['Blog Posts', $blogCount ?? 0, 'admin/blog', 'var(--green)', '📰'],
        ] as [$label, $val, $link, $color, $icon]): ?>
        <a href="<?= site_url($link) ?>" class="stat-card" style="text-decoration:none;display:block;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem;">
                <span style="font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;color:var(--text-muted);font-weight:600;"><?= $label ?></span>
                <span style="font-size:1.1rem;"><?= $icon ?></span>
            </div>
            <div style="font-size:2.2rem;font-weight:700;color:<?= $color ?>;font-family:'Crimson Pro',serif;line-height:1;"><?= $val ?></div>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Quick actions -->
    <div style="margin-bottom:2rem;">
        <h3 style="font-size:.7rem;letter-spacing:.15em;text-transform:uppercase;color:var(--text-muted);margin-bottom:.75rem;font-weight:700;">Quick Actions</h3>
        <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
            <a href="<?= site_url('admin/products/create') ?>" class="btn-primary btn-sm">+ Product</a>
            <a href="<?= site_url('admin/blog/create') ?>" class="btn-primary btn-sm">+ Blog Post</a>
            <a href="<?= site_url('admin/reviews?status=0') ?>" class="btn-outline btn-sm">Approve Reviews</a>
            <a href="<?= site_url('admin/orders?status=pending') ?>" class="btn-outline btn-sm">Pending Orders</a>
            <a href="<?= site_url('admin/banners') ?>" class="btn-ghost btn-sm">Edit Banners</a>
            <a href="<?= site_url('admin/promo-codes') ?>" class="btn-ghost btn-sm">Promo Codes</a>
        </div>
    </div>

    <!-- Recent orders -->
    <div class="card">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid var(--border-soft);display:flex;justify-content:space-between;align-items:center;">
            <h2 style="color:var(--black);font-size:.95rem;font-weight:700;margin:0;">Recent Orders</h2>
            <a href="<?= site_url('admin/orders') ?>" style="font-size:.75rem;color:var(--black);text-decoration:none;font-weight:600;">View all →</a>
        </div>
        <?php if (empty($recentOrders)): ?>
        <div style="padding:3rem;text-align:center;color:var(--text-muted);font-size:.85rem;">
            <p style="font-size:1.2rem;margin-bottom:.5rem;">📭</p>
            No orders yet. <a href="<?= site_url('shop') ?>" target="_blank" style="color:var(--gold-warm);font-weight:600;">View store →</a>
        </div>
        <?php else: ?>
        <table>
            <thead><tr><th>Order #</th><th>Customer</th><th>Amount</th><th>Status</th><th>Date</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($recentOrders as $o): ?>
            <tr>
                <td style="color:var(--black);font-weight:600;"><?= esc($o['order_number']) ?></td>
                <td><?= esc($o['customer_name']) ?><br><span style="font-size:.72rem;color:var(--text-muted);"><?= esc($o['customer_email']) ?></span></td>
                <td style="color:var(--black);font-weight:700;"><?= money($o['total']) ?></td>
                <td><span class="badge badge-<?= $o['status'] ?>"><?= ucfirst($o['status']) ?></span></td>
                <td style="color:var(--text-muted);font-size:.75rem;"><?= app_date($o['created_at']) ?></td>
                <td><a href="<?= site_url('admin/orders/'.$o['id']) ?>" style="font-size:.75rem;color:var(--black);text-decoration:none;font-weight:600;">View →</a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
