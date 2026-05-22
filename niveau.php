  <!DOCTYPE html> 
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COBRA — Niveau</title>
    <link rel="stylesheet" href="style.css?v=2">

  <style>
        body {
            overflow-x: hidden;
        }

        .bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
            background: radial-gradient(circle at top, #123d18 0%, #061b0d 60%, #020802 100%);
        }

        .bg svg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .page {
            position: relative;
            z-index: 5;
        }

        .btn-back {
            position: fixed;
            top: 26px;
            left: 26px;
            z-index: 2000;
            pointer-events: auto;
        }

        .game-zone {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .jungle-frame {
            position: relative;
            padding: 32px;
            border-radius: 18px;
            background: rgba(12, 55, 20, 0.55);
            border: 3px solid #245c28;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.45);
            overflow: visible;
        }

        .jungle-frame::before {
            content: "";
            position: absolute;
            inset: -18px;
            border-radius: 25px;
            border: 6px solid rgba(68, 140, 50, 0.85);
            pointer-events: none;
        }

        .puzzle-grid {
            display: grid;
            grid-template-columns: repeat(9, 45px) 30px;
            grid-template-rows: repeat(9, 45px) 30px;
            position: relative;
            z-index: 3;
        }

        .case {
            width: 45px;
            height: 45px;
            background-color: #1b4d21;
            border: 1px solid #123d18;
        }

        .case.fixed {
            background-color: #4f4f4f;
        }

        .case:hover {
            background-color: #9fea96;
            cursor: pointer;
        }

        .case.fixed:hover {
            background-color: #4f4f4f;
            cursor: default;
        }

        .case.selected {
            background-color: #f5d76e;
        }
        .case.brouillon {
            background-color: #ae9e9e;
        }

        .case.erreur {
            background-color : #ff0000;
        }
        .row-number {
            width: 30px;
            height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #f5d76e;
            font-size: 20px;
            font-weight: bold;
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.7);
        }

        .col-number {
            width: 45px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #f5d76e;
            font-size: 20px;
            font-weight: bold;
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.7);
        }

        .leaf {
            position: absolute;
            font-size: 38px;
            z-index: 4;
            user-select: none;
            pointer-events: none;
            filter: drop-shadow(0 3px 3px rgba(0, 0, 0, 0.45));
        }

        .leaf-1 {
            top: -35px;
            left: -25px;
            animation: leafMove1 3.5s ease-in-out infinite;
        }

        .leaf-2 {
            top: -38px;
            right: -25px;
            animation: leafMove2 4s ease-in-out infinite;
        }

        .leaf-3 {
            bottom: -35px;
            left: -25px;
            animation: leafMove3 3.8s ease-in-out infinite;
        }

        .leaf-4 {
            bottom: -38px;
            right: -25px;
            animation: leafMove4 4.2s ease-in-out infinite;
        }

        .leaf-5 {
            top: 35%;
            left: -45px;
            animation: leafMove5 3.2s ease-in-out infinite;
        }

        .leaf-6 {
            top: 35%;
            right: -45px;
            animation: leafMove6 3.6s ease-in-out infinite;
        }

        .leaf-7 {
            top: 52%;
            left: -48px;
            animation: leafMove7 4.4s ease-in-out infinite;
        }

        .leaf-8 {
            top: 52%;
            right: -48px;
            animation: leafMove8 4.1s ease-in-out infinite;
        }

        @keyframes leafMove1 {
            0% { transform: rotate(-35deg) translate(0, 0); }
            50% { transform: rotate(-22deg) translate(8px, -6px); }
            100% { transform: rotate(-35deg) translate(0, 0); }
        }

        @keyframes leafMove2 {
            0% { transform: rotate(35deg) translate(0, 0); }
            50% { transform: rotate(22deg) translate(-8px, -6px); }
            100% { transform: rotate(35deg) translate(0, 0); }
        }

        @keyframes leafMove3 {
            0% { transform: rotate(-140deg) translate(0, 0); }
            50% { transform: rotate(-155deg) translate(7px, 6px); }
            100% { transform: rotate(-140deg) translate(0, 0); }
        }

        @keyframes leafMove4 {
            0% { transform: rotate(140deg) translate(0, 0); }
            50% { transform: rotate(155deg) translate(-7px, 6px); }
            100% { transform: rotate(140deg) translate(0, 0); }
        }

        @keyframes leafMove5 {
            0% { transform: rotate(-75deg) translate(0, 0); }
            50% { transform: rotate(-90deg) translate(-6px, 8px); }
            100% { transform: rotate(-75deg) translate(0, 0); }
        }

        @keyframes leafMove6 {
            0% { transform: rotate(75deg) translate(0, 0); }
            50% { transform: rotate(90deg) translate(6px, 8px); }
            100% { transform: rotate(75deg) translate(0, 0); }
        }

        @keyframes leafMove7 {
            0% { transform: rotate(-105deg) translate(0, 0); }
            50% { transform: rotate(-120deg) translate(-8px, -5px); }
            100% { transform: rotate(-105deg) translate(0, 0); }
        }

        @keyframes leafMove8 {
            0% { transform: rotate(105deg) translate(0, 0); }
            50% { transform: rotate(120deg) translate(8px, -5px); }
            100% { transform: rotate(105deg) translate(0, 0); }
        }

        .victory-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.72);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .victory-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .victory-box {
            position: relative;
            padding: 45px 65px;
            border-radius: 28px;
            background: linear-gradient(135deg, #123d18, #1f7a2e, #f5d76e);
            border: 4px solid #f5d76e;
            box-shadow:
                0 0 25px rgba(245, 215, 110, 0.9),
                0 0 60px rgba(31, 122, 46, 0.9);
            text-align: center;
            animation: victoryPop 0.8s ease forwards, victoryGlow 1.8s ease-in-out infinite;
        }

        .victory-title {
            font-size: 64px;
            font-weight: 900;
            letter-spacing: 6px;
            color: #fff6b0;
            text-shadow:
                0 0 8px #f5d76e,
                0 0 18px #f5d76e,
                0 0 35px #1bff5a;
            animation: victoryText 1.2s ease-in-out infinite;
        }

        .victory-subtitle {
            margin-top: 14px;
            font-size: 20px;
            color: white;
            font-weight: bold;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
        }

        .victory-countdown {
            margin-top: 12px;
            font-size: 17px;
            color: #fff6b0;
            font-weight: bold;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
        }

        .victory-button {
            margin-top: 28px;
            padding: 12px 28px;
            border: none;
            border-radius: 999px;
            background: #f5d76e;
            color: #123d18;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 6px 0 #b99b32;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .victory-button:hover {
            transform: translateY(3px);
            box-shadow: 0 3px 0 #b99b32;
        }

        .confetti {
            position: fixed;
            top: -20px;
            width: 12px;
            height: 18px;
            z-index: 1000;
            animation: confettiFall linear forwards;
        }

        @keyframes victoryPop {
            0% {
                transform: scale(0.3) rotate(-8deg);
                opacity: 0;
            }

            70% {
                transform: scale(1.08) rotate(2deg);
                opacity: 1;
            }

            100% {
                transform: scale(1) rotate(0);
                opacity: 1;
            }
        }

        @keyframes victoryGlow {
            0% {
                box-shadow:
                    0 0 25px rgba(245, 215, 110, 0.8),
                    0 0 60px rgba(31, 122, 46, 0.8);
            }

            50% {
                box-shadow:
                    0 0 45px rgba(245, 215, 110, 1),
                    0 0 90px rgba(31, 255, 90, 1);
            }

            100% {
                box-shadow:
                    0 0 25px rgba(245, 215, 110, 0.8),
                    0 0 60px rgba(31, 122, 46, 0.8);
            }
        }

        @keyframes victoryText {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes confettiFall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(110vh) rotate(720deg);
                opacity: 0;
            }
        }
        .cards-vertical {
    flex-direction: column;
    align-items: center;
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

     <div class="cards-vertical">
    <a href="aventure_1.php" class="card card-aventure">
      <span class="niveau">Niveau 1</span>
      <span class="logo-sub">Pour bien commencer</span>
    </a>
  <a href="aventure_2.php" class="card card-aventure">
      <span class="niveau">Niveau 2</span>
      <span class="logo-sub">Le premier défi</span>
  </a>
  <a href="aventure_3.php" class="card card-aventure">
      <span class="niveau">Niveau 3</span>
      <span class="logo-sub">Ne vous mordez pas la queue</span>
  </a>
  <a href="aventure_4.php" class="card card-aventure">
      <span class="niveau">Niveau 4</span>
      <span class="logo-sub">Un serpent ne recule jamais</span>
  </a>
  <a href="aventure_5.php" class="card card-aventure">
      <span class="niveau">Niveau 5</span>
      <span class="logo-sub">L'aigle est l'ennemi des serpents</span>
  </a>
    <a href="aventure_6.php" class="card card-aventure">
      <span class="niveau">Niveau 6</span>
      <span class="logo-sub">Tout les serpents ne sont pas venimeux</span>
  </a>
 <a href="aventure_7.php" class="card card-aventure">
      <span class="niveau">Niveau 7</span>
      <span class="logo-sub">Muer comme un serpent</span>
  </a>
<a href="aventure_8.php" class="card card-aventure">
      <span class="niveau">Niveau 8</span>
      <span class="logo-sub">Les serpents glissent vers leurs objectifs</span>
  </a>

  <a href="aventure_9.php" class="card card-aventure">
      <span class="niveau">Niveau 9</span>
      <span class="logo-sub">Le serpent perd en appetit avec l'age</span>
  </a>
  <a href="aventure_10.php" class="card card-aventure">
      <span class="niveau">Niveau 10</span>
      <span class="logo-sub">Le chemin du serpent</span>
  </a>

  
