<div style="margin-bottom:20px;display:flex;align-items:center;justify-content:space-between">
    <div>
        <h3 style="font-size:16px;font-weight:700;color:var(--text-strong)">Servers &amp; Accounts</h3>
        <p style="font-size:13px;color:var(--muted);margin-top:2px"><?= count($servers) ?> account<?= count($servers) !== 1 ? 's' : '' ?> configured</p>
    </div>
</div>

<?php if (empty($servers)): ?>
<div class="card">
    <div class="empty-state">
        <div class="icon">🖥️</div>
        <p>No servers added yet.</p>
        <a href="<?= base_url('servers/create') ?>" class="btn btn-primary">+ Add Server</a>
    </div>
</div>
<?php else: ?>
<div class="card" style="padding:0">
    <div class="table-wrap" style="border:none;border-radius:12px">
        <table>
            <thead>
                <tr>
                    <th>Account Name</th>
                    <th>Login Email</th>
                    <th>Panel URL</th>
                    <th>Projects</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($servers as $s): ?>
                <tr style="cursor:pointer" onclick="window.location='<?= base_url('servers/' . $s['id']) ?>'">
                    <td>
                        <div style="font-weight:600;color:var(--text-strong);font-size:14px"><?= esc($s['name']) ?></div>
                        <?php if ($s['notes']): ?>
                            <div style="font-size:11.5px;color:var(--muted);margin-top:2px"><?= esc(mb_strimwidth($s['notes'], 0, 50, '…')) ?></div>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:13px;color:var(--text)"><?= esc($s['login_email'] ?: '—') ?></td>
                    <td>
                        <?php if ($s['panel_url']): ?>
                            <span style="font-size:12px;color:var(--muted)"><?= esc(parse_url($s['panel_url'], PHP_URL_HOST) ?: $s['panel_url']) ?></span>
                        <?php else: ?>
                            <span style="color:var(--muted);font-size:12px">—</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align:center">
                        <span style="font-weight:700;color:var(--accent);font-size:15px"><?= (int)$s['project_count'] ?></span>
                    </td>
                    <td><span class="badge badge-<?= esc($s['status']) ?>"><?= ucfirst(esc($s['status'])) ?></span></td>
                    <td onclick="event.stopPropagation()">
                        <a href="<?= base_url('servers/edit/' . $s['id']) ?>" class="btn btn-secondary btn-sm">✏ Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>
