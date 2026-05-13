<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COBRA — Aventure</title>
    <link rel="stylesheet" href="style.css">

    <style>
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

        .grid-9x9 {
            display: grid;
            grid-template-columns: repeat(9, 45px);
            grid-template-rows: repeat(9, 45px);
            border: 3px solid #123d18;
            position: relative;
            z-index: 3;
        }

        .case {
            width: 45px;
            height: 45px;
            background-color: #b8f5b1;
            border: 1px solid #123d18;
        }

        .case:hover {
            background-color: #9fea96;
            cursor: pointer;
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
            0% {
                transform: rotate(-35deg) translate(0, 0);
            }
            50% {
                transform: rotate(-22deg) translate(8px, -6px);
            }
            100% {
                transform: rotate(-35deg) translate(0, 0);
            }
        }

        @keyframes leafMove2 {
            0% {
                transform: rotate(35deg) translate(0, 0);
            }
            50% {
                transform: rotate(22deg) translate(-8px, -6px);
            }
            100% {
                transform: rotate(35deg) translate(0, 0);
            }
        }

        @keyframes leafMove3 {
            0% {
                transform: rotate(-140deg) translate(0, 0);
            }
            50% {
                transform: rotate(-155deg) translate(7px, 6px);
            }
            100% {
                transform: rotate(-140deg) translate(0, 0);
            }
        }

        @keyframes leafMove4 {
            0% {
                transform: rotate(140deg) translate(0, 0);
            }
            50% {
                transform: rotate(155deg) translate(-7px, 6px);
            }
            100% {
                transform: rotate(140deg) translate(0, 0);
            }
        }

        @keyframes leafMove5 {
            0% {
                transform: rotate(-75deg) translate(0, 0);
            }
            50% {
                transform: rotate(-90deg) translate(-6px, 8px);
            }
            100% {
                transform: rotate(-75deg) translate(0, 0);
            }
        }

        @keyframes leafMove6 {
            0% {
                transform: rotate(75deg) translate(0, 0);
            }
            50% {
                transform: rotate(90deg) translate(6px, 8px);
            }
            100% {
                transform: rotate(75deg) translate(0, 0);
            }
        }

        @keyframes leafMove7 {
            0% {
                transform: rotate(-105deg) translate(0, 0);
            }
            50% {
                transform: rotate(-120deg) translate(-8px, -5px);
            }
            100% {
                transform: rotate(-105deg) translate(0, 0);
            }
        }

        @keyframes leafMove8 {
            0% {
                transform: rotate(105deg) translate(0, 0);
            }
            50% {
                transform: rotate(120deg) translate(8px, -5px);
            }
            100% {
                transform: rotate(105deg) translate(0, 0);
            }
        }
    </style>
</head>

<body>
    <div class="bg">
        <svg viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="400"  cy="900" rx="400" ry="70" fill="#163d1a" opacity="0.8"/>
            <ellipse cx="1050" cy="900" rx="500" ry="60" fill="#1a4a1e" opacity="0.7"/>
        </svg>
    </div>
    
    <a href="index.php" class="btn-back">← Accueil</a>

    <main class="page">
        <h1 class="logo">COBRA</h1>
        <p class="logo-sub">Mode Aventure</p>

        <section class="game-zone">
            <div class="jungle-frame">
                <span class="leaf leaf-1">🌿</span>
                <span class="leaf leaf-2">🌿</span>
                <span class="leaf leaf-3">🌿</span>
                <span class="leaf leaf-4">🌿</span>
                <span class="leaf leaf-5">🍃</span>
                <span class="leaf leaf-6">🍃</span>
                <span class="leaf leaf-7">🍃</span>
                <span class="leaf leaf-8">🍃</span>

                <div class="grid-9x9" id="grid"></div>
            </div>
        </section>
    </main>

    <script>
        const grid = document.getElementById("grid");

        for (let i = 0; i < 81; i++) {
            const cell = document.createElement("div");
            cell.classList.add("case");
            grid.appendChild(cell);
        }
    </script>
</body>
</html>
