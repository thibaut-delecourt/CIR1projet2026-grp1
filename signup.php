<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COBRA — Créer un compte</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Signup-specific: box a little taller, so allow more width */
    .form-box { max-width: 420px; }

    /* Password strength bar */
    .strength-bar {
      height: 4px;
      border-radius: 2px;
      background: rgba(255,255,255,0.08);
      margin-top: 8px;
      overflow: hidden;
    }
    .strength-fill {
      height: 100%;
      width: 0%;
      border-radius: 2px;
      transition: width 0.3s, background 0.3s;
    }
    .strength-label {
      font-size: 10px;
      letter-spacing: 0.1em;
      margin-top: 4px;
      color: rgba(255,255,255,0.3);
      text-transform: uppercase;
    }

    /* Terms checkbox */
    .check-row {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-top: 4px;
      margin-bottom: 4px;
    }
    .check-row input[type="checkbox"] {
      width: 18px;
      height: 18px;
      min-width: 18px;
      accent-color: #f5c842;
      margin-top: 2px;
      cursor: pointer;
    }
    .check-row label {
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 0;
      text-transform: none;
      color: rgba(255,255,255,0.4);
      cursor: pointer;
      line-height: 1.5;
    }
    .check-row label a { color: #a8d832; text-decoration: none; }
    .check-row label a:hover { color: #f5c842; }
  </style>
</head>
<body>

<div class="bg">
  <svg viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
    <path d="M-20,900 Q60,500 200,560 Q100,700 -20,900Z"  fill="#1e5523" opacity="0.9"/>
    <path d="M-30,750 Q50,420 170,480 Q80,600 -30,750Z"   fill="#2d7a35" opacity="0.7"/>
    <path d="M0,600  Q80,350 200,420 Q120,520 0,600Z"     fill="#225c28" opacity="0.6"/>
    <path d="M30,0  Q50,300 20,600"  stroke="#2d7a35" stroke-width="4" fill="none" opacity="0.4"/>
    <path d="M1460,900 Q1380,500 1240,560 Q1340,700 1460,900Z" fill="#1e5523" opacity="0.9"/>
    <path d="M1470,750 Q1390,420 1270,480 Q1360,600 1470,750Z" fill="#2d7a35" opacity="0.7"/>
    <path d="M1440,600 Q1360,350 1240,420 Q1320,520 1440,600Z" fill="#225c28" opacity="0.6"/>
    <path d="M1410,0 Q1390,300 1420,600" stroke="#2d7a35" stroke-width="4" fill="none" opacity="0.4"/>
    <ellipse cx="400"  cy="900" rx="400" ry="70" fill="#163d1a" opacity="0.8"/>
    <ellipse cx="1050" cy="900" rx="500" ry="60" fill="#1a4a1e" opacity="0.7"/>
  </svg>
</div>

<a href="login.html" class="btn-back">← Connexion</a>

<main class="page form-page">
  <div class="form-box">
    <div class="form-title">COBRA</div>
    <p class="form-hint">Rejoins l'aventure</p>

    <div class="field">
      <label for="username">Nom d'utilisateur</label>
      <input type="text" id="username" placeholder="Choisis ton nom de héros…" autocomplete="username"/>
    </div>

    <div class="field">
      <label for="email">Adresse e-mail</label>
      <input type="email" id="email" placeholder="ton@email.com" autocomplete="email"/>
    </div>

    <div class="field">
      <label for="password">Mot de passe</label>
      <input type="password" id="password" placeholder="••••••••" autocomplete="new-password" oninput="checkStrength(this.value)"/>
      <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
      <div class="strength-label" id="strengthLabel"></div>
    </div>

    <div class="field">
      <label for="confirm">Confirmer le mot de passe</label>
      <input type="password" id="confirm" placeholder="••••••••" autocomplete="new-password"/>
    </div>

    <div class="check-row">
      <input type="checkbox" id="terms"/>
      <label for="terms">J'accepte les <a href="#">conditions d'utilisation</a> et la <a href="#">politique de confidentialité</a></label>
    </div>

    <div class="divider">ou</div>

    <button class="btn-submit" onclick="handleSignup()">Créer mon compte</button>

    <p class="form-foot">
      Déjà un compte ? <a href="login.php">Se connecter</a>
    </p>
  </div>
</main>

<script>
  function checkStrength(val) {
    const fill  = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    let score = 0;
    if (val.length >= 8)            score++;
    if (/[A-Z]/.test(val))          score++;
    if (/[0-9]/.test(val))          score++;
    if (/[^A-Za-z0-9]/.test(val))   score++;

    const levels = [
      { pct: '0%',   color: 'transparent', text: '' },
      { pct: '25%',  color: '#e8312a',     text: 'Faible' },
      { pct: '50%',  color: '#f59e0b',     text: 'Moyen' },
      { pct: '75%',  color: '#a8d832',     text: 'Bon' },
      { pct: '100%', color: '#3daa47',     text: 'Fort' },
    ];
    const lvl = val.length === 0 ? levels[0] : levels[score];
    fill.style.width      = lvl.pct;
    fill.style.background = lvl.color;
    label.textContent     = lvl.text;
    label.style.color     = lvl.color;
  }

  function handleSignup() {
    const user    = document.getElementById('username').value.trim();
    const email   = document.getElementById('email').value.trim();
    const pass    = document.getElementById('password').value;
    const confirm = document.getElementById('confirm').value;
    const terms   = document.getElementById('terms').checked;

    if (!user || !email || !pass || !confirm) {
      alert('Remplis tous les champs.'); return;
    }
    if (pass !== confirm) {
      alert('Les mots de passe ne correspondent pas.'); return;
    }
    if (!terms) {
      alert('Accepte les conditions d\'utilisation.'); return;
    }
    // TODO: logique d'inscription
    console.log('[COBRA] Signup:', user, email);
  }
</script>

</body>
</html>
