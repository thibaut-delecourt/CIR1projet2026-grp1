<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COBRA - Draft Rules of the Game</title>
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

<main class="page">
  <a href="index.php" class="btn-back">← Back</a>

  <h1 class="logo">RULES</h1>
  <p class="logo-sub">
    And an introduction to the
    different game modes
  </p>

 <div class="rules-box">

 <section class="rules-section logic rules">
    <div class="rules-text" style="max-width: 100%;">
      <h2><span>🐍</span> The snake (Snake / Tunnel)</h2>
      <p class="intro">
        The <strong>Snake</strong> is a logic puzzle played on a grid of squares.
        The goal is to draw a snake, connecting its head to its tail, without any lines or 
        columns of its body touching (this also applies diagonally). 
      </p>

      <div class="divider" style="marginn: 15px 0;"></div>

      <h3>How to play ?</h3>
      <ul style="list-style-type: none; padding-left: 0; margin-bottom: 20px;">
        <li style="margin-bottom: 12px; position: relative; padding-left: 24px; color: #fdf6e3;">
          <span style="position: absolute; left: 0; color: #a8d832;">■</span>
          <strong>Departure and Arrival :</strong> The two squares initially marked/greyed out on the grid represent the head and tail of the snake.
        </li>
        <li style="margin-bottom: 12px; position: relative; padding-left: 24px; color: #fdf6e3;">
          <span style="position: absolute; left: 0; color: #a8d832;">■</span>
          <strong>The Serpent's Body :</strong> You must form a continuous line (a path of black squares) that connects these two ends.
        </li>
        <li style="margin-bottom: 12px; position: relative; padding-left: 24px; color: #fdf6e3;">
          <span style="position: absolute; left: 0; color: #a8d832;">■</span>
          <strong>Numerical Indices:</strong> The numbers located outside (bottom and right of the grid) indicate the exact number of squares that must be blackened in the corresponding row or column.
        </li>
        <li style="margin-bottom: 12px; position: relative; padding-left: 24px; color: #fdf6e3;">
          <span style="position: absolute; left: 0; color: #a8d832;">■</span>
          <strong>No touching :</strong> The black line of the snake can <strong>never cross</strong> or touch itself, not even diagonally through the corner of a square. Each black square on the path must only touch its neighbors on the snake by its sides (top, bottom, left, right).
        </li>
      </ul>
      <div style="background: rgba(0, 0, 0, 0.3); border-left: 4px solid #3daa47; border-radius: 6px; padding: 15px; margin-top: 15px;">
        <p style="margin: 0; color: #8dff9c; font-style: italic; font-size: 14px;">
          💡 <strong>Trick:</strong> Use the largest or smallest clues (like 1 or numbers close to the maximum grid size) to start deducing the location of the squares!
        </p>
      </div>
    </div>
  </section>

  <div class="divider" style="margin: 30px 0; border-bottom: 2px dashed rgba(255,255,255,0.1);"></div>
  
  <section class="rules-section">
    <div class="rules-text">
      <h2><span>🗺️</span>Adventure Mode</h2>
      <p>The classic game mode where you progress through different levels.</p>
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
      <h2><span>∞</span>Infinity Mode</h2>
      <p>In endless mode, the challenges keep coming! What will your score be?</p>
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
      <h2><span>✏️</span> The Designer</h2>
      <p>A game mode in which you can create your own levels.</p>
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
      <h2 class="txt-brouillon"><span>🗑️</span>Draft Mode</h2>
      <p>A testing space without constraints where you can experiment with your ideas.</p>
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