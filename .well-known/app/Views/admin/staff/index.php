<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex justify-between items-center">
  <p class="text-sm text-muted"><?= count($users) ?> internal users</p>
  <a href="<?= site_url('admin/staff/create') ?>" class="bg-ink text-cream text-xs uppercase tracking-widest px-6 py-3 hover:bg-gold transition">+ New Internal User</a>
</div>

<div class="card overflow-x-auto">
  <table class="w-full text-sm">
    <thead class="text-[10px] uppercase tracking-widest text-muted border-b">
      <tr>
        <th class="text-left p-4">Display Name</th>
        <th class="text-left p-4">Email</th>
        <th class="text-left p-4">Role</th>
        <th class="text-left p-4">Last Active</th>
        <th class="text-center p-4">Status</th>
        <th class="text-right p-4">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $u): ?>
        <tr class="border-b border-zinc-100 hover:bg-zinc-50">
          <td class="p-4 font-mono text-xs"><?= esc($u['username']) ?></td>
          <td class="p-4"><?= esc($u['email']) ?></td>
          <td class="p-4">
            <form action="<?= site_url('admin/staff/' . $u['id'] . '/group') ?>" method="post" class="flex gap-2">
              <?= csrf_field() ?>
              <select name="group" class="border border-zinc-300 px-2 py-1 text-xs">
                <option value="super_admin" <?= $u['group'] === 'super_admin' ? 'selected' : '' ?>>Super Admin</option>
                <option value="inventory_manager" <?= $u['group'] === 'inventory_manager' ? 'selected' : '' ?>>Inventory Manager</option>
                <option value="viewer" <?= $u['group'] === 'viewer' ? 'selected' : '' ?>>Viewer (View Only)</option>
              </select>
              <button class="text-xs uppercase tracking-widest hover:text-gold">Save</button>
            </form>
          </td>
          <td class="p-4 text-muted text-xs"><?= $u['last_active'] ? app_datetime($u['last_active']) : '—' ?></td>
          <td class="p-4 text-center">
            <?php if ($u['active']): ?>
              <span class="bg-green-100 text-green-800 text-[10px] uppercase tracking-widest px-2 py-1">Active</span>
            <?php else: ?>
              <span class="bg-zinc-200 text-zinc-600 text-[10px] uppercase tracking-widest px-2 py-1">Disabled</span>
            <?php endif; ?>
          </td>
          <td class="p-4 text-right whitespace-nowrap">
            <form action="<?= site_url('admin/staff/' . $u['id'] . '/reset-password') ?>" method="post" class="inline" onsubmit="return confirm('Generate a new temporary password for this user? They will be forced to change it on next login.');">
              <?= csrf_field() ?>
              <button class="text-xs uppercase tracking-widest hover:text-gold">Reset PW</button>
            </form>
            <form action="<?= site_url('admin/staff/' . $u['id'] . '/toggle') ?>" method="post" class="inline ml-3">
              <?= csrf_field() ?>
              <button class="text-xs uppercase tracking-widest hover:text-gold"><?= $u['active'] ? 'Disable' : 'Enable' ?></button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
