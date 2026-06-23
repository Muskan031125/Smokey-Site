<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="mb-6">
  <a href="<?= site_url('admin/clients') ?>" class="text-xs uppercase tracking-widest text-muted hover:text-gold">← Back to clients</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

  <!-- Left: profile + controls -->
  <div class="lg:col-span-1 space-y-6">

    <!-- Profile card -->
    <div class="card p-6">
      <h2 class="font-display text-xl mb-4">Profile</h2>
      <dl class="space-y-3 text-sm">
        <div>
          <dt class="text-[10px] uppercase tracking-widest text-muted">Username</dt>
          <dd class="font-mono"><?= esc($user['username']) ?></dd>
        </div>
        <div>
          <dt class="text-[10px] uppercase tracking-widest text-muted">Email</dt>
          <dd><a href="mailto:<?= esc($user['email']) ?>" class="hover:text-gold"><?= esc($user['email']) ?></a></dd>
        </div>
        <div>
          <dt class="text-[10px] uppercase tracking-widest text-muted">Joined</dt>
          <dd><?= app_datetime($user['created_at']) ?></dd>
        </div>
        <div>
          <dt class="text-[10px] uppercase tracking-widest text-muted">Last active</dt>
          <dd><?= $user['last_active'] ? app_datetime($user['last_active']) : '—' ?></dd>
        </div>
        <div>
          <dt class="text-[10px] uppercase tracking-widest text-muted">Status</dt>
          <dd>
            <?php if ($user['active']): ?>
              <span class="bg-green-100 text-green-800 text-[10px] uppercase tracking-widest px-2 py-1">Active</span>
            <?php else: ?>
              <span class="bg-zinc-200 text-zinc-600 text-[10px] uppercase tracking-widest px-2 py-1">Disabled</span>
            <?php endif; ?>
            <?php if ($user['must_change']): ?>
              <span class="bg-gold/20 text-gold text-[10px] uppercase tracking-widest px-2 py-1 ml-1">Pw Reset Pending</span>
            <?php endif; ?>
          </dd>
        </div>
      </dl>

      <div class="mt-5 pt-5 border-t border-zinc-100 space-y-2">
        <form action="<?= site_url('admin/clients/' . $user['id'] . '/toggle') ?>" method="post">
          <?= csrf_field() ?>
          <button class="w-full border border-zinc-300 hover:bg-ink hover:text-cream text-xs uppercase tracking-widest py-2 transition">
            <?= $user['active'] ? 'Disable Client' : 'Enable Client' ?>
          </button>
        </form>
        <form action="<?= site_url('admin/clients/' . $user['id'] . '/reset-password') ?>" method="post" onsubmit="return confirm('Generate a new temporary password for this client? They will be forced to change it on next login.');">
          <?= csrf_field() ?>
          <button class="w-full border border-gold text-gold hover:bg-gold hover:text-white text-xs uppercase tracking-widest py-2 transition">
            Reset Password
          </button>
        </form>
      </div>
    </div>

    <!-- Expiry card -->
    <div class="card p-6">
      <h2 class="font-display text-xl mb-4">Access Expiry</h2>
      <p class="text-xs text-muted mb-4">Client access is automatically revoked after this date. Leave blank for unlimited access.</p>
      <?php if ($user['expires_at']): ?>
        <?php $expired = strtotime($user['expires_at']) < time(); ?>
        <div class="mb-4 p-3 <?= $expired ? 'bg-red-50 border border-red-200' : 'bg-gold/10 border border-gold/30' ?>">
          <p class="text-xs uppercase tracking-widest <?= $expired ? 'text-red-700' : 'text-gold' ?>"><?= $expired ? 'Expired' : 'Expires on' ?></p>
          <p class="font-display text-2xl mt-1"><?= app_date($user['expires_at']) ?></p>
          <p class="text-xs text-muted"><?= app_time($user['expires_at']) ?></p>
        </div>
      <?php endif; ?>
      <form action="<?= site_url('admin/clients/' . $user['id'] . '/expiry') ?>" method="post" class="space-y-3">
        <?= csrf_field() ?>
        <label class="block text-[10px] uppercase tracking-widest text-muted">Set expiry date</label>
        <input type="date" name="access_expires_at"
               value="<?= $user['expires_at'] ? date('Y-m-d', strtotime($user['expires_at'])) : '' ?>"
               class="w-full border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-gold"/>
        <div class="flex gap-2">
          <button type="submit" class="flex-1 bg-ink text-cream text-xs uppercase tracking-widest py-2 hover:bg-gold transition">Save</button>
          <?php if ($user['expires_at']): ?>
            <button type="submit" name="access_expires_at" value="" class="border border-zinc-300 text-xs uppercase tracking-widest px-4 py-2 hover:border-red-500 hover:text-red-600 transition">Clear</button>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <!-- Original request card -->
    <?php if ($request): ?>
      <div class="card p-6">
        <h2 class="font-display text-xl mb-4">Original Request</h2>
        <dl class="space-y-2 text-sm">
          <div><dt class="text-[10px] uppercase tracking-widest text-muted">Name</dt><dd><?= esc($request['name']) ?></dd></div>
          <div><dt class="text-[10px] uppercase tracking-widest text-muted">Phone</dt><dd><?= esc($request['phone'] ?? '—') ?></dd></div>
          <div><dt class="text-[10px] uppercase tracking-widest text-muted">Company</dt><dd><?= esc($request['company'] ?? '—') ?></dd></div>
          <?php if (!empty($request['business_type'])): ?>
            <div><dt class="text-[10px] uppercase tracking-widest text-muted">Business type</dt><dd><?= esc($request['business_type']) ?></dd></div>
          <?php endif; ?>
          <?php if (!empty($request['city']) || !empty($request['country'])): ?>
            <div>
              <dt class="text-[10px] uppercase tracking-widest text-muted">Location</dt>
              <dd><?= esc(trim(($request['city'] ?? '') . ', ' . ($request['country'] ?? ''), ', ')) ?></dd>
            </div>
          <?php endif; ?>
          <div><dt class="text-[10px] uppercase tracking-widest text-muted">Approved</dt><dd><?= $request['reviewed_at'] ? app_datetime($request['reviewed_at']) : '—' ?></dd></div>
        </dl>
      </div>
    <?php endif; ?>
  </div>

  <!-- Right: activity + stats -->
  <div class="lg:col-span-2 space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-3 gap-4">
      <div class="card p-5">
        <p class="text-[10px] uppercase tracking-widest text-muted">Total Views</p>
        <p class="font-display text-4xl mt-2"><?= (int) $stats['total'] ?></p>
      </div>
      <div class="card p-5">
        <p class="text-[10px] uppercase tracking-widest text-muted">Categories Browsed</p>
        <p class="font-display text-4xl mt-2"><?= (int) $stats['categories'] ?></p>
      </div>
      <div class="card p-5">
        <p class="text-[10px] uppercase tracking-widest text-muted">SKUs Viewed</p>
        <p class="font-display text-4xl mt-2"><?= (int) $stats['products'] ?></p>
      </div>
    </div>

    <!-- Activity log -->
    <div class="card p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="font-display text-xl">Browsing History</h2>
        <?php if (!empty($activity)): ?>
          <form action="<?= site_url('admin/clients/' . $user['id'] . '/clear-activity') ?>" method="post" onsubmit="return confirm('Clear all activity history for this client? This cannot be undone.');">
            <?= csrf_field() ?>
            <button class="text-[10px] uppercase tracking-widest text-muted hover:text-red-600">Clear History</button>
          </form>
        <?php endif; ?>
      </div>

      <?php if (empty($activity)): ?>
        <p class="text-sm text-muted text-center py-8">No activity recorded yet. Views will appear here as the client browses the catalog.</p>
      <?php else: ?>
        <table class="w-full text-sm">
          <thead class="text-[10px] uppercase tracking-widest text-muted border-b">
            <tr>
              <th class="text-left py-2">When</th>
              <th class="text-left">Action</th>
              <th class="text-left">Item</th>
              <th class="text-left">IP</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($activity as $a): ?>
              <tr class="border-b border-zinc-100">
                <td class="py-3 text-muted text-xs whitespace-nowrap"><?= app_datetime($a['created_at']) ?></td>
                <td class="py-3">
                  <?php
                    $actionLabel = [
                      'catalog.view'  => 'Viewed catalog',
                      'category.view' => 'Viewed category',
                      'product.view'  => 'Viewed SKU',
                    ][$a['action']] ?? $a['action'];
                  ?>
                  <span class="text-xs uppercase tracking-widest"><?= esc($actionLabel) ?></span>
                </td>
                <td class="py-3">
                  <?php if (!empty($a['entity_label'])): ?>
                    <span class="font-display text-base"><?= esc($a['entity_label']) ?></span>
                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
                <td class="py-3 text-muted text-xs font-mono"><?= esc($a['ip'] ?? '—') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
