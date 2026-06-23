<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php if (session()->has('error')): ?>
  <div id="flash-error" class="mb-4 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 text-sm rounded">
    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span class="flex-1"><?= esc(session('error')) ?></span>
    <button onclick="document.getElementById('flash-error').remove()" class="text-red-400 hover:text-red-700 font-bold text-lg leading-none ml-2">&times;</button>
  </div>
<?php endif; ?>
<?php if (session()->has('success')): ?>
  <div id="flash-success" class="mb-4 flex items-start gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 text-sm rounded">
    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span class="flex-1"><?= esc(session('success')) ?></span>
    <button onclick="document.getElementById('flash-success').remove()" class="text-green-400 hover:text-green-700 font-bold text-lg leading-none ml-2">&times;</button>
  </div>
<?php endif; ?>

<div class="mb-5 flex items-center justify-between">
  <div>
    <h1 class="font-display text-xl text-ink">Import Backups</h1>
    <p class="text-sm text-muted mt-1">A snapshot is created automatically before every bulk import. Click Restore to roll back to that point.</p>
  </div>
  <a href="<?= site_url('admin/bulk-import') ?>" class="border border-zinc-300 text-xs uppercase tracking-widest px-6 py-3 hover:border-ink transition">
    ← Back to Import
  </a>
</div>

<?php if (empty($backups)): ?>
  <div class="card p-12 text-center text-muted">
    <svg class="mx-auto mb-4 w-12 h-12 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
    </svg>
    <p class="text-sm">No backups yet.</p>
    <p class="text-xs mt-1">A backup is created automatically before every bulk import.</p>
  </div>
<?php else: ?>
  <div class="card overflow-hidden">
    <table class="w-full text-sm">
      <thead class="text-[10px] uppercase tracking-widest text-muted border-b bg-zinc-50">
        <tr>
          <th class="px-5 py-3 text-left">Backup File</th>
          <th class="px-5 py-3 text-left">Created</th>
          <th class="px-5 py-3 text-right">Size</th>
          <th class="px-5 py-3 text-right">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($backups as $i => $b): ?>
          <tr class="border-b border-zinc-100 hover:bg-zinc-50 transition <?= $i === 0 ? 'bg-amber-50' : '' ?>">
            <td class="px-5 py-3 font-mono text-xs text-ink">
              <?= esc($b['name']) ?>
              <?php if ($i === 0): ?>
                <span class="ml-2 bg-amber-100 text-amber-700 text-[9px] uppercase tracking-widest px-2 py-0.5">Latest</span>
              <?php endif; ?>
            </td>
            <td class="px-5 py-3 text-muted"><?= esc($b['created']) ?></td>
            <td class="px-5 py-3 text-right text-muted"><?= esc($b['size']) ?></td>
            <td class="px-5 py-3 text-right">
              <form method="post" action="<?= site_url('admin/bulk-import/restore') ?>"
                    onsubmit="return confirm('Restore from this backup?\n\nThis will replace all current products with the data from this snapshot.')">
                <?= csrf_field() ?>
                <input type="hidden" name="backup_file" value="<?= esc($b['name']) ?>">
                <button type="submit" class="bg-red-600 text-white text-[10px] uppercase tracking-widest px-4 py-2 hover:bg-red-700 transition">
                  Restore
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <p class="mt-3 text-xs text-muted">
    <strong>Note:</strong> Restoring replaces all products, diamonds and stones with the snapshot data.
  </p>
<?php endif; ?>

<?= $this->endSection() ?>
