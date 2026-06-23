<?php $isEdit = !empty($server); ?>

<div style="max-width:520px;margin:0 auto">
<div class="card">
    <h3 class="card-title" style="margin-bottom:22px"><?= $isEdit ? 'Edit Server / Account' : 'Add Server / Account' ?></h3>

    <form method="post" action="<?= base_url($isEdit ? 'servers/update/' . $server['id'] : 'servers/store') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label">Account Name *</label>
            <input type="text" name="name" class="form-control"
                   value="<?= esc(old('name', $server['name'] ?? '')) ?>"
                   placeholder="e.g. Hostinger, cPanel - Client, Cloudflare" autofocus required>
        </div>

        <div class="form-group">
            <label class="form-label">Panel / Login URL</label>
            <input type="url" name="panel_url" class="form-control"
                   value="<?= esc(old('panel_url', $server['panel_url'] ?? '')) ?>"
                   placeholder="https://hpanel.hostinger.com">
        </div>

        <div class="form-group">
            <label class="form-label">Login Email / Username</label>
            <input type="text" name="login_email" class="form-control"
                   value="<?= esc(old('login_email', $server['login_email'] ?? '')) ?>"
                   placeholder="team@yngmedia.com" autocomplete="off">
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <div class="pw-wrap">
                <input type="password" name="login_password" id="pwField" class="form-control"
                       value="<?= esc(old('login_password', $server['login_password'] ?? '')) ?>"
                       placeholder="••••••••" autocomplete="new-password">
                <button type="button" class="pw-toggle" onclick="togglePw('pwField',this)">👁</button>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control"
                      placeholder="Any extra details, SSH access, account type…"><?= esc(old('notes', $server['notes'] ?? '')) ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="active"   <?= ($server['status'] ?? 'active') === 'active'   ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= ($server['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>

        <div style="display:flex;gap:10px;margin-top:6px">
            <button type="submit" class="btn btn-primary"><?= $isEdit ? '✓ Update' : '+ Add Account' ?></button>
            <a href="<?= base_url($isEdit ? 'servers/' . $server['id'] : 'servers') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</div>
