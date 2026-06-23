<?php $isEdit = !empty($credential); ?>

<div style="max-width:580px;margin:0 auto">
<div class="card">
    <div style="margin-bottom:20px">
        <h3 class="card-title" style="margin-bottom:4px"><?= $isEdit ? 'Edit Credential' : 'Add Credential' ?></h3>
        <p style="font-size:13px;color:var(--muted)">
            Project:
            <a href="<?= base_url('projects/' . $project['id']) ?>"
               style="color:var(--accent);text-decoration:none;font-weight:600">
                <?= esc($project['name']) ?>
            </a>
            <?php if (!empty($project['url'])): ?>
                <span style="color:var(--border);margin:0 5px">·</span>
                <a href="<?= esc($project['url']) ?>" target="_blank" rel="noopener"
                   style="color:var(--muted);font-size:12px;text-decoration:none">
                    <?= esc(parse_url($project['url'], PHP_URL_HOST) ?: $project['url']) ?>
                </a>
            <?php endif; ?>
        </p>
    </div>

    <form method="post" action="<?= base_url($isEdit ? 'credentials/update/' . $credential['id'] : 'credentials/store') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="project_id" value="<?= esc($project['id']) ?>">

        <div class="form-group">
            <label class="form-label">Label *</label>
            <input type="text" name="label" class="form-control"
                   value="<?= esc(old('label', $credential['label'] ?? '')) ?>"
                   placeholder="e.g. Admin Panel, cPanel, FTP, Hosting" autofocus required>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Username / Email</label>
                <input type="text" name="username" class="form-control"
                       value="<?= esc(old('username', $credential['username'] ?? '')) ?>"
                       placeholder="admin@example.com" autocomplete="off">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="pw-wrap">
                    <input type="password" name="password" id="pwField" class="form-control"
                           value="<?= esc(old('password', $credential['password'] ?? '')) ?>"
                           placeholder="••••••••" autocomplete="new-password">
                    <button type="button" class="pw-toggle" onclick="togglePw('pwField',this)">👁</button>
                </div>
            </div>
        </div>

        <?php if (!empty(session()->getFlashdata('errors'))): ?>
            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                <div class="alert alert-error" style="margin-bottom:12px"><?= esc($err) ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div style="display:flex;gap:10px;margin-top:4px">
            <button type="submit" class="btn btn-primary"><?= $isEdit ? '✓ Update' : '+ Add Credential' ?></button>
            <a href="<?= base_url('projects/' . $project['id']) ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</div>
