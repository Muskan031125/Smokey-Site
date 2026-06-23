<?= $this->extend('layouts/portal') ?>
<?= $this->section('content') ?>

<section class="py-10 md:py-24">
  <div class="max-w-7xl mx-auto px-4 md:px-6">
    <div class="text-center mb-8 md:mb-12 reveal">
      <p class="text-base text-gold mb-4" style="font-family:'Crimson Pro',serif; font-style:italic;"><span class="divider mr-3"></span>The Catalog<span class="divider ml-3"></span></p>
      <h1 class="font-display fluid-h1 font-bold">Collections</h1>
      <p class="mt-4 max-w-xl mx-auto" style="color:#1f1f1f;">Choose a collection to browse current stock. Pricing is live.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
      <?php foreach ($categories as $i => $c): ?>
        <?php if (!$c['is_active']) continue; ?>
        <a href="<?= site_url('portal/category/' . $c['slug']) ?>" class="group relative overflow-hidden aspect-[4/5] reveal delay-<?= ($i % 4) + 1 ?>">
          <?php $cover = media_url($c['cover_image'] ?? null); ?>
          <?php if ($cover): ?>
            <img src="<?= esc($cover) ?>" alt="<?= esc($c['name']) ?>" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition duration-700"/>
          <?php else: ?>
            <div class="w-full h-full bg-gradient-to-br from-ink to-zinc-700"></div>
          <?php endif; ?>
          <div class="absolute inset-0 bg-gradient-to-t from-ink/85 via-ink/30 to-transparent group-hover:from-ink/70 transition"></div>
          <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6">
            <p class="fluid-card-title" style="font-family:'Crimson Pro',serif; font-style:italic; font-weight:600; color:#ffffff; text-shadow:0 1px 4px rgba(0,0,0,.5);"><?= esc($c['name']) ?></p>
            <p style="font-family:'Crimson Pro',serif; font-style:italic; font-size:0.95rem; color:#ffffff; margin-top:4px; text-shadow:0 1px 3px rgba(0,0,0,.5);"><?= (int) ($c['product_count'] ?? 0) ?> pieces</p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
