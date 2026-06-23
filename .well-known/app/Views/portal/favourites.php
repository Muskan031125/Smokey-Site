<?= $this->extend('layouts/portal') ?>
<?= $this->section('content') ?>

<section class="py-10 md:py-24">
  <div class="max-w-7xl mx-auto px-4 md:px-6">
    <div class="mb-8">
      <a href="<?= site_url('portal') ?>" class="hover:text-gold" style="font-family:'Crimson Pro',serif; font-style:italic; font-size:1rem; color:#1f1f1f;">← All Collections</a>
    </div>

    <div class="text-center mb-8 md:mb-12 reveal">
      <p class="text-base text-gold mb-4" style="font-family:'Crimson Pro',serif; font-style:italic;"><span class="divider mr-3"></span>Saved for later<span class="divider ml-3"></span></p>
      <h1 class="font-display fluid-h1 font-bold">My Favourites</h1>
      <p class="mt-4 max-w-xl mx-auto" style="color:#1f1f1f;">
        <?= count($products) ?> piece<?= count($products) === 1 ? '' : 's' ?> saved · Pricing live at gold rate <?= money($goldRate, 0) ?>/g
      </p>
    </div>

    <?php if (empty($products)): ?>
      <div class="max-w-lg mx-auto text-center py-16">
        <svg class="mx-auto mb-6 text-gold/60" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
        <h2 class="font-display fluid-h2 mb-3">No favourites yet</h2>
        <p class="text-muted mb-8">When you find a piece you love, tap the heart on its page and it'll appear here.</p>
        <a href="<?= site_url('portal') ?>" class="inline-block bg-ink hover:bg-gold text-cream px-8 py-4 text-xs uppercase tracking-[0.2em] transition">Browse Collections</a>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        <?php foreach ($products as $i => $p): ?>
          <div class="group relative reveal delay-<?= ($i % 4) + 1 ?>">
            <a href="<?= site_url('portal/product/' . $p['id']) ?>" class="block">
              <div class="relative overflow-hidden bg-white aspect-square mb-3 md:mb-4">
                <?php
                  $coverPath = $p['cover']['path'] ?? null;
                  $isVideoCover = ($p['cover']['type'] ?? null) === 'video';
                  $coverVimeoId = $isVideoCover && preg_match('~vimeo\.com/(?:video/)?(\d+)~i', (string) $coverPath, $vm) ? $vm[1] : null;
                  if ($coverVimeoId) {
                      $src = 'https://vumbnail.com/' . $coverVimeoId . '.jpg';
                  } else {
                      $src = media_url($coverPath) ?: media_url($p['category_cover'] ?? null);
                  }
                ?>
                <?php if ($src): ?>
                  <img src="<?= esc($src) ?>" alt="<?= esc($p['tag_no']) ?>" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-700"/>
                  <?php if ($isVideoCover): ?>
                    <div class="absolute inset-0 flex items-center justify-center">
                      <span class="w-10 h-10 flex items-center justify-center rounded-full bg-black/55 text-white">▶</span>
                    </div>
                  <?php elseif (empty($p['cover'])): ?>
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
              <h3 class="font-display text-lg md:text-xl mt-1"><?= esc($p['category_name']) ?> · <?= purity_label($p['purity']) ?></h3>
              <p class="text-gold mt-1 font-semibold"><?= money($p['pricing']['list_price'], 0) ?></p>
              <p class="text-[10px] uppercase tracking-widest text-muted mt-1">Saved <?= app_date($p['fav_created_at']) ?></p>
            </a>

            <!-- Remove button -->
            <form action="<?= site_url('portal/favourites/toggle/' . $p['id']) ?>" method="post" class="absolute top-3 right-3">
              <?= csrf_field() ?>
              <button type="submit" class="w-9 h-9 rounded-full bg-white/90 backdrop-blur hover:bg-gold hover:text-white flex items-center justify-center transition shadow-sm" title="Remove from favourites">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#006044" stroke="#006044" stroke-width="1.5">
                  <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
              </button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?= $this->endSection() ?>
