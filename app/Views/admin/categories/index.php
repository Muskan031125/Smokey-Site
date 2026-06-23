<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex justify-between items-center">
  <p class="text-sm text-muted"><?= count($categories) ?> categories</p>
  <a href="<?= site_url('admin/categories/create') ?>" class="bg-ink text-cream text-xs uppercase tracking-widest px-6 py-3 hover:bg-gold transition">+ New Category</a>
</div>

<div class="card">
  <table class="w-full text-sm">
    <thead class="text-[10px] uppercase tracking-widest text-muted border-b">
      <tr>
        <th class="text-left p-4">Cover</th>
        <th class="text-left p-4">Name</th>
        <th class="text-left p-4">Slug</th>
        <th class="text-center p-4">Products</th>
        <th class="text-center p-4">Order</th>
        <th class="text-center p-4">Status</th>
        <th class="text-right p-4">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($categories as $c): ?>
        <tr class="border-b border-zinc-100 hover:bg-zinc-50">
          <td class="p-4">
            <?php $cov = media_url($c['cover_image'] ?? null); ?>
            <?php if ($cov): ?>
              <img src="<?= esc($cov) ?>" class="w-14 h-14 object-cover border border-zinc-200" alt=""/>
            <?php else: ?>
              <div class="w-14 h-14 bg-zinc-100 border border-zinc-200 flex items-center justify-center text-muted text-xs">—</div>
            <?php endif; ?>
          </td>
          <td class="p-4 font-display text-lg"><?= esc($c['name']) ?></td>
          <td class="p-4 text-muted font-mono text-xs"><?= esc($c['slug']) ?></td>
          <td class="p-4 text-center"><?= (int) ($c['product_count'] ?? 0) ?></td>
          <td class="p-4 text-center text-muted"><?= (int) $c['sort_order'] ?></td>
          <td class="p-4 text-center">
            <?php if ($c['is_active']): ?>
              <span class="bg-green-100 text-green-800 text-[10px] uppercase tracking-widest px-2 py-1">Active</span>
            <?php else: ?>
              <span class="bg-zinc-200 text-zinc-600 text-[10px] uppercase tracking-widest px-2 py-1">Disabled</span>
            <?php endif; ?>
          </td>
          <td class="p-4 text-right">
            <a href="<?= site_url('admin/categories/' . $c['id'] . '/edit') ?>" class="text-xs uppercase tracking-widest hover:text-gold">Edit</a>
            <form action="<?= site_url('admin/categories/' . $c['id'] . '/toggle') ?>" method="post" class="inline ml-3">
              <?= csrf_field() ?>
              <button class="text-xs uppercase tracking-widest hover:text-gold"><?= $c['is_active'] ? 'Disable' : 'Enable' ?></button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
