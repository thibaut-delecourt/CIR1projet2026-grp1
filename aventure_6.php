<!DOCTYPE html> 
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COBRA — Aventure</title>
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

    <a href="niveau.php" class="btn-back">← Adventure Home</a>

    <main class="page">
        <h1 class="logo">COBRA</h1>
        <p class="logo-sub">Adventure Mode - Level 6</p>

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

                <div class="puzzle-grid" id="grid"></div>
            </div>
        </section>
    </main>

    <div class="victory-overlay" id="victoryOverlay">
        <div class="victory-box">
            <div class="victory-title">Victory</div>
            <div class="victory-subtitle">Le serpent relie bien la queue à la tête !</div>
            <div class="victory-countdown" id="victoryCountdown">
                Réinitialisation automatique dans 15 secondes.
            </div>
            <button class="victory-button" onclick="location.reload()">Rejouer</button>
            <button class="victory-button" onclick="location.href='niveau.php';">Retour aux niveaux</button>
        </div>
    </div>

    <script>
        const grid = document.getElementById("grid");

        const rowNumbers = [1, 6, 1, 4, 3, 4, 3, 4, 7];
        const colNumbers = [6, 4, 4, 3, 3, 7, 1, 4, 1];

        let victoireDejaAffichee = false;
        let countdownInterval = null;

        for (let row = 0; row < 9; row++) {
            for (let col = 0; col < 9; col++) {
                const cell = document.createElement("div");
                cell.classList.add("case");
                cell.classList.add(`${row}`);
                cell.classList.add(`${col}`);
                if ((row === 0 && col === 0) || (row === 8 && col === 8)) {
                    cell.classList.add("fixed");
                }

                grid.appendChild(cell);
            }

            const rowNumber = document.createElement("div");
            rowNumber.classList.add("row-number");
            rowNumber.textContent = rowNumbers[row];
            grid.appendChild(rowNumber);
        }

        for (let col = 0; col < 9; col++) {
            const colNumber = document.createElement("div");
            colNumber.classList.add("col-number");
            colNumber.textContent = colNumbers[col];
            grid.appendChild(colNumber);
        }

        const cells = document.querySelectorAll(".case");
        let prev_2 = [-1, -1]
        let prev_1 = [0, 0]
        let tab = [prev_2,prev_1]
        let tab_cell = document.querySelectorAll(".case");
        let tab_2 = Array.from({ length: 9 }, (_, i) =>
            Array.from({ length: 9 }, (_, j) => tab_cell[i * 9 + j]));
        let case_fausse = [0]
            cells.forEach((cell) => {
            cell.addEventListener("click", () => {
                let x = parseInt(cell.classList[1], 10)
                let y = parseInt(cell.classList[2], 10)
                if(isNaN(y)){
                    y = x
                }
                if (!cell.classList.contains("fixed") && verif_voisin(x, y)) {
                    cell.classList.toggle("selected");
                    if(case_fausse.length == 2){
                        tab_2[case_fausse[0]][case_fausse[1]].classList.remove("erreur")
                        case_fausse = NaN
                    }
                    if(cell.classList.contains("selected")){
                        let v_case = verif_case(x, y, tab.at(-1), tab.at(-2))
                        if(!verif_clic(x, y, tab.at(-1))){
                            cell.classList.toggle("selected");
                        }
                        else if (!v_case){
                            case_fausse = [x,y]
                            cell.classList.toggle("selected")
                            cell.classList.add("erreur")
                        }
                        else{
                            tab.push([x,y])
                        } 
                    }
                    else{
                        while((tab.at(-1)[0] != x) || (tab.at(-1)[1] != y)){
                            let val = tab.pop()
                            tab_2[val[0]][val[1]].classList.remove("selected")
                        }
                        let val = tab.pop()
                        tab_2[val[0]][val[1]].classList.remove("selected")
                    }

                    let row_count = parcour_ligne();
                    let correct_row=0

                    for (let i = 0; i < 9; i++) {
                        if (row_count[i] > rowNumbers[i]) {
                             document.querySelectorAll(".row-number")[i].style.color = "#ff0000";
                        } 
                        else if(row_count[i] == rowNumbers[i]){
                            correct_row++
                            document.querySelectorAll(".row-number")[i].style.color = "#f5d76e";
                        }
                        else {
                            document.querySelectorAll(".row-number")[i].style.color = "#f5d76e";
                        }
                    }

                    let col_count = parcour_col();
                    let correct_col=0
                    for (let i = 0; i < 9; i++) {
                        if (col_count[i] > colNumbers[i]) {
                            document.querySelectorAll(".col-number")[i].style.color = "#ff0000";
                        } 
                        else if(col_count[i] == colNumbers[i]){
                            correct_col++
                            document.querySelectorAll(".col-number")[i].style.color = "#f5d76e";
                        }
                        else {
                            document.querySelectorAll(".col-number")[i].style.color = "#f5d76e";
                        }
                    }
                    if(correct_col==9 && correct_row==9){
                        afficherVictoire()
                    }
                }
            });
        });
        cells.forEach((cell) => {
            cell.addEventListener('contextmenu', (event) => {
                event.preventDefault();
                if (!cell.classList.contains("fixed")) {
                    cell.classList.toggle("brouillon");
                }
            })
        })

        function parcour_ligne() {
            const tab = document.querySelectorAll(".case");
            let tab_count = [];

            for (let i = 0; i < 9; i++) {
                let count = 0;

                for (let j = 0; j < 9; j++) {
                    if (
                        tab[i * 9 + j].classList.contains("selected") ||
                        tab[i * 9 + j].classList.contains("fixed")
                    ) {
                        count += 1;
                    }
                }

                tab_count.push(count);
            }

            return tab_count;
        }

        function parcour_col() {
            const tab = document.querySelectorAll(".case");
            let tab_count = [];

            for (let i = 0; i < 9; i++) {
                let count = 0;

                for (let j = 0; j < 9; j++) {
                    if (
                        tab[j * 9 + i].classList.contains("selected") ||
                        tab[j * 9 + i].classList.contains("fixed")
                    ) {
                        count += 1;
                    }
                }

                tab_count.push(count);
            }

            return tab_count;
        }


        function verif_case(x, y, prev_1, prev_2) {
            const tab = document.querySelectorAll(".case");
            const tab_2 = Array.from({ length: 9 }, (_, i) =>
                Array.from({ length: 9 }, (_, j) => tab[i * 9 + j])
            );

            const voisins = [
                [x-1, y-1], [x-1, y], [x-1, y+1],
                [x,   y-1],            [x,   y+1],
                [x+1, y-1], [x+1, y], [x+1, y+1]
            ];
            let bool = false

            for (const [ni, nj] of voisins) {
                // Hors grille → on ignore
                if (ni < 0 || ni >= 9 || nj < 0 || nj >= 9) continue;
                
                const voisin     = tab_2[ni][nj];
                const occupe     = voisin.classList.contains("selected") || voisin.classList.contains("fixed");
                const estPrev1   = ni === prev_1[0] && nj === prev_1[1];
                const estPrev2   = ni === prev_2[0] && nj === prev_2[1];
                const estFin = ni === 8 && nj === 8;

                if (occupe && !estPrev1 && !estPrev2 && !estFin) {
                    return false;
                }
            }
            return true
       
        }

        function verif_voisin(x, y){
            const tab = document.querySelectorAll(".case");
            const tab_2 = Array.from({ length: 9 }, (_, i) =>
                Array.from({ length: 9 }, (_, j) => tab[i * 9 + j])
            );

            const voisins = [
                [x-1, y], [x, y-1], [x, y+1], [x+1, y]
            ];
            let count = 0
            for (const [ni, nj] of voisins) {
                // Hors grille → on ignore
                if (ni < 0 || ni >= 9 || nj < 0 || nj >= 9) continue;
                
                const voisin     = tab_2[ni][nj];
                const occupe     = voisin.classList.contains("selected") || voisin.classList.contains("fixed");
                
                if (occupe) {
                    count ++
                }
            }
            if (count == 0){
                return false
            }
            return true
        }
        function verif_clic(x, y, prev_1){
           const voisins = [
                [x-1, y], [x, y-1], [x, y+1], [x+1, y]
            ];
            for (let i = 0; i< 4;i++) {
                if (voisins[i][0] == prev_1[0] && voisins[i][1] == prev_1[1]) {
                    return true;
                }
            }       
            return false;
        }

        function afficherVictoire() {
            if (victoireDejaAffichee) {
                return;
            }

            victoireDejaAffichee = true;

            const victoryOverlay = document.getElementById("victoryOverlay");
            victoryOverlay.classList.add("show");

            lancerConfettis();
            lancerCompteARebours();
        }

        function lancerCompteARebours() {
            const countdownElement = document.getElementById("victoryCountdown");
            let secondes = 15;

            countdownElement.textContent = "Réinitialisation automatique dans " + secondes + " secondes.";

            countdownInterval = setInterval(() => {
                secondes--;

                if (secondes > 1) {
                    countdownElement.textContent = "Réinitialisation automatique dans " + secondes + " secondes.";
                } else if (secondes === 1) {
                    countdownElement.textContent = "Réinitialisation automatique dans 1 seconde.";
                } else {
                    clearInterval(countdownInterval);
                    location.reload();
                }
            }, 1000);
        }

        function lancerConfettis() {
            const couleurs = ["#f5d76e", "#1bff5a", "#ffffff", "#9fea96", "#ffdd57"];

            for (let i = 0; i < 90; i++) {
                const confetti = document.createElement("div");
                confetti.classList.add("confetti");

                confetti.style.left = Math.random() * 100 + "vw";
                confetti.style.backgroundColor = couleurs[Math.floor(Math.random() * couleurs.length)];
                confetti.style.animationDuration = 2.5 + Math.random() * 2.5 + "s";
                confetti.style.animationDelay = Math.random() * 0.6 + "s";
                confetti.style.transform = "rotate(" + Math.random() * 360 + "deg)";

                document.body.appendChild(confetti);

                setTimeout(() => {
                    confetti.remove();
                }, 5500);
            }
        }
    </script>
</body>
</html>