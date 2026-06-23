<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h2 class="font-display text-2xl mb-4">Pending <span class="text-muted text-sm">(<?= count($pending) ?>)</span></h2>

<?php if (empty($pending)): ?>
  <div class="card p-8 text-center text-muted mb-8">No pending requests.</div>
<?php else: ?>
  <div class="space-y-4 mb-10">
    <?php foreach ($pending as $r): ?>
      <div class="card p-6">
        <div class="flex justify-between items-start gap-4 mb-4">
          <div>
            <h3 class="font-display text-2xl"><?= esc($r['name']) ?></h3>
            <p class="text-xs text-muted mt-1">Received <?= app_datetime($r['created_at']) ?></p>
          </div>
          <div class="flex gap-2">
            <form action="<?= site_url('admin/access-requests/' . $r['id'] . '/approve') ?>" method="post" onsubmit="return confirm('Approve this request and create a client account? An email with temporary credentials will be sent.');">
              <?= csrf_field() ?>
              <button class="bg-green-700 text-white text-xs uppercase tracking-widest px-5 py-2 hover:bg-gold transition">Approve</button>
            </form>
            <form action="<?= site_url('admin/access-requests/' . $r['id'] . '/reject') ?>" method="post">
              <?= csrf_field() ?>
              <button class="border border-red-600 text-red-700 text-xs uppercase tracking-widest px-5 py-2 hover:bg-red-600 hover:text-white transition">Reject</button>
            </form>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
          <!-- Personal -->
          <div>
            <p class="text-[10px] uppercase tracking-widest text-gold mb-2">Contact</p>
            <dl class="space-y-1">
              <div><dt class="text-xs text-muted">Email</dt><dd><a href="mailto:<?= esc($r['email']) ?>" class="hover:text-gold"><?= esc($r['email']) ?></a></dd></div>
              <div><dt class="text-xs text-muted">Phone</dt><dd><?= esc($r['phone'] ?? '—') ?></dd></div>
              <?php if (!empty($r['referred_by'])): ?>
                <div><dt class="text-xs text-muted">Referred by</dt><dd><?= esc($r['referred_by']) ?></dd></div>
              <?php endif; ?>
            </dl>
          </div>

          <!-- Business -->
          <div>
            <p class="text-[10px] uppercase tracking-widest text-gold mb-2">Business</p>
            <dl class="space-y-1">
              <div><dt class="text-xs text-muted">Company</dt><dd><?= esc($r['company'] ?? '—') ?></dd></div>
              <div><dt class="text-xs text-muted">Type</dt><dd><?= esc($r['business_type'] ?? '—') ?></dd></div>
              <?php if (!empty($r['gst_number'])): ?>
                <div><dt class="text-xs text-muted">GST / Tax ID</dt><dd class="font-mono text-xs"><?= esc($r['gst_number']) ?></dd></div>
              <?php endif; ?>
              <?php if (!empty($r['website'])): ?>
                <div><dt class="text-xs text-muted">Website</dt><dd><a href="<?= esc($r['website']) ?>" target="_blank" class="hover:text-gold text-xs"><?= esc($r['website']) ?></a></dd></div>
              <?php endif; ?>
            </dl>
          </div>

          <!-- Address -->
          <div>
            <p class="text-[10px] uppercase tracking-widest text-gold mb-2">Address</p>
            <address class="not-italic text-sm leading-relaxed">
              <?= esc($r['address_line1'] ?? '') ?><?php if (!empty($r['address_line2'])): ?><br/><?= esc($r['address_line2']) ?><?php endif; ?><br/>
              <?= esc(trim(($r['city'] ?? '') . ' ' . ($r['postal_code'] ?? ''))) ?><?php if (!empty($r['state'])): ?>, <?= esc($r['state']) ?><?php endif; ?><br/>
              <?= esc($r['country'] ?? '') ?>
            </address>
          </div>
        </div>

        <?php if (!empty($r['message'])): ?>
          <div class="mt-4 pt-4 border-t border-zinc-100">
            <p class="text-[10px] uppercase tracking-widest text-gold mb-2">Note from applicant</p>
            <p class="text-sm italic text-muted">"<?= esc($r['message']) ?>"</p>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<h2 class="font-display text-2xl mb-4">Recently Reviewed</h2>
<?php if (empty($reviewed)): ?>
  <div class="card p-8 text-center text-muted">None yet.</div>
<?php else: ?>
  <div class="card overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="text-[10px] uppercase tracking-widest text-muted border-b">
        <tr><th class="text-left p-4">Name</th><th class="text-left p-4">Email</th><th class="text-left p-4">Company</th><th class="text-left p-4">Status</th><th class="text-left p-4">Reviewed</th></tr>
      </thead>
      <tbody>
        <?php foreach ($reviewed as $r): ?>
          <tr class="border-b border-zinc-100">
            <td class="p-4"><?= esc($r['name']) ?></td>
            <td class="p-4"><?= esc($r['email']) ?></td>
            <td class="p-4 text-muted"><?= esc($r['company'] ?? '—') ?></td>
            <td class="p-4">
              <?php if ($r['status'] === 'approved'): ?>
                <span class="bg-green-100 text-green-800 text-[10px] uppercase tracking-widest px-2 py-1">Approved</span>
              <?php else: ?>
                <span class="bg-red-100 text-red-800 text-[10px] uppercase tracking-widest px-2 py-1">Rejected</span>
              <?php endif; ?>
            </td>
            <td class="p-4 text-muted text-xs"><?= app_datetime($r['reviewed_at']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?= $this->endSection() ?>
