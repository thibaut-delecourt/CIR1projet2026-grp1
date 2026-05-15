<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COBRA</title>
     <link rel="icon" type="image/x-icon" href="../images/CobraTeams.ico">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="bg">
  <svg viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
    <path d="M-20,900 Q60,500 200,560 Q100,700 -20,900Z"  fill="#1e5523" opacity="0.9"/>
    <path d="M-30,750 Q50,420 170,480 Q80,600 -30,750Z"   fill="#2d7a35" opacity="0.7"/>
    <path d="M0,600  Q80,350 200,420 Q120,520 0,600Z"     fill="#225c28" opacity="0.6"/>
    <path d="M30,0  Q50,300 20,600"  stroke="#2d7a35" stroke-width="4" fill="none" opacity="0.4"/>
    <path d="M100,0 Q80,250 110,550" stroke="#1e5523" stroke-width="3" fill="none" opacity="0.3"/>
    <path d="M1460,900 Q1380,500 1240,560 Q1340,700 1460,900Z" fill="#1e5523" opacity="0.9"/>
    <path d="M1470,750 Q1390,420 1270,480 Q1360,600 1470,750Z" fill="#2d7a35" opacity="0.7"/>
    <path d="M1440,600 Q1360,350 1240,420 Q1320,520 1440,600Z" fill="#225c28" opacity="0.6"/>
    <path d="M1410,0 Q1390,300 1420,600" stroke="#2d7a35" stroke-width="4" fill="none" opacity="0.4"/>
    <path d="M1340,0 Q1360,250 1330,550" stroke="#1e5523" stroke-width="3" fill="none" opacity="0.3"/>
    <ellipse cx="400"  cy="900" rx="400" ry="70" fill="#163d1a" opacity="0.8"/>
    <ellipse cx="1050" cy="900" rx="500" ry="60" fill="#1a4a1e" opacity="0.7"/>
  </svg>
</div>

<main class="page">
  <h1 class="logo">COBRA</h1>
  <p class="logo-sub">Le jeu de l'éveil</p>


<?php
if(isset($_SESSION['email'])){
  echo'<a href="php/deconnexion.php" class="btn-connect">Déconnexion</a>';
}
else{
  echo'<a href="login.php" class="btn-connect">Connexion</a>';
}
?>

  <div class="cards">
    <a href="aventure.php" class="card card-aventure">
      <span class="card-icon">🗺️</span>
      <span class="card-label">Aventure</span>
    </a>
    <a href="infini.php" class="card card-infini">
      <span class="card-icon">∞</span>
      <span class="card-label">Infini</span>
    </a>
    <a href="concepteur.php" class="card card-concepteur">
      <span class="card-icon">✏️</span>
      <span class="card-label">Concepteur</span>
    </a>
  </div>
</main>


</body>
</html>
