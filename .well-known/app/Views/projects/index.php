<?php
$currentUrl = base_url('projects');
$queryParts = [];
if ($search !== '') $queryParts[] = 'q=' . urlencode($search);
?>

<!-- Search bar -->
<form method="get" action="<?= $currentUrl ?>">
    <div class="search-bar">
        <input type="search" name="q" class="search-input"
               placeholder="Search projects by name…"
               value="<?= esc($search) ?>"
               autocomplete="off">
        <button type="submit" class="btn btn-secondary">Search</button>
        <?php if ($search !== ''): ?>
            <a href="<?= $currentUrl ?>" class="btn btn-ghost">✕ Clear</a>
        <?php endif; ?>
    </div>
</form>

<!-- Inline add project form -->
<div id="inlineForm" style="display:none;margin-bottom:20px">
<?php
$colors = ['#7c6ff7','#8b5cf6','#ec4899','#ef4444','#f59e0b','#22c55e','#14b8a6','#0ea5e9','#f97316','#64748b'];
$categories = ['CRM','CMS','ERP','LMS','eCommerce','Portfolio','SaaS','Internal Tool','Landing Page','API / Backend','Other'];
$stacks = ['CodeIgniter 4','Laravel','WordPress','React','Next.js','Vue.js','Node.js','Plain PHP','Other'];
?>
<div class="card" style="border-top:3px solid var(--accent)">
    <h4 style="font-size:14px;font-weight:700;color:var(--text-strong);margin-bottom:18px">New Project</h4>
    <form method="post" action="<?= base_url('projects/store') ?>">
        <?= csrf_field() ?>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Project Name *</label>
                <input type="text" name="name" class="form-control" placeholder="Client Portal" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label">URL</label>
                <input type="url" name="url" class="form-control" placeholder="https://example.com">
            </div>
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="category" class="form-control">
                    <option value="">— Select —</option>
                    <?php foreach ($categories as $c): ?><option value="<?= $c ?>"><?= $c ?></option><?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Tech Stack</label>
                <select name="tech_stack" class="form-control">
                    <option value="">— Select —</option>
                    <?php foreach ($stacks as $s): ?><option value="<?= $s ?>"><?= $s ?></option><?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Colour</label>
            <input type="hidden" name="color" id="colorInput" value="#7c6ff7">
            <div class="color-picker-row">
                <?php foreach ($colors as $c): ?>
                    <span class="color-swatch <?= $c === '#7c6ff7' ? 'selected' : '' ?>"
                          style="background:<?= $c ?>" onclick="selectColor('<?= $c ?>',this)"></span>
                <?php endforeach; ?>
            </div>
        </div>
        <div style="display:flex;gap:10px">
            <button type="submit" class="btn btn-primary">+ Create Project</button>
            <button type="button" class="btn btn-secondary" onclick="toggleInlineForm()">Cancel</button>
        </div>
    </form>
</div>
</div>

<?php if ($search !== ''): ?>
    <p style="color:var(--muted);font-size:13px;margin-bottom:16px">
        <?= $total ?> result<?= $total !== 1 ? 's' : '' ?> for "<strong style="color:var(--text)"><?= esc($search) ?></strong>"
    </p>
<?php endif; ?>

<?php if (empty($projects)): ?>
<div class="card">
    <div class="empty-state">
        <div class="icon"><?= $search ? '🔍' : '📁' ?></div>
        <p><?= $search ? 'No projects match your search.' : 'No projects yet.' ?></p>
        <?php if (!$search): ?>
            <a href="<?= base_url('projects/create') ?>" class="btn btn-primary">+ Create Project</a>
        <?php endif; ?>
    </div>
</div>
<?php else: ?>
<div class="card" style="padding:0">
    <div class="table-wrap" style="border:none;border-radius:12px">
        <table>
            <thead>
                <tr>
                    <th>Project</th>
                    <th>URL</th>
                    <th>Category</th>
                    <th>Server</th>
                    <th>Status</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($projects as $p): ?>
                <tr style="cursor:pointer" onclick="window.location='<?= base_url('projects/' . $p['id']) ?>'">
                    <td>
                        <div style="display:flex;align-items:center;gap:9px">
                            <span class="project-dot" style="background:<?= esc($p['color'] ?? '#6366f1') ?>"></span>
                            <a href="<?= base_url('projects/' . $p['id']) ?>"
                               style="color:var(--text);text-decoration:none;font-weight:500">
                                <?php
                                // Highlight search match
                                if ($search !== '') {
                                    $name = esc($p['name']);
                                    $hl   = esc($search);
                                    echo preg_replace('/(' . preg_quote($hl, '/') . ')/i', '<mark style="background:#6366f133;color:var(--accent);border-radius:3px;padding:0 2px">$1</mark>', $name);
                                } else {
                                    echo esc($p['name']);
                                }
                                ?>
                            </a>
                        </div>
                    </td>
                    <td style="max-width:180px">
                        <?php if (!empty($p['url'])): ?>
                        <a href="<?= esc($p['url']) ?>" target="_blank" rel="noopener" onclick="event.stopPropagation()"
                           style="color:var(--accent);font-size:12px;text-decoration:none;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block">
                            <?= esc(parse_url($p['url'], PHP_URL_HOST) ?: $p['url']) ?>
                        </a>
                        <?php else: ?><span style="color:var(--muted);font-size:12px">—</span><?php endif; ?>
                    </td>
                    <td style="color:var(--muted);font-size:12px"><?= esc($p['category'] ?? '—') ?></td>
                    <td style="font-size:12px;color:var(--muted)"><?= esc($p['server_name'] ?? '—') ?></td>
                    <td>
                        <span class="badge badge-<?= esc($p['status'] ?? 'active') ?>">
                            <?= ucfirst(esc($p['status'] ?? 'active')) ?>
                        </span>
                    </td>
                    <td style="color:var(--muted);font-size:12px;white-space:nowrap">
                        <?= date('d M Y', strtotime($p['created_at'])) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<?php if ($pager->getPageCount() > 1): ?>
<div class="pagination">
    <?php
    $prevPage = $page - 1;
    $nextPage = $page + 1;
    $lastPage = $pager->getPageCount();

    $buildUrl = function(int $p) use ($currentUrl, $search): string {
        $params = ['page' => $p];
        if ($search !== '') $params['q'] = $search;
        return $currentUrl . '?' . http_build_query($params);
    };
    ?>

    <!-- Prev -->
    <?php if ($page > 1): ?>
        <a href="<?= $buildUrl($prevPage) ?>">‹</a>
    <?php else: ?>
        <span class="disabled">‹</span>
    <?php endif; ?>

    <!-- Page numbers -->
    <?php
    $range = 2;
    $start = max(1, $page - $range);
    $end   = min($lastPage, $page + $range);
    ?>

    <?php if ($start > 1): ?>
        <a href="<?= $buildUrl(1) ?>">1</a>
        <?php if ($start > 2): ?><span style="border:none;background:none">…</span><?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
        <?php if ($i === $page): ?>
            <span class="active"><?= $i ?></span>
        <?php else: ?>
            <a href="<?= $buildUrl($i) ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($end < $lastPage): ?>
        <?php if ($end < $lastPage - 1): ?><span style="border:none;background:none">…</span><?php endif; ?>
        <a href="<?= $buildUrl($lastPage) ?>"><?= $lastPage ?></a>
    <?php endif; ?>

    <!-- Next -->
    <?php if ($page < $lastPage): ?>
        <a href="<?= $buildUrl($nextPage) ?>">›</a>
    <?php else: ?>
        <span class="disabled">›</span>
    <?php endif; ?>
</div>
<p style="text-align:center;color:var(--muted);font-size:12px;margin-top:10px">
    Page <?= $page ?> of <?= $lastPage ?> &bull; <?= $total ?> total project<?= $total !== 1 ? 's' : '' ?>
</p>
<?php endif; ?>

<?php endif; ?>
