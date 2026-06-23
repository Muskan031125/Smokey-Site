<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <a href="<?= site_url('orders') ?>" class="text-xs hover:opacity-80 mb-4 inline-block" style="color:#6b6b6b;">← Back to Orders</a>
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="font-serif text-3xl font-bold" style="color:#e8e0d0;"><?= esc($order['order_number']) ?></h1>
                <p class="text-sm mt-1" style="color:#6b6b6b;"><?= app_datetime($order['created_at']) ?></p>
            </div>
            <?php
            $statusColors = [
                'pending'    => 'rgba(201,168,76,.15)|rgba(201,168,76,.4)|#c9a84c',
                'confirmed'  => 'rgba(34,197,94,.1)|rgba(34,197,94,.3)|#22c55e',
                'processing' => 'rgba(59,130,246,.1)|rgba(59,130,246,.3)|#3b82f6',
                'shipped'    => 'rgba(139,92,246,.1)|rgba(139,92,246,.3)|#8b5cf6',
                'delivered'  => 'rgba(16,185,129,.1)|rgba(16,185,129,.3)|#10b981',
                'cancelled'  => 'rgba(239,68,68,.1)|rgba(239,68,68,.3)|#ef4444',
            ];
            [$sbg, $sborder, $scolor] = explode('|', $statusColors[$order['status']] ?? $statusColors['pending']);
            ?>
            <span class="px-4 py-2 rounded text-sm font-semibold" style="background:<?= $sbg ?>;border:1px solid <?= $sborder ?>;color:<?= $scolor ?>;">
                <?= ucfirst($order['status']) ?>
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Delivery info -->
        <div class="rounded-lg p-5" style="background:#1a1a1a;border:1px solid #2a2a2a;">
            <h2 class="font-serif text-base font-semibold mb-4" style="color:#e8e0d0;">Delivery Details</h2>
            <div class="space-y-1 text-sm" style="color:#8a8a7a;">
                <p class="font-medium" style="color:#c0b898;"><?= esc($order['customer_name']) ?></p>
                <p><?= esc($order['customer_email']) ?></p>
                <p><?= esc($order['customer_phone']) ?></p>
                <p class="mt-2"><?= esc($order['address_line1']) ?></p>
                <?php if ($order['address_line2']): ?><p><?= esc($order['address_line2']) ?></p><?php endif; ?>
                <p><?= esc($order['city']) ?>, <?= esc($order['state']) ?> — <?= esc($order['pincode']) ?></p>
            </div>
        </div>

        <!-- Order summary -->
        <div class="rounded-lg p-5" style="background:#1a1a1a;border:1px solid #2a2a2a;">
            <h2 class="font-serif text-base font-semibold mb-4" style="color:#e8e0d0;">Order Total</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span style="color:#6b6b6b;">Subtotal</span>
                    <span style="color:#c0b898;"><?= money($order['subtotal']) ?></span>
                </div>
                <div class="flex justify-between font-bold border-t pt-2" style="border-color:#2a2a2a;">
                    <span style="color:#e8e0d0;">Total</span>
                    <span style="color:#c9a84c;"><?= money($order['total']) ?></span>
                </div>
            </div>
            <?php if ($order['notes']): ?>
            <div class="mt-4 pt-4 border-t text-sm" style="border-color:#2a2a2a;color:#6b6b6b;">
                <p class="font-medium mb-1" style="color:#8a8a7a;">Notes:</p>
                <p><?= esc($order['notes']) ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Items -->
    <div class="rounded-lg overflow-hidden" style="background:#1a1a1a;border:1px solid #2a2a2a;">
        <div class="p-5 border-b" style="border-color:#2a2a2a;">
            <h2 class="font-serif text-base font-semibold" style="color:#e8e0d0;">Items Ordered</h2>
        </div>
        <div class="divide-y" style="--tw-divide-color:#2a2a2a;">
            <?php foreach ($order['items'] as $item): ?>
            <div class="flex gap-4 p-5">
                <div class="w-16 h-16 rounded overflow-hidden flex-shrink-0" style="background:#111;">
                    <?php if ($item['cover_image']): ?>
                    <img src="<?= media_url($item['cover_image']) ?>" alt="" class="w-full h-full object-cover">
                    <?php endif; ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium mb-1" style="color:#e8e0d0;"><?= esc($item['title']) ?></p>
                    <?php if ($item['sku']): ?><p class="text-xs" style="color:#555;">SKU: <?= esc($item['sku']) ?></p><?php endif; ?>
                    <p class="text-xs" style="color:#6b6b6b;"><?= money($item['price']) ?> × <?= $item['quantity'] ?></p>
                </div>
                <div class="font-semibold text-sm flex-shrink-0" style="color:#c9a84c;"><?= money($item['subtotal']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
