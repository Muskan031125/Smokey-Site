<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
/**
 * Helper closures for rendering the various field types
 */
$getVal = function (string $key) use ($settings) {
    return $settings[$key]['value'] ?? '';
};

$textField = function (string $key, string $label, string $placeholder = '') use ($getVal) {
?>
  <div>
    <label class="block text-[10px] uppercase tracking-widest text-muted mb-1"><?= esc($label) ?></label>
    <input type="text" name="setting[<?= esc($key) ?>]" value="<?= esc($getVal($key)) ?>" placeholder="<?= esc($placeholder) ?>" class="w-full border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-gold"/>
  </div>
<?php
};

$textareaField = function (string $key, string $label, int $rows = 3) use ($getVal) {
?>
  <div>
    <label class="block text-[10px] uppercase tracking-widest text-muted mb-1"><?= esc($label) ?></label>
    <textarea name="setting[<?= esc($key) ?>]" rows="<?= $rows ?>" class="w-full border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-gold"><?= esc($getVal($key)) ?></textarea>
  </div>
<?php
};

$imageField = function (string $key, string $label) use ($getVal) {
    $val = $getVal($key);
    $preview = media_url($val);
?>
  <div class="bg-zinc-50 border border-zinc-200 p-4">
    <label class="block text-[10px] uppercase tracking-widest text-muted mb-3"><?= esc($label) ?></label>

    <div class="bg-white aspect-[16/9] mb-3 border border-zinc-200 overflow-hidden relative" data-preview-for="<?= esc($key) ?>">
      <?php if ($preview): ?>
        <img src="<?= esc($preview) ?>" class="w-full h-full object-cover" alt=""/>
      <?php else: ?>
        <div class="w-full h-full flex items-center justify-center text-muted text-xs uppercase tracking-widest">No image</div>
      <?php endif; ?>
    </div>

    <!-- Upload -->
    <label class="block cursor-pointer border-2 border-dashed border-zinc-300 hover:border-gold hover:bg-gold/5 transition py-3 text-center text-[10px] uppercase tracking-widest text-muted mb-2">
      Click to upload a new image
      <input type="file" name="upload[<?= esc($key) ?>]" accept="image/*" class="hidden" data-image-input="<?= esc($key) ?>"/>
    </label>

    <!-- Or URL -->
    <label class="block text-[10px] uppercase tracking-widest text-muted mb-1">Or use an image URL</label>
    <input type="url" name="setting[<?= esc($key) ?>]" value="<?= esc($val) ?>" placeholder="https://..." class="w-full border border-zinc-300 px-3 py-2 text-xs focus:outline-none focus:border-gold"/>
  </div>
<?php
};
?>

<form action="<?= site_url('admin/home-page') ?>" method="post" enctype="multipart/form-data" class="space-y-6">
  <?= csrf_field() ?>

  <div class="card p-4 bg-gold/5 border-l-4 border-gold">
    <p class="text-sm">
      <strong>Live preview:</strong>
      <a href="<?= site_url('/') ?>" target="_blank" class="text-gold hover:underline">open the home page in a new tab →</a>
      Changes apply on save.
    </p>
  </div>

  <!-- ========== HERO ========== -->
  <div class="card p-8">
    <h2 class="font-display text-2xl mb-6">Hero Section</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div><?php $imageField('home.hero_image', 'Hero Background Image'); ?></div>
      <div class="space-y-4">
        <?php $textField('home.hero_eyebrow', 'Eyebrow text (small, above headline)'); ?>
        <?php $textField('home.hero_headline', 'Headline — first line'); ?>
        <?php $textField('home.hero_accent', 'Headline — italic accent (gold)'); ?>
        <?php $textField('home.hero_headline2', 'Headline — second line'); ?>
        <?php $textareaField('home.hero_subtext', 'Subtext paragraph', 3); ?>
        <div class="grid grid-cols-2 gap-3">
          <?php $textField('home.hero_primary_cta', 'Primary CTA label'); ?>
          <?php $textField('home.hero_secondary_cta', 'Secondary CTA label'); ?>
        </div>
      </div>
    </div>
  </div>

  <!-- ========== VALUES ========== -->
  <div class="card p-8">
    <h2 class="font-display text-2xl mb-6">Values Strip (4 cards)</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      <?php for ($i = 1; $i <= 4; $i++): ?>
        <div class="bg-zinc-50 border border-zinc-200 p-4 space-y-3">
          <p class="text-[10px] uppercase tracking-widest text-gold">Value <?= $i ?></p>
          <?php $textField("home.value{$i}_title", 'Title'); ?>
          <?php $textField("home.value{$i}_subtitle", 'Subtitle'); ?>
        </div>
      <?php endfor; ?>
    </div>
  </div>

  <!-- ========== COLLECTIONS ========== -->
  <div class="card p-8">
    <h2 class="font-display text-2xl mb-6">Collections Intro</h2>
    <div class="space-y-4">
      <?php $textField('home.collections_eyebrow', 'Eyebrow text'); ?>
      <?php $textField('home.collections_title', 'Section title'); ?>
      <?php $textareaField('home.collections_subtext', 'Subtitle paragraph', 2); ?>
    </div>
    <p class="text-xs text-muted mt-4">The collection tiles pull their images from the <a href="<?= site_url('admin/categories') ?>" class="text-gold hover:underline">Categories page</a>.</p>
  </div>

  <!-- ========== QUOTE ========== -->
  <div class="card p-8">
    <h2 class="font-display text-2xl mb-6">Quote Banner</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div><?php $imageField('home.quote_image', 'Quote background image'); ?></div>
      <div class="space-y-4">
        <?php $textareaField('home.quote_text', 'Quote text', 4); ?>
        <?php $textField('home.quote_author', 'Attribution'); ?>
      </div>
    </div>
  </div>

  <!-- ========== CRAFT ========== -->
  <div class="card p-8">
    <h2 class="font-display text-2xl mb-6">Our Craft Section</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="space-y-4">
        <?php $imageField('home.craft_image', 'Background image'); ?>
        <div class="grid grid-cols-2 gap-3">
          <?php $imageField('home.craft_side1', 'Side image 1 (floating left)'); ?>
          <?php $imageField('home.craft_side2', 'Side image 2 (floating right)'); ?>
        </div>
      </div>
      <div class="space-y-4">
        <?php $textField('home.craft_eyebrow', 'Eyebrow'); ?>
        <?php $textField('home.craft_title', 'Title — line 1'); ?>
        <?php $textField('home.craft_accent', 'Title — italic line 2'); ?>
        <?php $textareaField('home.craft_text', 'Body paragraph', 4); ?>
      </div>
    </div>
  </div>

  <!-- ========== STATS ========== -->
  <div class="card p-8">
    <h2 class="font-display text-2xl mb-6">Stats Strip</h2>
    <?php $imageField('home.stats_image', 'Background image'); ?>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
      <?php for ($i = 1; $i <= 4; $i++): ?>
        <div class="bg-zinc-50 border border-zinc-200 p-4 space-y-3">
          <p class="text-[10px] uppercase tracking-widest text-gold">Stat <?= $i ?></p>
          <?php $textField("home.stat{$i}_value", 'Number'); ?>
          <?php $textField("home.stat{$i}_label", 'Label'); ?>
        </div>
      <?php endfor; ?>
    </div>
  </div>

  <!-- ========== CTA ========== -->
  <div class="card p-8">
    <h2 class="font-display text-2xl mb-6">Footer CTA</h2>
    <div class="space-y-4 max-w-2xl">
      <?php $textField('home.cta_eyebrow', 'Eyebrow'); ?>
      <?php $textField('home.cta_title', 'Title'); ?>
      <?php $textareaField('home.cta_text', 'Body text', 2); ?>
    </div>
  </div>

  <div class="flex gap-3 sticky bottom-0 bg-zinc-100 p-4 -mx-8 -mb-8 border-t border-zinc-300 z-10">
    <button type="submit" class="bg-ink text-cream text-xs uppercase tracking-widest px-10 py-3 hover:bg-gold transition">Save Home Page</button>
    <a href="<?= site_url('/') ?>" target="_blank" class="border border-zinc-300 text-xs uppercase tracking-widest px-10 py-3 hover:border-ink transition">Preview →</a>
  </div>
</form>

<script>
// Live preview when uploading an image for a given key
document.querySelectorAll('[data-image-input]').forEach(input => {
  input.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file || !file.type.startsWith('image/')) return;
    const key = input.dataset.imageInput;
    const preview = document.querySelector('[data-preview-for="' + CSS.escape(key) + '"]');
    if (!preview) return;
    const url = URL.createObjectURL(file);
    preview.innerHTML = '<img src="' + url + '" class="w-full h-full object-cover" alt=""/>';
  });
});
</script>

<?= $this->endSection() ?>
