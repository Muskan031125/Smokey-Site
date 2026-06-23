<div style="display:flex;gap:24px;align-items:flex-start;flex-wrap:wrap">

    <!-- ── Left: Project info panel ── -->
    <div style="flex:0 0 280px;min-width:240px">
        <div class="card" style="border-top:4px solid <?= esc($project['color'] ?? '#7c6ff7') ?>">

            <div style="margin-bottom:14px">
                <h2 style="font-size:19px;font-weight:700;color:var(--text-strong);margin-bottom:7px;line-height:1.2">
                    <?= esc($project['name']) ?>
                </h2>
                <span class="badge badge-<?= esc($project['status'] ?? 'active') ?>">
                    <?= ucfirst(esc($project['status'] ?? 'active')) ?>
                </span>
            </div>

            <?php if (!empty($project['url'])): ?>
            <div style="margin-bottom:14px;padding:10px 12px;background:var(--surface2);border:1px solid var(--border);border-radius:8px">
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--muted);margin-bottom:5px">Main URL</div>
                <div style="display:flex;align-items:center;gap:6px">
                    <a href="<?= esc($project['url']) ?>" target="_blank" rel="noopener"
                       style="color:var(--accent);font-size:12.5px;word-break:break-all;text-decoration:none;flex:1;line-height:1.4">
                        <?= esc($project['url']) ?>
                    </a>
                    <button class="copy-btn" onclick="copyText('<?= esc(addslashes($project['url'])) ?>',this)" title="Copy URL" style="flex-shrink:0">⎘</button>
                </div>
            </div>
            <?php endif; ?>

            <!-- Meta pills: category, tech stack -->
            <?php
            $pills = [];
            if (!empty($project['category']))   $pills[] = ['🏷', $project['category']];
            if (!empty($project['tech_stack'])) $pills[] = ['⚙️', $project['tech_stack']];
            ?>
            <?php if ($pills): ?>
            <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px">
                <?php foreach ($pills as [$icon, $val]): ?>
                <span style="display:inline-flex;align-items:center;gap:5px;background:var(--surface2);border:1px solid var(--border);border-radius:20px;padding:3px 10px;font-size:12px;color:var(--text)">
                    <?= $icon ?> <?= esc($val) ?>
                </span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>


            <!-- Server badge -->
            <?php if (!empty($server)): ?>
            <div style="margin-bottom:14px;padding:10px 12px;background:var(--surface2);border:1px solid var(--border);border-radius:8px">
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--muted);margin-bottom:5px">Hosted On</div>
                <a href="<?= base_url('servers/' . $server['id']) ?>"
                   style="color:var(--accent);text-decoration:none;font-size:13px;font-weight:600">
                    🖥️ <?= esc($server['name']) ?>
                </a>
                <?php if ($server['provider']): ?>
                    <span style="color:var(--muted);font-size:12px;margin-left:5px">(<?= esc($server['provider']) ?>)</span>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($project['description'])): ?>
            <p style="color:var(--text);font-size:13.5px;line-height:1.65;margin-bottom:14px">
                <?= nl2br(esc($project['description'])) ?>
            </p>
            <?php endif; ?>

            <div style="font-size:11.5px;color:var(--muted);border-top:1px solid var(--border);padding-top:12px;margin-bottom:14px">
                Created <?= date('d M Y', strtotime($project['created_at'])) ?>
            </div>

            <div style="display:flex;gap:8px;flex-wrap:wrap">
                <a href="<?= base_url('projects/edit/' . $project['id']) ?>" class="btn btn-secondary btn-sm">✏ Edit</a>
                <form method="post" action="<?= base_url('projects/delete/' . $project['id']) ?>" onsubmit="confirmDelete(this);return false;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm">🗑 Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- ── Right: Credentials table ── -->
    <div style="flex:1;min-width:0">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Login Credentials
                    <span style="color:var(--muted);font-weight:400;font-size:13px;margin-left:4px">(<?= count($credentials) ?>)</span>
                </h3>
                <button class="btn btn-primary btn-sm" onclick="toggleInlineForm()">+ Add Credential</button>
            </div>

            <!-- Inline add credential form -->
            <div id="inlineForm" style="display:none;margin-bottom:20px">
                <div style="background:var(--surface2);border:1px solid var(--border);border-radius:10px;padding:18px">
                    <h4 style="font-size:13.5px;font-weight:700;color:var(--text-strong);margin-bottom:16px">Add Credential</h4>
                    <form method="post" action="<?= base_url('credentials/store') ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="project_id" value="<?= esc($project['id']) ?>">
                        <div class="form-group">
                            <label class="form-label">Label *</label>
                            <input type="text" name="label" class="form-control" placeholder="Admin Panel, cPanel, FTP…" required autofocus>
                        </div>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label">Username / Email</label>
                                <input type="text" name="username" class="form-control" placeholder="admin@example.com" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <div class="pw-wrap">
                                    <input type="password" name="password" id="inlinePw" class="form-control" placeholder="••••••••" autocomplete="new-password">
                                    <button type="button" class="pw-toggle" onclick="togglePw('inlinePw',this)">👁</button>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;gap:10px">
                            <button type="submit" class="btn btn-primary btn-sm">+ Add</button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="toggleInlineForm()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php if (empty($credentials)): ?>
            <div class="empty-state" style="padding:32px 20px">
                <div class="icon">🔐</div>
                <p>No credentials yet for this project.</p>
                <button class="btn btn-primary btn-sm" onclick="toggleInlineForm()">+ Add First Credential</button>
            </div>
            <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Username / Email</th>
                            <th>Password</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($credentials as $i => $c): ?>
                        <tr>
                            <td style="font-weight:600;color:var(--text-strong)"><?= esc($c['label']) ?></td>
                            <td>
                                <div style="display:flex;align-items:center;gap:5px">
                                    <code style="font-size:12px;background:var(--surface2);padding:2px 7px;border-radius:5px;color:var(--text)">
                                        <?= esc($c['username'] ?: '—') ?>
                                    </code>
                                    <?php if (!empty($c['username'])): ?>
                                    <button class="copy-btn" onclick="copyText('<?= esc(addslashes($c['username'])) ?>',this)" title="Copy">⎘</button>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:5px">
                                    <div style="position:relative;display:inline-flex;align-items:center">
                                        <input type="password" id="pw_<?= $i ?>"
                                               value="<?= esc($c['password'] ?? '') ?>" readonly
                                               style="background:var(--surface2);border:1px solid var(--border);border-radius:6px;padding:4px 34px 4px 8px;color:var(--text);font-size:12px;font-family:'DM Mono',monospace;width:130px;cursor:default">
                                        <button class="pw-toggle" style="position:absolute;right:7px;top:50%;transform:translateY(-50%)"
                                                onclick="togglePw('pw_<?= $i ?>',this)">👁</button>
                                    </div>
                                    <?php if (!empty($c['password'])): ?>
                                    <button class="copy-btn" onclick="copyText('<?= esc(addslashes($c['password'])) ?>',this)" title="Copy">⎘</button>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex;gap:5px">
                                    <a href="<?= base_url('credentials/edit/' . $c['id']) ?>" class="btn btn-ghost btn-sm">✏</a>
                                    <form method="post" action="<?= base_url('credentials/delete/' . $c['id']) ?>" onsubmit="confirmDelete(this);return false;">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>
