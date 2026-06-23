<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;">
    <div>
        <h1 style="color:#e8e0d0;font-size:1.1rem;font-weight:600;margin:0;">Preview Import</h1>
        <p style="color:#555;font-size:.75rem;margin:.2rem 0 0;">First 10 rows shown. Confirm to import entire file.</p>
    </div>
    <a href="<?= site_url('admin/bulk-import') ?>" class="btn-outline btn-sm">← Back</a>
</div>

<div style="padding:1.25rem 1.5rem;">
    <div class="card" style="overflow-x:auto;margin-bottom:1.5rem;">
        <table style="white-space:nowrap;">
            <thead><tr><?php foreach ($headers as $h): ?><th><?= esc($h) ?></th><?php endforeach; ?></tr></thead>
            <tbody>
            <?php foreach ($rows as $row): ?>
            <tr><?php foreach ($headers as $h): ?><td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;"><?= esc(mb_substr($row[$h] ?? '', 0, 60)) ?></td><?php endforeach; ?></tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <form method="post" action="<?= site_url('admin/bulk-import/import') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="tmp_file" value="<?= esc($tmpFile) ?>">
        <div style="display:flex;gap:.75rem;">
            <button type="submit" class="btn-gold">Confirm Import</button>
            <a href="<?= site_url('admin/bulk-import') ?>" class="btn-outline">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
