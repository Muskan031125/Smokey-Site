<?php
$total      = count($projects);
$active     = count(array_filter($projects, fn($p) => ($p['status'] ?? 'active') === 'active'));
$totalCreds = array_sum(array_column($projects, 'credential_count'));
$totalSvr   = count($servers);
?>

<!-- Stat cards -->
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px">
    <div class="stat-card">
        <div class="stat-value"><?= $total ?></div>
        <div class="stat-label">Total Projects</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $active ?></div>
        <div class="stat-label">Active Projects</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $totalSvr ?></div>
        <div class="stat-label">Total Servers</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= count(array_filter($servers, fn($s) => ($s['status'] ?? 'active') === 'active')) ?></div>
        <div class="stat-label">Active Servers</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;align-items:start">

    <!-- Projects table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Projects</h3>
            <a href="<?= base_url('projects') ?>" style="font-size:12px;color:var(--accent);text-decoration:none">View all →</a>
        </div>
        <?php if (empty($projects)): ?>
        <div class="empty-state" style="padding:24px">
            <div class="icon">📁</div>
            <p>No projects yet.</p>
            <a href="<?= base_url('projects/create') ?>" class="btn btn-primary btn-sm">+ Create</a>
        </div>
        <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Creds</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($projects as $p): ?>
                    <tr style="cursor:pointer" onclick="window.location='<?= base_url('projects/' . $p['id']) ?>'">
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                <span class="project-dot" style="background:<?= esc($p['color'] ?? '#7c6ff7') ?>"></span>
                                <div>
                                    <div style="font-weight:600;color:var(--text-strong);font-size:13.5px"><?= esc($p['name']) ?></div>
                                    <?php if (!empty($p['url'])): ?>
                                    <div style="font-size:11px;color:var(--muted)"><?= esc(parse_url($p['url'], PHP_URL_HOST) ?: $p['url']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-<?= esc($p['status'] ?? 'active') ?>"><?= ucfirst(esc($p['status'] ?? 'active')) ?></span></td>
                        <td style="font-weight:700;color:var(--accent);text-align:center"><?= $p['credential_count'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <!-- Servers table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Servers &amp; Accounts</h3>
            <a href="<?= base_url('servers') ?>" style="font-size:12px;color:var(--accent);text-decoration:none">View all →</a>
        </div>
        <?php if (empty($servers)): ?>
        <div class="empty-state" style="padding:24px">
            <div class="icon">🖥️</div>
            <p>No servers added yet.</p>
            <a href="<?= base_url('servers/create') ?>" class="btn btn-primary btn-sm">+ Add</a>
        </div>
        <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Account</th>
                        <th>Login</th>
                        <th>Projects</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($servers as $s): ?>
                    <tr style="cursor:pointer" onclick="window.location='<?= base_url('servers/' . $s['id']) ?>'">
                        <td>
                            <div style="font-weight:600;color:var(--text-strong);font-size:13.5px"><?= esc($s['name']) ?></div>
                            <?php if (!empty($s['panel_url'])): ?>
                            <div style="font-size:11px;color:var(--muted)"><?= esc(parse_url($s['panel_url'], PHP_URL_HOST) ?: $s['panel_url']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td style="font-size:12px;color:var(--muted)"><?= esc($s['login_email'] ?? '—') ?></td>
                        <td style="font-weight:700;color:var(--accent);text-align:center"><?= (int)$s['project_count'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

</div>
