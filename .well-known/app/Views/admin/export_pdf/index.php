<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<form action="<?= site_url('admin/export-pdf/generate') ?>" method="post">
  <?= csrf_field() ?>

  <div class="card p-8 space-y-6">
    <h2 class="font-display text-xl">Export Options</h2>

    <!-- Category selection -->
    <div>
      <label class="block text-xs uppercase tracking-widest text-muted mb-3">Categories</label>
      <p class="text-xs text-muted mb-3">Leave all unchecked to export every category.</p>
      <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
        <?php foreach ($categories as $cat): ?>
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="category_ids[]" value="<?= $cat['id'] ?>" class="accent-gold"/>
            <span class="text-sm"><?= esc($cat['name']) ?></span>
          </label>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Layout -->
    <div>
      <label class="block text-xs uppercase tracking-widest text-muted mb-3">Layout</label>
      <div class="flex gap-6">
        <label class="flex items-center gap-2 cursor-pointer">
          <input type="radio" name="layout" value="2" checked class="accent-gold"/>
          <span class="text-sm">2 products per page</span>
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
          <input type="radio" name="layout" value="1" class="accent-gold"/>
          <span class="text-sm">1 product per page</span>
        </label>
      </div>
    </div>

    <!-- Stock filter -->
    <div>
      <label class="block text-xs uppercase tracking-widest text-muted mb-3">Stock Filter</label>
      <div class="flex gap-6">
        <label class="flex items-center gap-2 cursor-pointer">
          <input type="radio" name="stock_filter" value="all" checked class="accent-gold"/>
          <span class="text-sm">All items</span>
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
          <input type="radio" name="stock_filter" value="in_stock" class="accent-gold"/>
          <span class="text-sm">In Stock only</span>
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
          <input type="radio" name="stock_filter" value="out_of_stock" class="accent-gold"/>
          <span class="text-sm">Out of Stock only</span>
        </label>
      </div>
    </div>

    <div class="flex gap-3 pt-2">
      <button type="submit" class="bg-ink text-cream text-xs uppercase tracking-widest px-10 py-4 hover:bg-gold transition">
        Generate &amp; Download PDF
      </button>
      <a href="<?= site_url('admin/products') ?>" class="border border-zinc-300 text-xs uppercase tracking-widest px-10 py-4 hover:border-ink transition">Cancel</a>
    </div>
  </div>

</form>

<?= $this->endSection() ?>
