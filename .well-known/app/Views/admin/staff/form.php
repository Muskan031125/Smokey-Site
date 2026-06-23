<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<form action="<?= site_url('admin/staff') ?>" method="post" class="max-w-xl card p-8 space-y-5">
  <?= csrf_field() ?>

  <div>
    <label class="block text-xs uppercase tracking-widest text-muted mb-2">Display Name *</label>
    <input type="text" name="username" required value="<?= esc(old('username')) ?>" class="w-full border border-zinc-300 px-4 py-3 focus:outline-none focus:border-gold"/>
    <p class="text-xs text-muted mt-1">Used for identification in logs and the staff list. Login is always by email.</p>
  </div>
  <div>
    <label class="block text-xs uppercase tracking-widest text-muted mb-2">Email *</label>
    <input type="email" name="email" required value="<?= esc(old('email')) ?>" class="w-full border border-zinc-300 px-4 py-3 focus:outline-none focus:border-gold"/>
  </div>
  <div>
    <label class="block text-xs uppercase tracking-widest text-muted mb-2">Password *</label>
    <input type="text" name="password" required class="w-full border border-zinc-300 px-4 py-3 focus:outline-none focus:border-gold font-mono"/>
    <p class="text-xs text-muted mt-1">Minimum 8 characters. Communicate securely to the user.</p>
  </div>
  <div>
    <label class="block text-xs uppercase tracking-widest text-muted mb-2">Role</label>
    <select name="group" class="w-full border border-zinc-300 px-4 py-3 focus:outline-none focus:border-gold">
      <option value="inventory_manager">Inventory Manager</option>
      <option value="super_admin">Super Admin</option>
      <option value="viewer">Viewer (View Only)</option>
    </select>
  </div>

  <div class="flex gap-3 pt-4">
    <button type="submit" class="bg-ink text-cream text-xs uppercase tracking-widest px-8 py-3 hover:bg-gold transition">Create Internal User</button>
    <a href="<?= site_url('admin/staff') ?>" class="border border-zinc-300 text-xs uppercase tracking-widest px-8 py-3 hover:border-ink transition">Cancel</a>
  </div>
</form>

<?= $this->endSection() ?>
