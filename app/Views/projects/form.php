<?php
$isEdit = !empty($project);
$colors = ['#7c6ff7','#8b5cf6','#ec4899','#ef4444','#f59e0b','#22c55e','#14b8a6','#0ea5e9','#f97316','#64748b'];
$currentColor = $project['color'] ?? '#7c6ff7';
$categories = ['CRM','CMS','ERP','LMS','eCommerce','Portfolio','SaaS','Internal Tool','Landing Page','API / Backend','Other'];
$stacks = ['CodeIgniter 4','Laravel','WordPress','React','Next.js','Vue.js','Node.js','Django','Ruby on Rails','Plain PHP','Other'];
?>

<div style="max-width:600px;margin:0 auto">
<div class="card">
    <h3 class="card-title" style="margin-bottom:22px"><?= $isEdit ? 'Edit Project' : 'Create New Project' ?></h3>

    <form method="post" action="<?= base_url($isEdit ? 'projects/update/' . $project['id'] : 'projects/store') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label">Project Name *</label>
            <input type="text" name="name" class="form-control"
                   value="<?= esc(old('name', $project['name'] ?? '')) ?>"
                   placeholder="e.g. Client Portal" autofocus required>
            <?php foreach (session()->getFlashdata('errors') ?? [] as $err): ?>
                <div class="form-error"><?= esc($err) ?></div>
            <?php endforeach; ?>
        </div>

        <div class="form-group">
            <label class="form-label">Project / Main URL</label>
            <input type="url" name="url" class="form-control"
                   value="<?= esc(old('url', $project['url'] ?? '')) ?>"
                   placeholder="https://example.com">
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="category" class="form-control">
                    <option value="">— Select —</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat ?>" <?= old('category', $project['category'] ?? '') === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Tech Stack</label>
                <select name="tech_stack" class="form-control">
                    <option value="">— Select —</option>
                    <?php foreach ($stacks as $st): ?>
                        <option value="<?= $st ?>" <?= old('tech_stack', $project['tech_stack'] ?? '') === $st ? 'selected' : '' ?>><?= $st ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Hosted On (Server / Account)</label>
            <select name="server_id" class="form-control">
                <option value="">— None / Unknown —</option>
                <?php foreach ($servers as $sv): ?>
                    <option value="<?= $sv['id'] ?>"
                        <?= (int) old('server_id', $project['server_id'] ?? 0) === (int) $sv['id'] ? 'selected' : '' ?>>
                        <?= esc($sv['name']) ?>
                        <?= $sv['login_email'] ? '· ' . esc($sv['login_email']) : '' ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" placeholder="What is this project about?"><?= esc(old('description', $project['description'] ?? '')) ?></textarea>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Colour Label</label>
                <input type="hidden" name="color" id="colorInput" value="<?= esc($currentColor) ?>">
                <div class="color-picker-row" style="margin-top:4px">
                    <?php foreach ($colors as $c): ?>
                        <span class="color-swatch <?= $c === $currentColor ? 'selected' : '' ?>"
                              style="background:<?= $c ?>"
                              onclick="selectColor('<?= $c ?>', this)"></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="active"   <?= ($project['status'] ?? 'active') === 'active'   ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($project['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:6px">
            <button type="submit" class="btn btn-primary"><?= $isEdit ? '✓ Update Project' : '+ Create Project' ?></button>
            <a href="<?= base_url($isEdit ? 'projects/' . $project['id'] : 'projects') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</div>
