<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div style="background:linear-gradient(180deg,var(--bg-soft) 0%,var(--bg) 100%);min-height:60vh;">
<div style="max-width:1200px;margin:0 auto;padding:2.5rem 1.5rem;">
    <div style="text-align:center;margin-bottom:3rem;">
        <p style="font-size:.7rem;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);margin-bottom:.5rem;">Stories</p>
        <h1 class="font-serif" style="font-size:2.75rem;font-style:italic;font-weight:300;color:var(--text);">First Look Articles</h1>
        <div class="gold-line"></div>
    </div>

    <?php if (empty($posts)): ?>
    <div style="text-align:center;padding:5rem;color:var(--dim);">No posts published yet. Check back soon.</div>
    <?php else: ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:2rem;">
        <?php foreach ($posts as $post): ?>
        <a href="<?= site_url('blog/'.$post['slug']) ?>" style="text-decoration:none;background:var(--card);border:1px solid var(--border);border-radius:4px;overflow:hidden;transition:all .3s;display:block;" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'">
            <?php if ($post['cover_image']): ?>
            <div style="aspect-ratio:16/9;overflow:hidden;">
                <img src="<?= media_url($post['cover_image']) ?>" alt="<?= esc($post['title']) ?>" style="width:100%;height:100%;object-fit:cover;transition:transform .5s;" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform=''">
            </div>
            <?php else: ?>
            <div style="aspect-ratio:16/9;background:var(--card2);display:flex;align-items:center;justify-content:center;"><span style="font-size:2rem;opacity:.15;">📰</span></div>
            <?php endif; ?>
            <div style="padding:1.5rem;">
                <p style="font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);margin-bottom:.5rem;"><?= $post['author'] ?? 'Smokey Team' ?> · <?= app_date($post['published_at'] ?? $post['created_at']) ?></p>
                <h2 class="font-serif" style="font-size:1.3rem;font-style:italic;color:var(--text);line-height:1.3;margin-bottom:.75rem;"><?= esc($post['title']) ?></h2>
                <p style="font-size:.8rem;color:var(--muted);line-height:1.7;"><?= esc(mb_substr(strip_tags($post['excerpt'] ?? $post['body'] ?? ''), 0, 130)) ?>…</p>
                <span style="font-size:.75rem;color:var(--gold);display:block;margin-top:1rem;">Read Article →</span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
</div>

<?= $this->endSection() ?>
