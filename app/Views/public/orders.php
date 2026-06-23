<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div style="background:linear-gradient(180deg,var(--bg-soft) 0%,var(--bg) 100%);min-height:60vh;">
<div style="max-width:900px;margin:0 auto;padding:2.5rem 1.5rem;">

    <div style="margin-bottom:2rem;">
        <p style="font-size:.7rem;letter-spacing:.25em;text-transform:uppercase;color:var(--gold);margin-bottom:.5rem;font-weight:600;">Account</p>
        <h1 class="font-serif" style="font-size:clamp(1.8rem,4vw,2.5rem);font-weight:400;color:var(--text);">My <em style="color:var(--gold-neon);">Orders</em></h1>
        <div class="gold-line" style="margin:.75rem 0 0;"></div>
    </div>

    <?php if (empty($orders)): ?>
    <div style="text-align:center;padding:4rem 2rem;background:linear-gradient(180deg,rgba(28,24,18,.6),rgba(20,16,16,.85));border:1px solid var(--border);border-radius:12px;">
        <div style="font-size:3rem;opacity:.3;margin-bottom:1rem;">📦</div>
        <p class="font-serif" style="font-size:1.5rem;color:var(--muted);margin-bottom:.5rem;">No orders yet</p>
        <p style="font-size:.82rem;color:var(--dim);margin-bottom:1.5rem;">Discover our handcrafted cocktail essentials</p>
        <a href="<?= site_url('shop') ?>" class="btn-neon" style="padding:.8rem 2.5rem;font-size:.78rem;border-radius:50px;display:inline-block;">Start Shopping</a>
    </div>
    <?php else: ?>
    <div style="display:grid;gap:.875rem;">
        <?php foreach ($orders as $order): ?>
        <?php
        $statusColors = [
            'pending'    => ['bg'=>'rgba(212,168,73,.12)','border'=>'rgba(212,168,73,.35)','color'=>'var(--gold-neon)'],
            'confirmed'  => ['bg'=>'rgba(34,197,94,.1)', 'border'=>'rgba(34,197,94,.3)',   'color'=>'#22c55e'],
            'processing' => ['bg'=>'rgba(59,130,246,.1)','border'=>'rgba(59,130,246,.3)',   'color'=>'#3b82f6'],
            'shipped'    => ['bg'=>'rgba(139,92,246,.1)','border'=>'rgba(139,92,246,.3)',   'color'=>'#8b5cf6'],
            'delivered'  => ['bg'=>'rgba(16,185,129,.1)','border'=>'rgba(16,185,129,.3)',   'color'=>'#10b981'],
            'cancelled'  => ['bg'=>'rgba(230,80,74,.1)', 'border'=>'rgba(230,80,74,.3)',    'color'=>'var(--red)'],
        ];
        $sc = $statusColors[$order['status']] ?? $statusColors['pending'];
        ?>
        <a href="<?= site_url('orders/'.$order['id']) ?>"
           style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;
                  padding:1.25rem 1.5rem;text-decoration:none;
                  background:linear-gradient(180deg,rgba(28,24,18,.5),rgba(20,16,16,.7));
                  border:1px solid var(--border);border-radius:10px;transition:all .25s;"
           onmouseover="this.style.borderColor='rgba(212,168,73,.4)';this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 30px rgba(0,0,0,.4)'"
           onmouseout="this.style.borderColor='var(--border)';this.style.transform='';this.style.boxShadow=''">
            <div>
                <p style="font-weight:600;color:var(--text);font-size:.9rem;margin-bottom:.2rem;"><?= esc($order['order_number']) ?></p>
                <p style="font-size:.72rem;color:var(--muted);"><?= app_datetime($order['created_at']) ?></p>
            </div>
            <div style="text-align:right;">
                <p style="font-weight:700;color:var(--gold-neon);font-size:.95rem;margin-bottom:.35rem;"><?= money($order['total']) ?></p>
                <span style="font-size:.65rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;
                             padding:.25rem .7rem;border-radius:99px;
                             background:<?= $sc['bg'] ?>;border:1px solid <?= $sc['border'] ?>;color:<?= $sc['color'] ?>;">
                    <?= ucfirst($order['status']) ?>
                </span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>
</div>

<?= $this->endSection() ?>
