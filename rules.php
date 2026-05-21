<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COBRA - Règles du Jeu</title>
  <link rel="icon" type="image/x-icon" href="../images/CobraTeams.ico">
  
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="rules.css">
</head>
<body>

<div class="bg">
  <svg viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
    <path d="M-20,900 Q60,500 200,560 Q100,700 -20,900Z" fill="#1e5523" opacity="0.9"/>
    <path d="M-30,750 Q50,420 170,480 Q80,600 -30,750Z" fill="#2d7a35" opacity="0.7"/>
    <path d="M0,600  Q80,350 200,420 Q120,520 0,600Z" fill="#225c28" opacity="0.6"/>
    <path d="M30,0  Q50,300 20,600" stroke="#2d7a35" stroke-width="4" fill="none" opacity="0.4"/>
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
  <a href="index.php" class="btn-back">← Retour</a>

  <h1 class="logo">RÈGLES</h1>

 <div class="rules-box">
  
  <section class="rules-section">
    <div class="rules-text">
      <h2><span>🗺️</span> Mode Aventure</h2>
      <p>Le mode de jeu classique où vous parcourez différents niveaux.</p>
    </div>
    <!-- animation du mode classique -->
    <div class="rules-visual visual-aventure">
      <div class="node active"></div>
      <div class="line"></div>
      <div class="node"></div>
      <div class="line"></div>
      <div class="node"></div>
    </div>
  </section>

  <!-- séparation entre les explications -->
  <div class="divider"></div>
  <!-- séparation entre les explications -->
  
  <section class="rules-section">
    <div class="rules-text">
      <h2><span>∞</span> Mode Infini</h2>
      <p>Dans le mode infini, les défis s'enchaînent sans fin ! Quel sera votre score ?</p>
    </div>
    <!-- animation du mode infini -->
    <div class="rules-visual visual-infini">
      <div class="loop"></div>
      <div class="core"></div>
    </div>
  </section>

  <div class="divider"></div>

  <section class="rules-section">
    <div class="rules-text">
      <h2><span>✏️</span> Le Concepteur</h2>
      <p>Un mode de jeu dans lequel vous pouvez créer vos propres niveaux.</p>
    </div>
    <!-- animation du mode concepteur -->
    <div class="rules-visual visual-concepteur">
      <div class="grid-preview">
        <div class="block"></div>
        <div class="block pencil-target"></div>
      </div>
      <span class="pencil">✏️</span>
    </div>
  </section>

  <div class="divider"></div>

  <section class="rules-section">
    <div class="rules-text">
      <h2 class="txt-brouillon"><span>🗑️</span> Mode Brouillon</h2>
      <p>Un espace de test sans contraintes où vous pouvez expérimenter vos idées.</p>
    </div>
    <!-- animation du mode brouillon -->
    <div class="rules-visual visual-brouillon">
      <div class="draft-box">
        <div class="cross"></div>
        <div class="cross c2"></div>
      </div>
    </div>
  </section>

</div>
</main>

</body>
</html>