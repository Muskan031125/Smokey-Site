<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1 style="color:#e8e0d0;font-size:1.1rem;font-weight:600;margin:0;">Bulk Import</h1>
    <p style="color:#555;font-size:.75rem;margin:.2rem 0 0;">Upload a CSV to import products in bulk</p>
</div>

<div style="padding:1.25rem 1.5rem;max-width:640px;">
    <div class="card" style="padding:1.5rem;margin-bottom:1.25rem;">
        <h2 style="color:#e8e0d0;font-size:.9rem;font-weight:600;margin:0 0 .75rem;">Upload CSV or ZIP File</h2>
        <p style="color:#666;font-size:.8rem;margin:0 0 1rem;">Upload a <strong style="color:#c0b898;">.csv</strong> or a <strong style="color:#c0b898;">.zip</strong> containing a CSV (e.g. Shopify export). First row must be headers. Required column: <strong style="color:#c0b898;">title</strong>.</p>
        <form method="post" action="<?= site_url('admin/bulk-import/preview') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div style="margin-bottom:1rem;">
                <input type="file" name="csv_file" accept=".csv,.txt,.zip" required style="width:100%;padding:.6rem;cursor:pointer;">
            </div>
            <div style="display:flex;gap:.75rem;">
                <button type="submit" class="btn-gold">Preview & Import</button>
                <a href="<?= site_url('admin/bulk-import/template') ?>" class="btn-outline">Download Template</a>
            </div>
        </form>
    </div>

    <div class="card" style="padding:1.25rem;">
        <h2 style="color:#e8e0d0;font-size:.85rem;font-weight:600;margin:0 0 .75rem;">Supported Columns</h2>
        <table>
            <thead><tr><th>Column</th><th>Required</th><th>Notes</th></tr></thead>
            <tbody>
            <?php foreach ([
                ['title',         'Yes', 'Product name'],
                ['handle',        'No',  'URL slug — auto-generated from title if blank'],
                ['category',      'No',  'Category name — created automatically if new'],
                ['vendor',        'No',  'Brand name'],
                ['sku',           'No',  'Stock keeping unit'],
                ['price',         'No',  'Selling price in ₹'],
                ['compare_price', 'No',  'Original / strikethrough price'],
                ['cost_price',    'No',  'Your cost (admin-only)'],
                ['inventory_qty', 'No',  'Stock quantity'],
                ['description',   'No',  'HTML or plain text description'],
                ['tags',          'No',  'Comma-separated tags'],
            ] as [$col, $req, $note]): ?>
            <tr>
                <td style="color:#c0b898;font-family:monospace;font-size:.8rem;"><?= $col ?></td>
                <td style="color:<?= $req === 'Yes' ? '#c9a84c' : '#555' ?>;font-size:.75rem;"><?= $req ?></td>
                <td style="color:#666;font-size:.75rem;"><?= $note ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
