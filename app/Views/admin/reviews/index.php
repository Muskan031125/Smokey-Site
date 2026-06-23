<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 style="color:var(--text);font-size:1rem;font-weight:600;margin:0;">Reviews</h1>
        <p style="font-size:.72rem;color:var(--dim);margin:.15rem 0 0;"><?= $pending ?> pending approval</p>
    </div>
    <div style="display:flex;gap:.5rem;">
        <a href="?status=0" class="btn-ghost btn-sm" style="<?= ($filters['is_approved']==='0')?'border-color:var(--gold);color:var(--gold);':'' ?>">Pending (<?= $pending ?>)</a>
        <a href="?status=1" class="btn-ghost btn-sm" style="<?= ($filters['is_approved']==='1')?'border-color:var(--gold);color:var(--gold);':'' ?>">Approved</a>
        <a href="<?= site_url('admin/reviews') ?>" class="btn-ghost btn-sm">All</a>
    </div>

    <div style="margin-left:auto;display:flex;gap:.5rem;align-items:center;"><a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a></div>
</div>

<div class="content-wrapper">
    <div class="card">
        <?php if (empty($reviews)): ?>
        <div style="padding:3rem;text-align:center;color:var(--dim);">No reviews found.</div>
        <?php else: ?>
        <table>
            <thead><tr><th>Product</th><th>Reviewer</th><th>Rating</th><th>Review</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($reviews as $rv): ?>
            <tr>
                <td>
                    <a href="<?= site_url('product/'.$rv['handle']) ?>" target="_blank" style="color:var(--muted);text-decoration:none;font-size:.75rem;"><?= esc(mb_substr($rv['product_title'],0,30)) ?>…</a>
                </td>
                <td>
                    <div style="color:var(--text);"><?= esc($rv['name']) ?></div>
                    <div style="font-size:.7rem;color:var(--dim);"><?= esc($rv['email'] ?? '') ?></div>
                </td>
                <td>
                    <span style="color:var(--gold);"><?= str_repeat('★', (int)$rv['rating']) ?><?= str_repeat('☆', 5 - (int)$rv['rating']) ?></span>
                </td>
                <td style="max-width:220px;">
                    <?php if ($rv['title']): ?><div style="font-weight:600;color:var(--text);margin-bottom:.15rem;"><?= esc($rv['title']) ?></div><?php endif; ?>
                    <div style="font-size:.75rem;"><?= esc(mb_substr($rv['body'] ?? '', 0, 80)) ?>…</div>
                </td>
                <td style="color:var(--dim);font-size:.72rem;"><?= app_date($rv['created_at']) ?></td>
                <td>
                    <span class="badge <?= $rv['is_approved'] ? 'badge-approved' : 'badge-pending-rv' ?>">
                        <?= $rv['is_approved'] ? 'Approved' : 'Pending' ?>
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:.4rem;">
                        <?php if (!$rv['is_approved']): ?>
                        <form method="post" action="<?= site_url('admin/reviews/'.$rv['id'].'/approve') ?>"><?= csrf_field() ?><button type="submit" class="btn-gold btn-sm">Approve</button></form>
                        <?php else: ?>
                        <form method="post" action="<?= site_url('admin/reviews/'.$rv['id'].'/reject') ?>"><?= csrf_field() ?><button type="submit" class="btn-ghost btn-sm">Hide</button></form>
                        <?php endif; ?>
                        <form method="post" action="<?= site_url('admin/reviews/'.$rv['id'].'/delete') ?>" onsubmit="return confirm('Delete this review?')"><?= csrf_field() ?><button type="submit" class="btn-danger">✕</button></form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
