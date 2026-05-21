<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COBRA — Touches</title>
  <link rel="stylesheet" href="style.css?v=2">
  <style>
.touches-grid {
  display: flex;
  flex-direction: column;
  gap: 24px;
  margin-top: 28px;
  width: 100%;
}

.touche-row {
  display: flex;
  align-items: center;
  gap: 30px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 16px;
  padding: 28px 30px;
}

/* --- Souris --- */
.touche-visuel {
  flex-shrink: 0;
  width: 80px;
  height: 120px;
}

.mouse-body {
  width: 80px;
  height: 120px;
  border: 3px solid rgba(255,255,255,0.35);
  border-radius: 40px 40px 26px 26px;
  position: relative;
  overflow: hidden;
  background: rgba(255,255,255,0.04);
}

.mouse-left, .mouse-right {
  position: absolute;
  top: 0;
  width: 50%;
  height: 42%;
  border-bottom: 1px solid rgba(255,255,255,0.2);
}

.mouse-left {
  left: 0;
  border-right: 1px solid rgba(255,255,255,0.2);
  border-radius: 40px 0 0 0;
}

.mouse-right {
  right: 0;
  border-radius: 0 40px 0 0;
}

.mouse-left.active {
  background: rgba(45, 122, 53, 0.85);
}

.mouse-right.active {
  background: rgba(200, 100, 30, 0.85);
}

.mouse-wheel {
  position: absolute;
  top: 18px;
  left: 50%;
  transform: translateX(-50%);
  width: 7px;
  height: 18px;
  background: rgba(255,255,255,0.3);
  border-radius: 4px;
  z-index: 2;
}

/* --- Description --- */
.touche-desc {
  display: flex;
  flex-direction: column;
  gap: 4px;
  flex: 1;
}

.touche-action {
  font-size: 22px;
  font-weight: 700;
  color: #fff;
}

.touche-detail {
  font-size: 15px;
  color: rgba(255,255,255,0.55);
  margin-top: 4px;
}

/* --- Badges sans contour ni ovale --- */
.badge-mode {
  font-size: 16px;
  font-weight: 700;
  flex-shrink: 0;
  border: none;
  background: none;
  padding: 0;
}

.badge-normal {
  color: #7ed47f;
}

.badge-brouillon {
  color: #f0a86a;
}

/* --- Label section --- */
.section-label {
  font-size: 13px;
  text-transform: uppercase;
  letter-spacing: 3px;
  color: rgba(255,255,255,0.35);
  margin-top: 10px;
  margin-bottom: -4px;
}

/* --- Box --- */
.form-box {
  width: 750px;
  max-width: 95vw;
  padding: 50px 60px;
}
    
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
          <span class="firefly firefly-1"></span>
          <span class="firefly firefly-2"></span>
          <span class="firefly firefly-3"></span>
          <span class="firefly firefly-4"></span>
          <span class="firefly firefly-5"></span>
          <span class="firefly firefly-6"></span>
      </div>
  </div>

  <a href="index.php" class="btn-back">← Accueil</a>

  <main class="page form-page">
    <div class="form-box">
      <div class="form-title">COBRA</div>
      <p class="form-hint">Comment jouer ?</p>

      <div class="touches-grid">

        <p class="section-label">🖱️ Souris</p>

      <!-- Clic gauche -->
<div class="touche-row">
  <div class="touche-visuel">
    <div class="mouse-body">
      <div class="mouse-left active"></div>
      <div class="mouse-right"></div>
      <div class="mouse-wheel"></div>
    </div>
  </div>
  <div class="touche-desc">
    <span class="touche-action">Clic gauche</span>
    <span class="touche-detail">Sélectionner / désélectionner une case</span>
  </div>
  <span class="badge-mode badge-normal">Normal</span>
</div>

<!-- Clic droit -->
<div class="touche-row">
  <div class="touche-visuel">
    <div class="mouse-body">
      <div class="mouse-left"></div>
      <div class="mouse-right active"></div>
      <div class="mouse-wheel"></div>
    </div>
  </div>
  <div class="touche-desc">
    <span class="touche-action">Clic droit</span>
    <span class="touche-detail">Colorier une case en mode brouillon</span>
  </div>
  <span class="badge-mode badge-brouillon">Brouillon</span>
</div>
      </div>
    </div>
  </main>

</body>
</html>