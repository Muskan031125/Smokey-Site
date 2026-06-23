<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reset Password — Smokey Cocktail</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@400;600&family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
body{background:#0a0808;color:#f0e8d4;font-family:'Inter',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1rem;}
input{background:#141010!important;border:1px solid #2a241c!important;color:#f0e8d4!important;width:100%;padding:.75rem 1rem;border-radius:6px;font-size:.875rem;}
input:focus{border-color:#d4a849!important;outline:none!important;box-shadow:0 0 0 3px rgba(212,168,73,.15)!important;}
.btn{background:linear-gradient(135deg,#d4a849,#ffd966);color:#0a0808;font-weight:700;width:100%;padding:.85rem;border-radius:6px;font-size:.85rem;letter-spacing:.08em;text-transform:uppercase;cursor:pointer;border:none;}
</style>
</head>
<body>
<div style="width:100%;max-width:420px;">
    <div style="text-align:center;margin-bottom:2rem;">
        <a href="<?= site_url('/') ?>" style="text-decoration:none;">
            <div style="font-family:'Crimson Pro',serif;font-size:1.6rem;color:#f0e8d4;font-weight:600;letter-spacing:.1em;">SMOKEY COCKTAIL</div>
            <div style="font-size:.65rem;letter-spacing:.4em;color:#ffd966;">LET'S PARTY</div>
        </a>
    </div>
    <div style="background:#141010;border:1px solid #2a241c;border-radius:12px;padding:2rem;">
        <h1 style="font-family:'Crimson Pro',serif;font-size:1.4rem;color:#f0e8d4;margin-bottom:.25rem;">Forgot Password?</h1>
        <p style="font-size:.825rem;color:#9a9080;margin-bottom:1.5rem;">Enter your email and we'll send you a magic link to sign in.</p>
        <?php if (session()->has('error')): ?>
        <div style="background:rgba(230,80,74,.1);border:1px solid rgba(230,80,74,.3);color:#e6504a;padding:.75rem 1rem;border-radius:5px;margin-bottom:1rem;font-size:.85rem;"><?= esc(session('error')) ?></div>
        <?php endif; ?>
        <form action="<?= url_to('magic-link') ?>" method="post">
            <?= csrf_field() ?>
            <div style="margin-bottom:1.25rem;">
                <label style="font-size:.7rem;letter-spacing:.15em;text-transform:uppercase;color:#9a9080;display:block;margin-bottom:.5rem;font-weight:600;">Email</label>
                <input type="email" name="email" required autocomplete="email">
            </div>
            <button type="submit" class="btn">Send Magic Link</button>
        </form>
        <p style="text-align:center;font-size:.75rem;color:#9a9080;margin-top:1.5rem;">
            <a href="<?= site_url('login') ?>" style="color:#ffd966;text-decoration:none;">← Back to Login</a>
        </p>
    </div>
</div>
</body>
</html>
