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
            background-color: #b8f5b1;
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
        
        .case.selected {
    background-color: #f5d76e;
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

                <div class="puzzle-grid" id="grid"></div>
            </div>
        </section>
    </main>

    <script>
        const grid = document.getElementById("grid");

        const rowNumbers = [1, 6, 1, 4, 3, 4, 3, 4, 7];
        const colNumbers = [6, 4, 4, 3, 3, 7, 1, 4, 1];

        for (let row = 0; row < 9; row++) {
            for (let col = 0; col < 9; col++) {
                const cell = document.createElement("div");
                cell.classList.add("case");

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
        cells.forEach((cell) => {
            cell.addEventListener("click", () => {
                if (!cell.classList.contains("fixed")) {
                    cell.classList.toggle("selected");
                    
                }
                let row_count=parcour_ligne()
                for(let i=0;i<9;i++){
                    if(row_count[i]>rowNumbers[i]){
                        document.querySelectorAll(".row-number")[i].style.color = '#ff0000'
                    }
                    else{
                        document.querySelectorAll(".row-number")[i].style.color = '#f5d76e'
                    }
                }
                let col_count=parcour_col()
                for(let i=0;i<9;i++){
                    if(col_count[i]>colNumbers[i]){
                        document.querySelectorAll(".col-number")[i].style.color = '#ff0000'
                    }
                    else{
                        document.querySelectorAll(".col-number")[i].style.color = '#f5d76e'
                    }
                }
            });
        });

        function parcour_ligne(){
            const tab_row = document.querySelectorAll(".row-number")
            const tab = document.querySelectorAll(".case")
            console.log(tab)
            let valid = true
            let tab_count = []
            let i = 0
            while (i < 9){
                let count = 0
                for(let j = 0; j<9; j++){
                    if(tab[i*9+j].classList.contains("selected") || tab[i*9+ j].classList.contains("fixed")){
                        count += 1
                    }
                }

                if (count != parseInt(tab_row[i].textContent)){
                    valid = false
                }
                tab_count.push(count)
                i++
            }
            return tab_count
        }

        function parcour_col(){
            const tab_row = document.querySelectorAll(".col-number")
            const tab = document.querySelectorAll(".case")
            let valid = true
            let tab_count = []
            let i = 0
            while (i < 9){
                let count = 0
                for(let j = 0; j<9; j++){
                    if(tab[j*9+i].classList.contains("selected") || tab[i*9+ j].classList.contains("fixed")){
                        count += 1
                    }
                }

                if (count != parseInt(tab_row[i].textContent)){
                    valid = false
                }
                tab_count.push(count)
                i++
            }
            return tab_count
        }
        
        
        console.log(row_count)
    </script>
</body>
</html>