<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">

    <!-- Success animation -->
    <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center" style="background:rgba(201,168,76,.15);border:2px solid rgba(201,168,76,.4);">
        <svg class="w-10 h-10" style="color:#c9a84c;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
    </div>

    <p class="text-xs tracking-widest uppercase mb-3" style="color:#c9a84c;">Order Placed!</p>
    <h1 class="font-serif text-4xl font-bold mb-4" style="color:#e8e0d0;">Thank You!</h1>
    <div class="smoke-divider mb-6"></div>
    <p class="text-sm leading-relaxed mb-8" style="color:#8a8a7a;">
        Your order <strong style="color:#c9a84c;"><?= esc($order['order_number']) ?></strong> has been placed.
        Our team will reach out to you at <strong style="color:#c0b898;"><?= esc($order['customer_email']) ?></strong>
        to confirm and arrange delivery.
    </p>

    <?php if (!empty($order['items'])): ?>
    <div class="rounded-lg p-6 mb-8 text-left" style="background:#1a1a1a;border:1px solid #2a2a2a;">
        <h2 class="font-serif text-lg font-semibold mb-4" style="color:#e8e0d0;">Order Summary</h2>
        <div class="space-y-3">
            <?php foreach ($order['items'] as $item): ?>
            <div class="flex justify-between text-sm">
                <span style="color:#8a8a7a;"><?= esc($item['title']) ?> × <?= $item['quantity'] ?></span>
                <span style="color:#c9a84c;"><?= money($item['subtotal']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="border-t mt-4 pt-4 flex justify-between font-semibold" style="border-color:#2a2a2a;">
            <span style="color:#e8e0d0;">Total</span>
            <span style="color:#c9a84c;"><?= money($order['total']) ?></span>
        </div>
    </div>
    <?php endif; ?>

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="<?= site_url('orders') ?>" class="btn-outline px-8 py-3 rounded text-sm tracking-wider uppercase inline-block">
            View My Orders
        </a>
        <a href="<?= site_url('shop') ?>" class="btn-gold px-8 py-3 rounded text-sm tracking-wider uppercase inline-block">
            Continue Shopping
        </a>
    </div>
</div>

<?= $this->endSection() ?>
