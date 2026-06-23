<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php $isEdit = !empty($category); ?>
<form action="<?= $isEdit ? site_url('admin/categories/' . $category['id']) : site_url('admin/categories') ?>" method="post" enctype="multipart/form-data" class="max-w-3xl card p-8 space-y-6">
  <?= csrf_field() ?>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Left: text fields -->
    <div class="space-y-5">
      <div>
        <label class="block text-xs uppercase tracking-widest text-muted mb-2">Name *</label>
        <input type="text" name="name" required value="<?= esc(old('name', $category['name'] ?? '')) ?>" class="w-full border border-zinc-300 px-4 py-3 focus:outline-none focus:border-gold"/>
      </div>
      <div>
        <label class="block text-xs uppercase tracking-widest text-muted mb-2">Slug</label>
        <input type="text" name="slug" value="<?= esc(old('slug', $category['slug'] ?? '')) ?>" class="w-full border border-zinc-300 px-4 py-3 focus:outline-none focus:border-gold font-mono text-sm" placeholder="auto-generated if left blank"/>
      </div>
      <div>
        <label class="block text-xs uppercase tracking-widest text-muted mb-2">Description</label>
        <textarea name="description" rows="4" class="w-full border border-zinc-300 px-4 py-3 focus:outline-none focus:border-gold"><?= esc(old('description', $category['description'] ?? '')) ?></textarea>
      </div>
      <div class="w-40">
        <label class="block text-xs uppercase tracking-widest text-muted mb-2">Sort Order</label>
        <input type="number" name="sort_order" value="<?= esc(old('sort_order', $category['sort_order'] ?? 0)) ?>" class="w-full border border-zinc-300 px-4 py-3 focus:outline-none focus:border-gold"/>
      </div>
    </div>

    <!-- Right: cover image -->
    <div class="space-y-4">
      <label class="block text-xs uppercase tracking-widest text-muted">Cover Image</label>

      <!-- Current preview -->
      <div class="bg-zinc-100 aspect-[4/5] relative overflow-hidden border border-zinc-200" id="cover-preview">
        <?php $cover = media_url($category['cover_image'] ?? null); ?>
        <?php if ($cover): ?>
          <img src="<?= esc($cover) ?>" class="w-full h-full object-cover" id="cover-img" alt=""/>
        <?php else: ?>
          <div class="w-full h-full flex flex-col items-center justify-center text-muted">
            <svg width="42" height="42" fill="none" stroke="currentColor" stroke-width="1.3" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
            <p class="text-xs uppercase tracking-widest mt-3">No cover</p>
          </div>
        <?php endif; ?>
      </div>

      <!-- Upload file -->
      <div>
        <label for="coverFile" class="block w-full cursor-pointer border-2 border-dashed border-zinc-300 hover:border-gold hover:bg-gold/5 transition py-4 text-center text-xs uppercase tracking-widest text-muted">
          <span id="coverFileLabel">Click or drop an image to upload</span>
        </label>
        <input type="file" id="coverFile" name="cover_image" accept="image/*" class="hidden"/>
      </div>

      <!-- Or external URL -->
      <div>
        <label class="block text-[10px] uppercase tracking-widest text-muted mb-2">Or paste an image URL</label>
        <input type="url" name="cover_image_url"
               value="<?= esc(old('cover_image_url', (!empty($category['cover_image']) && (str_starts_with($category['cover_image'], 'http://') || str_starts_with($category['cover_image'], 'https://'))) ? $category['cover_image'] : '')) ?>"
               placeholder="https://..."
               class="w-full border border-zinc-300 px-3 py-2 text-xs focus:outline-none focus:border-gold"/>
      </div>

      <?php if ($isEdit && !empty($category['cover_image'])): ?>
        <label class="flex items-center gap-2 text-xs text-red-600 cursor-pointer">
          <input type="checkbox" name="remove_cover" value="1" class="accent-red-600"/>
          Remove current cover
        </label>
      <?php endif; ?>
    </div>
  </div>

  <div class="flex gap-3 pt-4 border-t border-zinc-100">
    <button type="submit" class="bg-ink text-cream text-xs uppercase tracking-widest px-8 py-3 hover:bg-gold transition"><?= $isEdit ? 'Update Category' : 'Create Category' ?></button>
    <a href="<?= site_url('admin/categories') ?>" class="border border-zinc-300 text-xs uppercase tracking-widest px-8 py-3 hover:border-ink transition">Cancel</a>
  </div>
</form>

<script>
(function () {
  const input = document.getElementById('coverFile');
  const label = document.getElementById('coverFileLabel');
  const preview = document.getElementById('cover-preview');

  function showLocalPreview(file) {
    if (!file || !file.type.startsWith('image/')) return;
    const url = URL.createObjectURL(file);
    preview.innerHTML = '<img src="' + url + '" class="w-full h-full object-cover" alt=""/>';
    label.textContent = file.name + ' — ready to save';
  }

  input.addEventListener('change', (e) => {
    const f = e.target.files[0];
    if (f) showLocalPreview(f);
  });

  // Drag-drop onto the label
  const dropZone = label.parentElement;
  ['dragenter','dragover'].forEach(evt => {
    dropZone.addEventListener(evt, (e) => { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('border-gold','bg-gold/10'); });
  });
  ['dragleave','drop'].forEach(evt => {
    dropZone.addEventListener(evt, (e) => { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('border-gold','bg-gold/10'); });
  });
  dropZone.addEventListener('drop', (e) => {
    const f = e.dataTransfer.files[0];
    if (!f || !f.type.startsWith('image/')) return;
    const dt = new DataTransfer();
    dt.items.add(f);
    input.files = dt.files;
    showLocalPreview(f);
  });
})();
</script>

<?= $this->endSection() ?>
