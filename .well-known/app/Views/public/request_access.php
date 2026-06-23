<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<section class="py-16 md:py-24" style="background:#F9F9F9;">
  <div class="max-w-3xl mx-auto px-4 md:px-6 w-full">
    <div class="text-center mb-10">
      <p class="text-xs uppercase tracking-[0.3em] mb-3" style="color:#006044; font-family:'Crimson Pro',serif; font-style:italic; font-style:italic;">By Invitation</p>
      <h1 class="text-4xl md:text-5xl font-bold" style="font-family:'Crimson Pro',serif; font-style:italic; font-style:italic;">Request Access</h1>
      <p class="text-gray-500 mt-4 max-w-xl mx-auto text-sm">Our team reviews every request personally. Please share a few details so we can respond appropriately.</p>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="border px-6 py-4 mb-6 text-sm" style="background:#e6f4ef; border-color:#006044; color:#006044;">
        <?= esc(session()->getFlashdata('success')) ?>
      </div>
    <?php endif; ?>

    <?php if ($errors = session()->getFlashdata('errors')): ?>
      <div class="bg-red-50 border border-red-300 text-red-700 px-6 py-4 mb-6 text-sm">
        <ul class="list-disc list-inside">
          <?php foreach ((array) $errors as $err): ?>
            <li><?= esc($err) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('request-access') ?>" class="bg-white p-5 md:p-10 shadow-sm border border-gray-100 space-y-5">
      <?= csrf_field() ?>

      <div>
        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Full Name *</label>
        <input type="text" name="name" required value="<?= esc(old('name')) ?>" class="w-full border border-gray-200 px-4 py-3 text-gray-800 focus:outline-none focus:border-green-700"/>
      </div>
      <div>
        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Email *</label>
        <input type="email" name="email" required value="<?= esc(old('email')) ?>" class="w-full border border-gray-200 px-4 py-3 text-gray-800 focus:outline-none focus:border-green-700"/>
      </div>
      <div>
        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Phone *</label>
        <input type="tel" name="phone" required value="<?= esc(old('phone')) ?>" class="w-full border border-gray-200 px-4 py-3 text-gray-800 focus:outline-none focus:border-green-700" placeholder="+91 98765 43210"/>
      </div>

      <div class="pt-2">
        <button type="submit" class="w-full py-4 font-bold text-white transition" style="background:#006044; font-family:'Crimson Pro',serif; font-style:italic; font-size:clamp(1rem,3vw,1.3rem); letter-spacing:0; text-transform:none;" onmouseover="this.style.background='#004d36'" onmouseout="this.style.background='#006044'">
          Submit Request
        </button>
        <p class="text-xs text-gray-400 text-center mt-4">We will respond to your request within 2 business days.</p>
      </div>
    </form>
  </div>
</section>

<?= $this->endSection() ?>
