<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COBRA — Créer un compte</title>
  <link rel="stylesheet" href="style.css?v=2">
  <style>
    
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

  <div class="jungle-effects">
    <div class="jungle-mist mist-1"></div>
    <div class="jungle-mist mist-2"></div>

    <div class="fireflies">
      <span class="niveaufly firefly-1"></span>
      <span class="niveaufly firefly-2"></span>
      <span class="niveaufly firefly-3"></span>
      <span class="niveaufly firefly-4"></span>
      <span class="niveaufly firefly-5"></span>
      <span class="niveaufly firefly-6"></span>
    </div>
  </div>

  <a href="login.php" class="btn-back">← Connexion</a>
  

  <main class="page form-page">
    <div class="form-box">
      <div class="form-title">COBRA</div>
      <p class="form-hint">Rejoins l'aventure</p>

      <form method="post" action="php/ajout.php">

      <div class="field">
        <label for="email">Adresse e-mail</label>
        <input type="text" id="email" name="email" placeholder="ton@email.com" required pattern=".*@.*"/>
      </div>

      <div class="field">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required/>
      </div>

      <div class="check-row">
        <input type="checkbox" id="terms" required/>
        <label for="terms">J'accepte les <a href="#">conditions d'utilisation</a> et la <a href="#">politique de confidentialité</a></label>
      </div>

      <input Type="submit" name="creer_mon_compte" value="Creer mon compte" class="btn-submit">

    </form>


      <p class="form-foot">
        Déjà un compte ? <a href="login.php">Se connecter</a>
      </p>
    </div>
  </main>

</body>
</html>
