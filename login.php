<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COBRA — Login</title>
  <link rel="stylesheet" href="style.css?v=2">
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

  <a href="index.php" class="btn-back">← Home</a>

  <main class="page form-page">
    <div class="form-box">
    <div class="form-title">COBRA</div>
    <p class="form-hint">Welcome, adventurer</p>

    <form name="connexion" method="post" action="php/connecter.php">

      <div class="field">
        <label for="email">E-mail address</label>
        <input type="text" id="email" name="email" placeholder="ton@email.com" required pattern=".*@.*"/>
      </div>

      <div class="field">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required/>
      </div>


      <input Type="submit" name="se_connecter" value="Login" class="btn-submit">

    </form>

      <p class="form-foot">
        Don't have an account yet? <a href="signup.php">Create an account</a>
      </p>
    </div>
  
  </main>

</body>
</html>
