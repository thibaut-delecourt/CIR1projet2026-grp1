<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COBRA — Mode Infini</title> 
    <link rel="icon" type="image/x-icon" href="images\CobraLogo.png">
    <link rel="stylesheet" href="style.css">

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

        /* Brume légère animée */
        .jungle-mist {
            position: absolute;
            z-index: 2;
            width: 900px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(220, 255, 220, 0.20), transparent 70%);
            filter: blur(18px);
            opacity: 0.35;
        }

        .mist-1 {
            bottom: 80px;
            left: -250px;
            animation: mistMove1 18s linear infinite;
        }

        .mist-2 {
            bottom: 210px;
            right: -300px;
            animation: mistMove2 22s linear infinite;
        }

        @keyframes mistMove1 {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(600px);
            }
        }

        @keyframes mistMove2 {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-650px);
            }
        }

        /* Lucioles */
        .firefly {
            position: absolute;
            z-index: 3;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #fff6a8;
            box-shadow:
                0 0 8px #fff6a8,
                0 0 18px #f5d76e,
                0 0 28px #c9ff7a;
            opacity: 0.8;
        }

        .firefly-1 {
            top: 25%;
            left: 18%;
            animation: fireflyMove1 7s ease-in-out infinite;
        }

        .firefly-2 {
            top: 42%;
            left: 78%;
            animation: fireflyMove2 8s ease-in-out infinite;
        }

        .firefly-3 {
            top: 65%;
            left: 35%;
            animation: fireflyMove3 9s ease-in-out infinite;
        }

        .firefly-4 {
            top: 18%;
            left: 60%;
            animation: fireflyMove4 6.5s ease-in-out infinite;
        }

        .firefly-5 {
            top: 72%;
            left: 82%;
            animation: fireflyMove5 8.5s ease-in-out infinite;
        }

        .firefly-6 {
            top: 50%;
            left: 10%;
            animation: fireflyMove6 7.5s ease-in-out infinite;
        }

        @keyframes fireflyMove1 {
            0% { transform: translate(0, 0); opacity: 0.2; }
            50% { transform: translate(45px, -35px); opacity: 1; }
            100% { transform: translate(0, 0); opacity: 0.2; }
        }

        @keyframes fireflyMove2 {
            0% { transform: translate(0, 0); opacity: 0.3; }
            50% { transform: translate(-50px, 30px); opacity: 1; }
            100% { transform: translate(0, 0); opacity: 0.3; }
        }

        @keyframes fireflyMove3 {
            0% { transform: translate(0, 0); opacity: 0.4; }
            50% { transform: translate(35px, 40px); opacity: 1; }
            100% { transform: translate(0, 0); opacity: 0.4; }
        }

        @keyframes fireflyMove4 {
            0% { transform: translate(0, 0); opacity: 0.25; }
            50% { transform: translate(-30px, -45px); opacity: 1; }
            100% { transform: translate(0, 0); opacity: 0.25; }
        }

        @keyframes fireflyMove5 {
            0% { transform: translate(0, 0); opacity: 0.2; }
            50% { transform: translate(-60px, -20px); opacity: 1; }
            100% { transform: translate(0, 0); opacity: 0.2; }
        }

        @keyframes fireflyMove6 {
            0% { transform: translate(0, 0); opacity: 0.3; }
            50% { transform: translate(55px, 25px); opacity: 1; }
            100% { transform: translate(0, 0); opacity: 0.3; }
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
    <main class="page">
        <h1 class="logo">COBRA</h1>
        <p class="logo-sub">Mode Infini</p>
    </main>

</body>

</html>