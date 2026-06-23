<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div style="max-width:780px;margin:0 auto;padding:2.5rem 1.5rem;">
    <a href="<?= site_url('blog') ?>" style="font-size:.75rem;color:var(--dim);text-decoration:none;display:block;margin-bottom:1.5rem;">← Back to Blog</a>

    <?php if ($post['cover_image']): ?>
    <div style="aspect-ratio:16/7;overflow:hidden;border-radius:4px;margin-bottom:2rem;background:#111;">
        <img src="<?= media_url($post['cover_image']) ?>" alt="<?= esc($post['title']) ?>" style="width:100%;height:100%;object-fit:cover;">
    </div>
    <?php endif; ?>

    <p style="font-size:.7rem;letter-spacing:.15em;text-transform:uppercase;color:var(--gold);margin-bottom:1rem;"><?= $post['author'] ?? 'Smokey Team' ?> · <?= app_date($post['published_at']) ?></p>
    <h1 class="font-serif" style="font-size:2.5rem;font-style:italic;font-weight:300;color:var(--text);line-height:1.2;margin-bottom:1.5rem;"><?= esc($post['title']) ?></h1>
    <div class="gold-line" style="margin:0 0 2rem;"></div>

    <div style="font-size:.9rem;color:var(--muted);line-height:1.9;"><?= $post['body'] ?></div>

    <?php if (!empty($related)): ?>
    <div style="margin-top:4rem;border-top:1px solid var(--border);padding-top:2rem;">
        <h2 class="font-serif" style="font-size:1.5rem;font-style:italic;color:var(--text);margin-bottom:1.5rem;">More Articles</h2>
        <div style="display:grid;gap:1.25rem;">
            <?php foreach ($related as $rel): if ($rel['slug'] === $post['slug']) continue; ?>
            <a href="<?= site_url('blog/'.$rel['slug']) ?>" style="text-decoration:none;display:flex;gap:1rem;align-items:center;padding:.875rem;background:var(--card);border:1px solid var(--border);border-radius:4px;transition:border-color .2s;" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'">
                <?php if ($rel['cover_image']): ?>
                <img src="<?= media_url($rel['cover_image']) ?>" alt="" style="width:60px;height:45px;object-fit:cover;border-radius:3px;flex-shrink:0;">
                <?php endif; ?>
                <div>
                    <p class="font-serif" style="font-size:1rem;font-style:italic;color:var(--text);margin:0 0 .25rem;"><?= esc($rel['title']) ?></p>
                    <p style="font-size:.7rem;color:var(--dim);"><?= app_date($rel['published_at']) ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
