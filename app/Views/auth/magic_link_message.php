<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Check Your Email — Smokey Cocktail</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@1,200;1,300&display=swap" rel="stylesheet">
  <style>
    * { font-family: 'Crimson Pro', serif; font-style: italic; }
    h1,h2,h3,h4,h5,h6 { font-family: 'Crimson Pro', serif; font-style: italic; color: #1B1C25; font-weight: normal; }
    body { background: #F9F9F9; color: #3a3a3a; min-height: 100vh; font-size: clamp(1rem, 2.5vw, 1.2rem); line-height: 1.9; }
    .btn-border { border:1px solid #006044; color:#006044; font-family:'Crimson Pro',serif; font-style:italic; font-size:clamp(.95rem,2vw,1.1rem); font-weight:600; padding:.6rem 1.5rem; display:inline-block; transition:all .2s; }
    .btn-border:hover { background:#006044; color:#fff; }
  </style>
</head>
<body>

<!-- Top bar -->
<div style="background:#2e4a3a;" class="text-white text-xs">
  <div class="max-w-7xl mx-auto px-4 py-2 flex justify-between items-center">
    <span class="hidden md:inline tracking-wide">Diamonds, Gemstones &amp; Jewellery — By Invitation Only</span>
    <a href="<?= site_url('/') ?>" class="text-white/80 hover:text-white" style="font-family:'Crimson Pro',serif; font-style:italic; font-size:.9rem;">← Back to Home</a>
  </div>
</div>

<!-- Header -->
<header class="bg-white border-b border-gray-100 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-center min-h-[60px] md:min-h-[72px]">
    <a href="<?= site_url('/') ?>">
      <img src="<?= base_url('public/uploads/logo.jpg') ?>" alt="Smokey Cocktail" class="h-10 md:h-14 w-auto object-contain mix-blend-multiply"/>
    </a>
  </div>
</header>

<!-- Message card -->
<div class="flex items-center justify-center px-4 py-10 md:py-16 min-h-[calc(100vh-120px)]">
  <div class="w-full max-w-md bg-white shadow-sm border border-gray-100 p-6 md:p-10 text-center">

    <div class="flex justify-center mb-5">
      <svg width="48" height="48" fill="none" stroke="#006044" stroke-width="1.3" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
    </div>

    <h1 class="font-bold mb-3" style="font-family:'Crimson Pro',serif; font-style:italic; font-size:clamp(1.8rem,5vw,2.5rem);"><?= lang('Auth.checkYourEmail') ?></h1>
    <p class="text-gray-500" style="font-size:clamp(.9rem,2vw,1.05rem);"><?= lang('Auth.magicLinkDetails', [setting('Auth.magicLinkLifetime') / 60]) ?></p>

    <div class="mt-7 pt-6 border-t border-gray-100">
      <a href="<?= url_to('login') ?>" class="btn-border">← Back to Login</a>
    </div>
  </div>
</div>

<!-- Footer -->
<footer style="background:#00192B;" class="text-white py-5 text-center text-xs text-white/50">
  © <?= date('Y') ?> Smokey Cocktail. All rights reserved.
</footer>

</body>
</html>
