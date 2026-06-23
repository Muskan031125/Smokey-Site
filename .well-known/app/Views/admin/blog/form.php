<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php $isEdit = !empty($post); ?>

<div class="page-header">
    <h1 style="color:var(--text);font-size:1rem;font-weight:600;margin:0;"><?= $isEdit ? 'Edit Post' : 'New Blog Post' ?></h1>
    <a href="<?= site_url('admin/blog') ?>" class="btn-ghost btn-sm">← Back</a>

    <div style="margin-left:auto;display:flex;gap:.5rem;align-items:center;"><a href="<?= site_url('logout') ?>" class="header-logout">⎋ Logout</a></div>
</div>

<div class="content-wrapper">
    <form method="post" action="<?= $isEdit ? site_url('admin/blog/'.$post['id']) : site_url('admin/blog') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div style="display:grid;gap:1rem;">
            <div>
                <label class="form-label">Title *</label>
                <input type="text" name="title" required value="<?= esc(old('title', $post['title'] ?? '')) ?>" style="width:100%;font-size:1rem;">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div>
                    <label class="form-label">Author</label>
                    <input type="text" name="author" value="<?= esc(old('author', $post['author'] ?? 'Smokey Team')) ?>" style="width:100%;">
                </div>
                <div>
                    <label class="form-label">Cover Image</label>
                    <input type="file" name="cover_image" accept="image/*" style="width:100%;">
                    <?php if (!empty($post['cover_image'])): ?>
                    <img src="<?= media_url($post['cover_image']) ?>" alt="" style="width:80px;height:50px;object-fit:cover;border-radius:3px;margin-top:.5rem;">
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <label class="form-label">Excerpt / Summary</label>
                <textarea name="excerpt" rows="2" style="width:100%;resize:vertical;"><?= esc(old('excerpt', $post['excerpt'] ?? '')) ?></textarea>
            </div>
            <div>
                <label class="form-label">Body (HTML supported)</label>
                <textarea name="body" rows="16" style="width:100%;resize:vertical;font-family:monospace;"><?= esc(old('body', $post['body'] ?? '')) ?></textarea>
            </div>
            <div>
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;color:var(--muted);font-size:.8rem;">
                    <input type="checkbox" name="is_published" value="1" <?= !empty($post['is_published']) ? 'checked' : '' ?>>
                    Publish this post (visible on website)
                </label>
            </div>
            <div style="display:flex;gap:.75rem;">
                <button type="submit" class="btn-gold"><?= $isEdit ? 'Save Changes' : 'Create Post' ?></button>
                <a href="<?= site_url('admin/blog') ?>" class="btn-outline">Cancel</a>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
