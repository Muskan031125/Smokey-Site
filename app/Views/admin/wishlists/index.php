<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 style="color:var(--text);font-size:1rem;font-weight:600;margin:0;">Wishlists</h1>
        <p style="font-size:.72rem;color:var(--dim);margin:.15rem 0 0;"><?= $total ?> total wishlist entries</p>
    </div>

    <div style="margin-left:auto;display:flex;gap:.5rem;align-items:center;"><a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a></div>
</div>

<div class="content-wrapper">
    <div class="card">
        <?php if (empty($rows)): ?>
        <div style="padding:3rem;text-align:center;color:var(--dim);">No wishlist data yet.</div>
        <?php else: ?>
        <table>
            <thead><tr><th>Product</th><th style="text-align:right;">Wishlisted by</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td style="color:var(--text);"><?= esc($row['title']) ?></td>
                <td style="text-align:right;">
                    <span class="badge badge-pending"><?= $row['wish_count'] ?> people</span>
                </td>
                <td>
                    <a href="<?= site_url('product/'.$row['handle']) ?>" target="_blank" style="font-size:.72rem;color:var(--gold);text-decoration:none;">View product →</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
