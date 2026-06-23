<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account — Smokey Cocktail</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0;}
:root{
  --bg:#0a0808; --card:#141010; --border:#2a241c;
  --gold:#d4a849; --gold-neon:#ffd966;
  --text:#f0e8d4; --muted:#9a9080; --red:#e6504a;
}
@keyframes glow{0%,100%{text-shadow:0 0 15px rgba(255,217,102,.5),0 0 30px rgba(255,217,102,.3)}50%{text-shadow:0 0 25px rgba(255,217,102,.7),0 0 50px rgba(255,217,102,.4)}}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
@keyframes shimmer{0%{background-position:-200% center}100%{background-position:200% center}}
@keyframes fadeUp{0%{opacity:0;transform:translateY(20px)}100%{opacity:1;transform:translateY(0)}}

body{background:var(--bg);color:var(--text);font-family:'Inter',sans-serif;min-height:100vh;
  display:flex;align-items:center;justify-content:center;padding:1.5rem;overflow-x:hidden;position:relative;}

body::before{content:'';position:fixed;top:-200px;left:-200px;width:600px;height:600px;border-radius:50%;
  background:radial-gradient(circle,rgba(212,168,73,.15),transparent 70%);filter:blur(60px);pointer-events:none;animation:float 8s ease-in-out infinite;}
body::after{content:'';position:fixed;bottom:-200px;right:-200px;width:600px;height:600px;border-radius:50%;
  background:radial-gradient(circle,rgba(196,125,74,.1),transparent 70%);filter:blur(80px);pointer-events:none;animation:float 10s ease-in-out infinite reverse;}

input[type=email],input[type=password],input[type=text]{
  background:rgba(20,16,16,.6)!important;border:1px solid var(--border)!important;color:var(--text)!important;
  width:100%;padding:.85rem 1rem;border-radius:6px;font-size:.875rem;
  font-family:'Inter',sans-serif;transition:all .25s;}
input:focus{border-color:var(--gold-neon)!important;outline:none!important;
  box-shadow:0 0 0 3px rgba(255,217,102,.15)!important;background:rgba(20,16,16,.85)!important;}
input::placeholder{color:#5a544a;}

.btn-neon{background:linear-gradient(135deg,#d4a849,#ffd966,#d4a849);background-size:200% auto;
  color:#0a0808;font-weight:700;width:100%;padding:.95rem;border-radius:50px;
  font-size:.8rem;letter-spacing:.1em;text-transform:uppercase;cursor:pointer;border:none;
  animation:shimmer 4s linear infinite;box-shadow:0 4px 20px rgba(212,168,73,.4);transition:all .25s;}
.btn-neon:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(255,217,102,.6);}

.glow-text{text-shadow:0 0 20px rgba(255,217,102,.5);}
.font-serif{font-family:'Crimson Pro',serif;}

.float-icon{position:fixed;font-size:1.8rem;opacity:.3;filter:drop-shadow(0 0 12px rgba(255,217,102,.4));
  animation:float 6s ease-in-out infinite;pointer-events:none;}
</style>
</head>
<body>

<div class="float-icon" style="top:10%;left:8%;animation-delay:0s;"></div>
<div class="float-icon" style="top:18%;right:12%;animation-delay:1.5s;"></div>
<div class="float-icon" style="bottom:18%;left:15%;animation-delay:.8s;"></div>
<div class="float-icon" style="bottom:12%;right:8%;animation-delay:2.2s;"></div>

<div style="width:100%;max-width:460px;position:relative;animation:fadeUp .7s ease both;">
    <div style="text-align:center;margin-bottom:2.25rem;">
        <a href="<?= site_url('/') ?>" style="text-decoration:none;">
            <div style="display:inline-flex;align-items:center;gap:.625rem;">
                <span style="font-size:1.6rem;filter:drop-shadow(0 0 12px rgba(255,217,102,.5));"></span>
                <div class="font-serif" style="font-size:1.65rem;color:var(--text);font-weight:600;letter-spacing:.1em;">SMOKEY COCKTAIL</div>
            </div>
            <div style="font-size:.65rem;letter-spacing:.5em;color:var(--gold-neon);margin-top:.3rem;text-shadow:0 0 10px rgba(255,217,102,.4);">LET'S PARTY</div>
        </a>
    </div>

    <div style="background:linear-gradient(180deg,rgba(28,24,18,.6),rgba(20,16,16,.85));
                border:1px solid var(--border);border-radius:16px;padding:2.25rem 2rem;
                backdrop-filter:blur(20px);
                box-shadow:0 25px 50px rgba(0,0,0,.5),0 0 60px rgba(212,168,73,.08);">
        <h1 class="font-serif glow-text" style="font-size:1.6rem;color:var(--text);margin-bottom:.3rem;font-weight:500;">
            Create <em style="color:var(--gold-neon);font-style:italic;">Account</em>
        </h1>
        <p style="font-size:.825rem;color:var(--muted);margin-bottom:1.75rem;">Join us to start shopping</p>

        <?php if (session()->has('errors') && is_array(session('errors'))): ?>
        <div style="background:rgba(230,80,74,.1);border:1px solid rgba(230,80,74,.3);color:var(--red);
                    border-radius:6px;padding:.75rem 1rem;font-size:.825rem;margin-bottom:1.25rem;">
            <?php foreach ((array)session('errors') as $e): ?><div>• <?= esc($e) ?></div><?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form method="post" action="<?= url_to('register') ?>">
            <?= csrf_field() ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                <div>
                    <label style="display:block;font-size:.68rem;letter-spacing:.15em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;font-weight:600;">Username</label>
                    <input type="text" name="username" required value="<?= esc(old('username')) ?>" placeholder="username">
                </div>
                <div>
                    <label style="display:block;font-size:.68rem;letter-spacing:.15em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;font-weight:600;">Email *</label>
                    <input type="email" name="email" required value="<?= esc(old('email')) ?>" placeholder="you@example.com">
                </div>
            </div>
            <div style="margin-bottom:1rem;">
                <label style="display:block;font-size:.68rem;letter-spacing:.15em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;font-weight:600;">Password *</label>
                <input type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
            </div>
            <div style="margin-bottom:1.5rem;">
                <label style="display:block;font-size:.68rem;letter-spacing:.15em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;font-weight:600;">Confirm Password *</label>
                <input type="password" name="password_confirm" required autocomplete="new-password" placeholder="••••••••">
            </div>
            <button type="submit" class="btn-neon">Create Account →</button>
        </form>

        <div style="text-align:center;margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid rgba(212,168,73,.1);">
            <p style="font-size:.8rem;color:var(--muted);">
                Already have an account? <a href="<?= site_url('login') ?>" style="color:var(--gold-neon);text-decoration:none;font-weight:600;">Sign in →</a>
            </p>
        </div>
    </div>

    <p style="text-align:center;margin-top:1.25rem;">
        <a href="<?= site_url('/') ?>" style="font-size:.75rem;color:#5a544a;text-decoration:none;letter-spacing:.05em;transition:color .2s;"
           onmouseover="this.style.color='var(--gold-neon)'" onmouseout="this.style.color='#5a544a'">← Back to store</a>
    </p>
</div>
</body>
</html>
