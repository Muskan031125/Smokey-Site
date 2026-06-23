<?= $this->extend('layouts/portal') ?>
<?= $this->section('content') ?>

<section class="py-10 md:py-24">
  <div class="max-w-7xl mx-auto px-4 md:px-6">
    <div class="mb-8">
      <a href="<?= site_url('portal') ?>" class="hover:text-gold" style="font-family:'Crimson Pro',serif; font-style:italic; font-size:1rem; color:#1f1f1f;">← All Collections</a>
    </div>

    <div class="text-center mb-8 md:mb-12 reveal">
      <p class="text-base text-gold mb-4" style="font-family:'Crimson Pro',serif; font-style:italic;"><span class="divider mr-3"></span>Collection<span class="divider ml-3"></span></p>
      <h1 class="font-display fluid-h1 font-bold"><?= esc($category['name']) ?></h1>
      <?php if (!empty($category['description'])): ?>
        <p class="text-muted mt-4 max-w-xl mx-auto"><?= esc($category['description']) ?></p>
      <?php endif; ?>
      <p class="text-xs text-muted mt-3">Pricing live at gold rate ₹ <?= number_format($goldRate, 0) ?>/g</p>
    </div>

    <?php if (empty($products)): ?>
      <div class="text-center py-16 text-muted">No items currently in this collection.</div>
    <?php else: ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        <?php foreach ($products as $i => $p): ?>
          <a href="<?= site_url('portal/product/' . $p['id']) ?>" class="group reveal delay-<?= ($i % 4) + 1 ?>">
            <div class="relative overflow-hidden bg-white aspect-square mb-3 md:mb-4">
              <?php
                $coverPath = $p['cover']['path'] ?? null;
                $coverType = $p['cover']['type'] ?? null;
                // If the cover is a Vimeo video, use its poster frame instead of a broken image.
                $isVideoCover = $coverType === 'video';
                $coverVimeoId = $isVideoCover && preg_match('~vimeo\.com/(?:video/)?(\d+)~i', (string) $coverPath, $vm) ? $vm[1] : null;
                if ($coverVimeoId) {
                    $src = 'https://vumbnail.com/' . $coverVimeoId . '.jpg';
                } else {
                    $src = media_url($coverPath) ?: media_url($category['cover_image'] ?? null);
                }
              ?>
              <?php if ($src): ?>
                <img src="<?= esc($src) ?>" alt="<?= esc($p['tag_no']) ?>" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-700"/>
                <?php if ($isVideoCover): ?>
                  <div class="absolute inset-0 flex items-center justify-center">
                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-black/55 text-white">▶</span>
                  </div>
                <?php elseif (empty($coverPath)): ?>
                  <div class="absolute inset-0 bg-gradient-to-t from-ink/60 to-transparent"></div>
                  <span class="absolute bottom-3 left-3 text-[10px] uppercase tracking-widest text-cream/80">Media pending</span>
                <?php endif; ?>
              <?php else: ?>
                <div class="w-full h-full bg-zinc-200 flex items-center justify-center text-muted text-xs uppercase tracking-widest">No image</div>
              <?php endif; ?>
              <?php if (!$p['is_in_stock']): ?>
                <span class="absolute top-3 left-3 bg-red-600 text-white text-[10px] uppercase tracking-wider px-2 py-1">Out of Stock</span>
              <?php endif; ?>
            </div>
            <p class="text-xs uppercase tracking-widest text-muted font-mono"><?= esc($p['tag_no']) ?></p>
            <h3 class="font-display text-lg md:text-xl mt-1">
              <?= purity_label($p['purity']) ?> ·
              <?= grams($p['net_wt']) ?>
            </h3>
            <p class="text-gold mt-1 font-semibold"><?= money($p['pricing']['list_price'], 0) ?></p>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?= $this->endSection() ?>
