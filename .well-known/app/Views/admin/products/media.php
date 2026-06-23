<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
  // Helper: detect Vimeo URL and extract the numeric ID
  function vimeo_embed_id(string $path): ?string {
      if (preg_match('~vimeo\.com/(?:video/|channels/[^/]+/|groups/[^/]+/videos/)?(\d+)~i', $path, $m)) {
          return $m[1];
      }
      return null;
  }
  function is_external_url(string $path): bool {
      return str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
  }
?>

<div class="mb-6 flex gap-3">
  <a href="<?= site_url('admin/products/' . $product['id'] . '/edit') ?>" class="border border-zinc-300 text-xs uppercase tracking-widest px-5 py-2 hover:border-ink transition">← Back to SKU</a>
</div>

<!-- ============ ADD VIMEO VIDEO ============ -->
<form action="<?= site_url('admin/products/' . $product['id'] . '/media/vimeo') ?>" method="post" class="card p-6 mb-6">
  <?= csrf_field() ?>
  <h2 class="font-display text-xl mb-3">Add Vimeo Video</h2>
  <p class="text-xs text-muted mb-3">Paste a Vimeo URL (e.g. <span class="font-mono">https://vimeo.com/123456789</span>). The video will embed on the client portal.</p>
  <div class="flex gap-3">
    <input type="url" name="vimeo_url" required placeholder="https://vimeo.com/123456789"
           class="flex-1 border border-zinc-300 px-4 py-2 text-sm font-mono focus:outline-none focus:border-gold"/>
    <button type="submit" class="bg-ink text-cream text-xs uppercase tracking-widest px-6 py-2 hover:bg-gold transition">Add Vimeo</button>
  </div>
</form>

<!-- ============ UPLOAD ZONE ============ -->
<form id="uploadForm"
      action="<?= site_url('admin/products/' . $product['id'] . '/media') ?>"
      method="post" enctype="multipart/form-data"
      class="card p-8 mb-6">
  <?= csrf_field() ?>

  <h2 class="font-display text-xl mb-4">Upload Images &amp; Videos</h2>

  <!-- Drop zone -->
  <label for="fileInput" id="dropZone"
         class="block border-2 border-dashed border-zinc-300 hover:border-gold hover:bg-gold/5 transition cursor-pointer rounded-sm p-10 text-center">
    <svg class="mx-auto mb-4 text-gold" width="44" height="44" fill="none" stroke="currentColor" stroke-width="1.3" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
    <p class="font-display text-2xl mb-1">Drop files here</p>
    <p class="text-sm text-muted">or <span class="text-gold underline">click to browse</span></p>
    <p class="text-xs text-muted mt-3">JPG · PNG · WebP · MP4 — multi-select supported, up to 20 files at once</p>
    <input type="file" id="fileInput" name="files[]" multiple accept="image/*,video/*" class="hidden"/>
  </label>

  <!-- Preview grid (populated via JS) -->
  <div id="previewGrid" class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-5 hidden"></div>

  <div class="flex justify-between items-center mt-5" id="uploadActions" style="display:none;">
    <p class="text-sm text-muted" id="uploadSummary"></p>
    <div class="flex gap-3">
      <button type="button" id="clearBtn" class="border border-zinc-300 text-xs uppercase tracking-widest px-5 py-2 hover:border-ink transition">Clear</button>
      <button type="submit" id="uploadBtn" class="bg-ink text-cream text-xs uppercase tracking-widest px-6 py-2 hover:bg-gold transition">Upload Selected</button>
    </div>
  </div>
</form>

<!-- ============ EXISTING MEDIA (sortable) ============ -->
<div class="card p-6">
  <div class="flex justify-between items-center mb-4">
    <h2 class="font-display text-xl">Current Media <span class="text-muted text-sm">(<?= count($media) ?>)</span></h2>
    <?php if (!empty($media)): ?>
      <p class="text-xs text-muted">Drag tiles to reorder · First tile is the cover on the portal</p>
    <?php endif; ?>
  </div>

  <?php if (empty($media)): ?>
    <div class="p-12 text-center text-muted">No media yet. Upload some files above.</div>
  <?php else: ?>
    <div id="mediaGrid" class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <?php foreach ($media as $m): ?>
        <div class="media-tile bg-white border border-zinc-200 cursor-move" data-id="<?= (int) $m['id'] ?>">
          <div class="aspect-square bg-zinc-100 relative">
            <?php if ($m['type'] === 'video'): ?>
              <?php $vimeoId = vimeo_embed_id($m['path']); ?>
              <?php if ($vimeoId): ?>
                <div class="w-full h-full flex items-center justify-center bg-ink text-cream">
                  <div class="text-center">
                    <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24" class="mx-auto text-gold"><path d="M23.977 6.416c-.105 2.338-1.739 5.543-4.894 9.609-3.268 4.247-6.026 6.37-8.29 6.37-1.409 0-2.578-1.294-3.553-3.881L5.322 11.4C4.603 8.816 3.834 7.522 3.01 7.522c-.179 0-.806.378-1.881 1.132L0 7.197c1.185-1.044 2.351-2.084 3.501-3.128C5.08 2.701 6.266 1.984 7.055 1.91c1.867-.18 3.016 1.1 3.447 3.838.465 2.953.789 4.789.97 5.507.539 2.45 1.131 3.674 1.776 3.674.502 0 1.256-.796 2.265-2.385 1.004-1.589 1.54-2.797 1.612-3.628.144-1.371-.395-2.061-1.614-2.061-.574 0-1.167.121-1.777.391 1.186-3.868 3.434-5.757 6.762-5.637 2.473.06 3.628 1.664 3.493 4.797z"/></svg>
                    <p class="mt-2 text-[10px] uppercase tracking-widest">Vimeo Video</p>
                    <p class="text-[10px] text-cream/60 font-mono">#<?= esc($vimeoId) ?></p>
                  </div>
                </div>
                <span class="absolute top-2 left-2 bg-gold text-white text-[10px] uppercase px-2 py-1">Vimeo</span>
              <?php elseif (is_external_url($m['path'])): ?>
                <video src="<?= esc($m['path']) ?>" class="w-full h-full object-cover" muted></video>
                <span class="absolute top-2 left-2 bg-black/60 text-white text-[10px] uppercase px-2 py-1">Video</span>
              <?php else: ?>
                <video src="<?= base_url($m['path']) ?>" class="w-full h-full object-cover" muted></video>
                <span class="absolute top-2 left-2 bg-black/60 text-white text-[10px] uppercase px-2 py-1">Video</span>
              <?php endif; ?>
            <?php else: ?>
              <img src="<?= is_external_url($m['path']) ? esc($m['path']) : base_url($m['path']) ?>" class="w-full h-full object-cover" alt="" draggable="false"/>
            <?php endif; ?>
            <?php if ($m['is_cover']): ?>
              <span class="absolute top-2 right-2 bg-gold text-white text-[10px] uppercase tracking-widest px-2 py-1">Cover</span>
            <?php endif; ?>
            <div class="absolute bottom-2 left-2 bg-ink/70 text-cream text-[10px] uppercase tracking-widest px-2 py-1 pointer-events-none">
              <span class="position-badge">—</span>
            </div>
          </div>
          <div class="p-3 flex gap-2 justify-between text-xs">
            <?php if (!$m['is_cover'] && $m['type'] === 'image'): ?>
              <form action="<?= site_url('admin/products/' . $product['id'] . '/media/' . $m['id'] . '/cover') ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="uppercase tracking-widest hover:text-gold">Set Cover</button>
              </form>
            <?php else: ?>
              <span></span>
            <?php endif; ?>
            <form action="<?= site_url('admin/products/' . $product['id'] . '/media/' . $m['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Delete this file?');">
              <?= csrf_field() ?>
              <button type="submit" class="uppercase tracking-widest hover:text-red-600">Delete</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <p id="reorderStatus" class="text-xs text-muted mt-3"></p>
  <?php endif; ?>
</div>

<script>
(function () {
  const MAX_FILES   = 20;
  const MAX_BYTES   = 25 * 1024 * 1024; // 25 MB per file
  const CSRF_NAME   = '<?= csrf_token() ?>';
  const CSRF_HASH   = '<?= csrf_hash() ?>';
  const PRODUCT_ID  = <?= (int) $product['id'] ?>;
  const REORDER_URL = '<?= site_url('admin/products/' . $product['id'] . '/media/reorder') ?>';

  // ---------- Upload: preview + drag-drop ----------
  const dropZone   = document.getElementById('dropZone');
  const fileInput  = document.getElementById('fileInput');
  const grid       = document.getElementById('previewGrid');
  const actions    = document.getElementById('uploadActions');
  const summary    = document.getElementById('uploadSummary');
  const clearBtn   = document.getElementById('clearBtn');
  const uploadForm = document.getElementById('uploadForm');

  // Use a DataTransfer to keep the selection in sync with the input
  let dt = new DataTransfer();

  function humanSize(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024*1024) return (bytes/1024).toFixed(1) + ' KB';
    return (bytes/1024/1024).toFixed(1) + ' MB';
  }

  function render() {
    grid.innerHTML = '';
    if (dt.files.length === 0) {
      grid.classList.add('hidden');
      actions.style.display = 'none';
      return;
    }
    grid.classList.remove('hidden');
    actions.style.display = 'flex';

    let total = 0;
    Array.from(dt.files).forEach((file, idx) => {
      total += file.size;
      const isVideo = file.type.startsWith('video/');
      const url = URL.createObjectURL(file);

      const tile = document.createElement('div');
      tile.className = 'relative group bg-zinc-100 aspect-square overflow-hidden';
      tile.innerHTML = `
        ${isVideo
          ? `<video src="${url}" class="w-full h-full object-cover" muted></video>
             <span class="absolute top-2 left-2 bg-black/60 text-white text-[10px] uppercase px-2 py-1">Video</span>`
          : `<img src="${url}" class="w-full h-full object-cover" alt=""/>`
        }
        <button type="button" class="absolute top-2 right-2 bg-red-600/90 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs hover:bg-red-700" data-remove="${idx}">×</button>
        <div class="absolute bottom-0 left-0 right-0 bg-ink/70 text-cream text-[10px] uppercase tracking-widest px-2 py-1 truncate">${file.name}</div>
      `;
      grid.appendChild(tile);
    });

    summary.textContent = dt.files.length + ' file' + (dt.files.length === 1 ? '' : 's') + ' selected · ' + humanSize(total);
  }

  function addFiles(fileList) {
    const incoming = Array.from(fileList);
    for (const f of incoming) {
      if (dt.files.length >= MAX_FILES) {
        alert('Maximum ' + MAX_FILES + ' files at a time.');
        break;
      }
      if (f.size > MAX_BYTES) {
        alert('"' + f.name + '" is larger than 25 MB and was skipped.');
        continue;
      }
      if (!f.type.startsWith('image/') && !f.type.startsWith('video/')) {
        alert('"' + f.name + '" is not an image or video and was skipped.');
        continue;
      }
      dt.items.add(f);
    }
    fileInput.files = dt.files;
    render();
  }

  // Input change
  fileInput.addEventListener('change', (e) => {
    const files = fileInput.files;
    // Reset and re-add so we can apply limits/dedupe
    dt = new DataTransfer();
    addFiles(files);
  });

  // Drag-drop onto the label
  ['dragenter','dragover'].forEach(evt => {
    dropZone.addEventListener(evt, (e) => { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('border-gold','bg-gold/10'); });
  });
  ['dragleave','drop'].forEach(evt => {
    dropZone.addEventListener(evt, (e) => { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('border-gold','bg-gold/10'); });
  });
  dropZone.addEventListener('drop', (e) => {
    addFiles(e.dataTransfer.files);
  });

  // Remove individual preview
  grid.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-remove]');
    if (!btn) return;
    const idx = parseInt(btn.dataset.remove, 10);
    const next = new DataTransfer();
    Array.from(dt.files).forEach((f, i) => { if (i !== idx) next.items.add(f); });
    dt = next;
    fileInput.files = dt.files;
    render();
  });

  // Clear all
  clearBtn.addEventListener('click', () => {
    dt = new DataTransfer();
    fileInput.files = dt.files;
    render();
  });

  // Upload with fetch so we can show progress-ish feedback
  uploadForm.addEventListener('submit', (e) => {
    if (dt.files.length === 0) { e.preventDefault(); return; }
    document.getElementById('uploadBtn').disabled = true;
    document.getElementById('uploadBtn').textContent = 'Uploading…';
  });

  // ---------- Existing media: drag-to-reorder ----------
  const mediaGrid = document.getElementById('mediaGrid');
  const reorderStatus = document.getElementById('reorderStatus');

  if (mediaGrid) {
    let dragged = null;

    function updatePositionBadges() {
      mediaGrid.querySelectorAll('.media-tile').forEach((tile, i) => {
        const badge = tile.querySelector('.position-badge');
        if (badge) badge.textContent = '#' + (i + 1);
      });
    }
    updatePositionBadges();

    mediaGrid.querySelectorAll('.media-tile').forEach(tile => {
      tile.setAttribute('draggable', 'true');

      tile.addEventListener('dragstart', (e) => {
        dragged = tile;
        tile.classList.add('opacity-40');
        e.dataTransfer.effectAllowed = 'move';
      });
      tile.addEventListener('dragend', () => {
        tile.classList.remove('opacity-40');
        dragged = null;
      });
      tile.addEventListener('dragover', (e) => {
        e.preventDefault();
        if (!dragged || dragged === tile) return;
        const rect = tile.getBoundingClientRect();
        const midX = rect.left + rect.width / 2;
        if (e.clientX < midX) {
          tile.parentNode.insertBefore(dragged, tile);
        } else {
          tile.parentNode.insertBefore(dragged, tile.nextSibling);
        }
      });
      tile.addEventListener('drop', async (e) => {
        e.preventDefault();
        updatePositionBadges();
        await saveOrder();
      });
    });

    async function saveOrder() {
      const ids = Array.from(mediaGrid.querySelectorAll('.media-tile')).map(t => t.dataset.id);
      reorderStatus.textContent = 'Saving order…';
      try {
        const res = await fetch(REORDER_URL, {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': CSRF_HASH,
          },
          body: JSON.stringify({ order: ids, [CSRF_NAME]: CSRF_HASH }),
        });
        const data = await res.json();
        if (data.ok) {
          reorderStatus.textContent = 'Order saved ✓';
          setTimeout(() => reorderStatus.textContent = '', 1500);
        } else {
          reorderStatus.textContent = 'Failed to save order: ' + (data.error || 'unknown');
        }
      } catch (err) {
        reorderStatus.textContent = 'Failed to save order (network error)';
      }
    }
  }
})();
</script>

<?= $this->endSection() ?>
