<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div><h1 style="color:var(--text);font-size:1rem;font-weight:600;margin:0;">Blog Posts</h1></div>
    <a href="<?= site_url('admin/blog/create') ?>" class="btn-gold btn-sm">+ New Post</a>

    <div style="margin-left:auto;display:flex;gap:.5rem;align-items:center;"><a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a></div>
</div>

<div class="content-wrapper">
    <div class="card">
        <?php if (empty($posts)): ?>
        <div style="padding:3rem;text-align:center;color:var(--dim);">No posts yet. <a href="<?= site_url('admin/blog/create') ?>" style="color:var(--gold);">Create one →</a></div>
        <?php else: ?>
        <table>
            <thead><tr><th>Title</th><th>Author</th><th>Published</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($posts as $post): ?>
            <tr>
                <td style="color:var(--text);"><?= esc($post['title']) ?></td>
                <td><?= esc($post['author'] ?? 'Smokey Team') ?></td>
                <td><span class="badge <?= $post['is_published'] ? 'badge-active' : 'badge-inactive' ?>"><?= $post['is_published'] ? 'Published' : 'Draft' ?></span></td>
                <td style="color:var(--dim);font-size:.72rem;"><?= app_date($post['created_at']) ?></td>
                <td>
                    <div style="display:flex;gap:.4rem;">
                        <a href="<?= site_url('admin/blog/'.$post['id'].'/edit') ?>" class="btn-ghost btn-sm">Edit</a>
                        <?php if ($post['is_published']): ?>
                        <a href="<?= site_url('blog/'.$post['slug']) ?>" target="_blank" class="btn-ghost btn-sm">View</a>
                        <?php endif; ?>
                        <form method="post" action="<?= site_url('admin/blog/'.$post['id'].'/delete') ?>" onsubmit="return confirm('Delete this post?')"><?= csrf_field() ?><button type="submit" class="btn-danger">✕</button></form>
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
