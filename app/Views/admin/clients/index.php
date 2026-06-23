<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex justify-between items-center">
  <p class="text-sm text-muted"><?= count($clients) ?> clients</p>
  <a href="<?= site_url('admin/access-requests') ?>" class="text-xs uppercase tracking-widest hover:text-gold">Pending Access Requests →</a>
</div>

<div class="card overflow-x-auto">
  <table class="w-full text-sm">
    <thead class="text-[10px] uppercase tracking-widest text-muted border-b">
      <tr>
        <th class="text-left p-4">Client</th>
        <th class="text-left p-4">Email</th>
        <th class="text-left p-4">Last Seen</th>
        <th class="text-center p-4">Views</th>
        <th class="text-left p-4">Expires</th>
        <th class="text-center p-4">Status</th>
        <th class="text-right p-4">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($clients)): ?>
        <tr><td colspan="7" class="p-8 text-center text-muted">No clients yet. Approve access requests to create clients.</td></tr>
      <?php else: foreach ($clients as $c): ?>
        <tr class="border-b border-zinc-100 hover:bg-zinc-50 <?= $c['is_expired'] ? 'bg-red-50' : '' ?>">
          <td class="p-4">
            <a href="<?= site_url('admin/clients/' . $c['id']) ?>" class="font-display text-lg hover:text-gold"><?= esc($c['username']) ?></a>
            <?php if ($c['must_change']): ?>
              <span class="ml-2 text-[9px] uppercase tracking-widest text-gold">Pw Reset Pending</span>
            <?php endif; ?>
          </td>
          <td class="p-4"><?= esc($c['email']) ?></td>
          <td class="p-4 text-muted text-xs"><?= $c['last_active'] ? app_datetime($c['last_active']) : '—' ?></td>
          <td class="p-4 text-center"><?= (int) $c['views_total'] ?></td>
          <td class="p-4 text-xs">
            <?php if ($c['expires_at']): ?>
              <?php if ($c['is_expired']): ?>
                <span class="text-red-700 font-semibold">Expired <?= app_date($c['expires_at']) ?></span>
              <?php else: ?>
                <?= app_date($c['expires_at']) ?>
              <?php endif; ?>
            <?php else: ?>
              <span class="text-muted">—</span>
            <?php endif; ?>
          </td>
          <td class="p-4 text-center">
            <?php if ($c['is_expired']): ?>
              <span class="bg-red-100 text-red-800 text-[10px] uppercase tracking-widest px-2 py-1">Expired</span>
            <?php elseif ($c['active']): ?>
              <span class="bg-green-100 text-green-800 text-[10px] uppercase tracking-widest px-2 py-1">Active</span>
            <?php else: ?>
              <span class="bg-zinc-200 text-zinc-600 text-[10px] uppercase tracking-widest px-2 py-1">Disabled</span>
            <?php endif; ?>
          </td>
          <td class="p-4 text-right whitespace-nowrap">
            <a href="<?= site_url('admin/clients/' . $c['id']) ?>" class="text-xs uppercase tracking-widest hover:text-gold">View</a>
            <form action="<?= site_url('admin/clients/' . $c['id'] . '/reset-password') ?>" method="post" class="inline ml-3" onsubmit="return confirm('Generate a new temporary password for this client?');">
              <?= csrf_field() ?>
              <button class="text-xs uppercase tracking-widest hover:text-gold">Reset PW</button>
            </form>
            <form action="<?= site_url('admin/clients/' . $c['id'] . '/toggle') ?>" method="post" class="inline ml-3">
              <?= csrf_field() ?>
              <button class="text-xs uppercase tracking-widest hover:text-gold"><?= $c['active'] ? 'Disable' : 'Enable' ?></button>
            </form>
          </td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
