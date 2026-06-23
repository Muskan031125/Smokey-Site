<div style="display:flex;gap:24px;align-items:flex-start;flex-wrap:wrap">

    <!-- Left: Server info -->
    <div style="flex:0 0 280px;min-width:240px">
        <div class="card" style="border-top:4px solid var(--accent)">
            <div style="margin-bottom:14px">
                <h2 style="font-size:19px;font-weight:700;color:var(--text-strong);margin-bottom:6px"><?= esc($server['name']) ?></h2>
                <span class="badge badge-<?= esc($server['status']) ?>"><?= ucfirst(esc($server['status'])) ?></span>
            </div>

            <?php
            $info = [
                'Provider'  => $server['provider'],
                'IP Address'=> $server['ip_address'],
                'Location'  => $server['location'],
                'Plan'      => $server['plan'],
            ];
            foreach ($info as $label => $val): if (!$val) continue; ?>
            <div style="margin-bottom:10px;padding:9px 12px;background:var(--surface2);border:1px solid var(--border);border-radius:8px">
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--muted);margin-bottom:3px"><?= $label ?></div>
                <span style="font-size:13px;color:var(--text-strong)"><?= esc($val) ?></span>
            </div>
            <?php endforeach; ?>

            <?php if ($server['panel_url']): ?>
            <div style="margin-bottom:10px;padding:9px 12px;background:var(--surface2);border:1px solid var(--border);border-radius:8px">
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--muted);margin-bottom:3px">Panel URL</div>
                <a href="<?= esc($server['panel_url']) ?>" target="_blank" rel="noopener"
                   style="color:var(--accent);font-size:12.5px;word-break:break-all;text-decoration:none">
                    <?= esc($server['panel_url']) ?>
                </a>
            </div>
            <?php endif; ?>

            <!-- Login credentials -->
            <?php if ($server['login_email'] || $server['login_password']): ?>
            <div style="margin-bottom:14px;padding:10px 12px;background:var(--surface2);border:1px solid var(--border);border-radius:8px">
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--muted);margin-bottom:8px">Panel Login</div>
                <?php if ($server['login_email']): ?>
                <div style="display:flex;align-items:center;gap:6px;margin-bottom:6px">
                    <code style="font-size:12px;flex:1;color:var(--text)"><?= esc($server['login_email']) ?></code>
                    <button class="copy-btn" onclick="copyText('<?= esc(addslashes($server['login_email'])) ?>',this)">⎘</button>
                </div>
                <?php endif; ?>
                <?php if ($server['login_password']): ?>
                <div style="display:flex;align-items:center;gap:6px">
                    <div style="position:relative;flex:1">
                        <input type="password" id="svPw" value="<?= esc($server['login_password']) ?>" readonly
                               style="width:100%;background:var(--surface);border:1px solid var(--border);border-radius:6px;padding:4px 32px 4px 8px;color:var(--text);font-size:12px;font-family:'DM Mono',monospace">
                        <button class="pw-toggle" style="position:absolute;right:6px;top:50%;transform:translateY(-50%)"
                                onclick="togglePw('svPw',this)">👁</button>
                    </div>
                    <button class="copy-btn" onclick="copyText('<?= esc(addslashes($server['login_password'])) ?>',this)">⎘</button>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($server['notes']): ?>
            <p style="font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:14px"><?= nl2br(esc($server['notes'])) ?></p>
            <?php endif; ?>

            <div style="display:flex;gap:8px;flex-wrap:wrap;border-top:1px solid var(--border);padding-top:12px">
                <a href="<?= base_url('servers/edit/' . $server['id']) ?>" class="btn btn-secondary btn-sm">✏ Edit</a>
                <form method="post" action="<?= base_url('servers/delete/' . $server['id']) ?>" onsubmit="confirmDelete(this);return false;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm">🗑 Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right: Projects on this server -->
    <div style="flex:1;min-width:0">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Projects on this server <span style="color:var(--muted);font-weight:400;font-size:13px">(<?= count($projects) ?>)</span></h3>
                <a href="<?= base_url('projects/create') ?>" class="btn btn-primary btn-sm">+ New Project</a>
            </div>

            <?php if (empty($projects)): ?>
            <div class="empty-state" style="padding:28px">
                <div class="icon">📁</div>
                <p>No projects linked to this server yet.</p>
            </div>
            <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Category</th>
                            <th>Tech Stack</th>
                            <th>URL</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($projects as $p): ?>
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px">
                                    <span class="project-dot" style="background:<?= esc($p['color'] ?? '#7c6ff7') ?>"></span>
                                    <span style="font-weight:600;color:var(--text-strong)"><?= esc($p['name']) ?></span>
                                </div>
                            </td>
                            <td><span style="color:var(--muted);font-size:12px"><?= esc($p['category'] ?: '—') ?></span></td>
                            <td><code style="font-size:11.5px;background:var(--surface2);padding:2px 7px;border-radius:4px;color:var(--muted2)"><?= esc($p['tech_stack'] ?: '—') ?></code></td>
                            <td>
                                <?php if ($p['url']): ?>
                                <a href="<?= esc($p['url']) ?>" target="_blank" rel="noopener"
                                   style="color:var(--accent);font-size:12px;text-decoration:none">
                                    <?= esc(parse_url($p['url'], PHP_URL_HOST) ?: $p['url']) ?>
                                </a>
                                <?php else: ?><span style="color:var(--muted);font-size:12px">—</span><?php endif; ?>
                            </td>
                            <td><span class="badge badge-<?= esc($p['status']) ?>"><?= ucfirst(esc($p['status'])) ?></span></td>
                            <td><a href="<?= base_url('projects/' . $p['id']) ?>" class="btn btn-ghost btn-sm">Open →</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>
