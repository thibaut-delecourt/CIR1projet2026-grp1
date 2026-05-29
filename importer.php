<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COBRA - Import a level</title>
    <link rel="icon" type="image/x-icon" href="images/CobraLogo.png">
    <link rel="stylesheet" href="style.css?v=2">

    <style>
        body { overflow-x: hidden; }
        .bg { position: fixed; inset: 0; z-index: 0; overflow: hidden;
              pointer-events: none;
              background: radial-gradient(circle at top, #123d18 0%, #061b0d 60%, #020802 100%); }
        .bg svg { position: absolute; inset: 0; width: 100%; height: 100%; z-index: 1; }
        .page { position: relative; z-index: 5; }
        .btn-back { position: fixed; top: 26px; left: 26px; z-index: 2000; pointer-events: auto; }

        .import-bar {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin: 20px auto;
            max-width: 700px;
            padding: 0 12px;
            flex-wrap: wrap;
        }
        .import-bar input {
            flex: 1;
            min-width: 260px;
            padding: 10px 14px;
            border-radius: 8px;
            border: 2px solid #f5d76e;
            background: #0c2f10;
            color: #f5d76e;
            font-size: 14px;
            font-family: monospace;
        }
        .import-bar button {
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            background: #f5d76e;
            color: #123d18;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }
        .import-bar button:hover { background: #ffe89a; }
        .import-bar button.secondary {
            background: #1f7a2e;
            color: #fff6b0;
            border: 2px solid #f5d76e;
        }

        .info { color:#fdf6e3; text-align:center; margin: 8px 0 18px; }
        .info.error { color:#ff9090; }

        .game-zone { margin-top: 20px; display: flex; justify-content: center; align-items: center; }
        .jungle-frame { position: relative; padding: 32px; border-radius: 18px;
            background: rgba(12, 55, 20, 0.55); border: 3px solid #245c28;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.45); overflow: visible; }
        .jungle-frame::before { content:""; position:absolute; inset:-18px;
            border-radius:25px; border:6px solid rgba(68,140,50,0.85); pointer-events:none; }

        .puzzle-grid { display:grid;
            grid-template-columns: repeat(9, 45px) 30px;
            grid-template-rows: repeat(9, 45px) 30px;
            position:relative; z-index:3; }

        .case { width:45px; height:45px; background-color:#1b4d21; border:1px solid #123d18; }
        .case.fixed { background-color:#4f4f4f; }
        .case:hover { background-color:#9fea96; cursor:pointer; }
        .case.fixed:hover { background-color:#4f4f4f; cursor:default; }
        .case.selected { background-color:#f5d76e; }
        .case.brouillon { background-color:#ae9e9e; }
        .case.erreur { background-color:#ff0000; }
        .case.hint { outline:3px solid #7fd1ff; outline-offset:-3px; }
        .row-number, .col-number { display:flex; justify-content:center; align-items:center;
            color:#f5d76e; font-size:20px; font-weight:bold;
            text-shadow:0 2px 3px rgba(0,0,0,0.7); }
        .row-number { width:30px; height:45px; }
        .col-number { width:45px; height:30px; }

        .victory-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.72);
            display:flex; justify-content:center; align-items:center; z-index:999;
            opacity:0; visibility:hidden; transition: opacity .5s, visibility .5s; }
        .victory-overlay.show { opacity:1; visibility:visible; }
        .victory-box { padding:45px 65px; border-radius:28px;
            background: linear-gradient(135deg, #123d18, #1f7a2e, #f5d76e);
            border:4px solid #f5d76e; text-align:center;
            box-shadow:0 0 25px rgba(245,215,110,.9), 0 0 60px rgba(31,122,46,.9); }
        .victory-title { font-size:48px; font-weight:900; letter-spacing:6px; color:#fff6b0;
            text-shadow:0 0 8px #f5d76e, 0 0 18px #f5d76e, 0 0 35px #1bff5a; }
        .victory-button { margin-top:20px; padding:12px 28px; border:none; border-radius:999px;
            background:#f5d76e; color:#123d18; font-size:18px; font-weight:bold;
            cursor:pointer; box-shadow:0 6px 0 #b99b32; }
    </style>
</head>

<body>
    <div class="bg">
        <svg viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <path d="M-20,900 Q60,500 200,560 Q100,700 -20,900Z"  fill="#1e5523" opacity="0.9"/>
            <path d="M-30,750 Q50,420 170,480 Q80,600 -30,750Z"   fill="#2d7a35" opacity="0.7"/>
            <path d="M0,600  Q80,350 200,420 Q120,520 0,600Z"     fill="#225c28" opacity="0.6"/>
            <path d="M1460,900 Q1380,500 1240,560 Q1340,700 1460,900Z" fill="#1e5523" opacity="0.9"/>
            <path d="M1470,750 Q1390,420 1270,480 Q1360,600 1470,750Z" fill="#2d7a35" opacity="0.7"/>
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

    <a href="index.php" class="btn-back">&larr; Home</a>

    <main class="page">
        <h1 class="logo">COBRA</h1>
        <p class="logo-sub">Import a shared level</p>

        <div class="import-bar">
            <input id="import-input" type="text"
                   placeholder="Paste the link here (ex: http://localhost/jouer.php?lignes=...&colonnes=...)">
            <button onclick="importerNiveau()">Import</button>
            <button class="secondary" onclick="reinitialiser()">Reset</button>
            <button class="secondary" onclick="montrerSolution()" title="Affiche la solution calcul&eacute;e par le solveur C">Solution</button>
        </div>

        <div class="info" id="info">
            Paste a shared link from Infinite mode or the Designer, then click "Import"
        </div>

        <section class="game-zone">
            <div class="jungle-frame">
                <div class="puzzle-grid" id="grid"></div>
            </div>
        </section>
    </main>

    <div class="victory-overlay" id="victoryOverlay">
        <div class="victory-box">
            <div class="victory-title">VICTORY</div>
            <p style="color:white; font-size:18px; margin-top:14px;">
                The snake connects its tail to its head perfectly!
            </p>
            <button class="victory-button" onclick="reinitialiser()">Replay</button>
            <button class="victory-button" onclick="location.href='index.php';">Home</button>
        </div>
    </div>

<script>
/* ===================================================================
 *  COBRA - Importer un niveau
 *  Lit un lien (format produit par concepteur.php / infini.php) :
 *     /jouer.php?lignes=1,2,...&colonnes=2,5,...&chemin=0-0,1-0,...
 *  et lance le jeu avec les CONDITIONS DE VICTOIRE STRICTES de aventure_1.php
 *  (correct_row == 9 ET correct_col == 9).
 * =================================================================== */

let rowNumbers = [null,null,null,null,null,null,null,null,null];
let colNumbers = [null,null,null,null,null,null,null,null,null];
let victoireDejaAffichee = false;
let niveauImporte = false;

/* Au chargement on construit la grille avec des "?" partout : le joueur
 * voit le terrain mais ne peut pas gagner tant qu'il n'a pas importe. */
construireGrille();

function importerNiveau() {
    const txt = document.getElementById("import-input").value.trim();
    const info = document.getElementById("info");
    info.classList.remove("error");

    if (!txt) {
        info.textContent = "Aucun lien colle.";
        info.classList.add("error");
        return;
    }

    let url;
    try {
        url = new URL(txt);
    } catch (e) {
        info.textContent = "Lien invalide : " + e.message;
        info.classList.add("error");
        return;
    }

    const lignes   = url.searchParams.get("lignes");
    const colonnes = url.searchParams.get("colonnes");
    if (!lignes || !colonnes) {
        info.textContent = "Le lien doit contenir au moins ?lignes=...&colonnes=...";
        info.classList.add("error");
        return;
    }

    const arrR = lignes.split(",").map(Number);
    const arrC = colonnes.split(",").map(Number);
    if (arrR.length !== 9 || arrC.length !== 9 || arrR.some(isNaN) || arrC.some(isNaN)) {
        info.textContent = "Les listes lignes/colonnes doivent contenir 9 entiers chacune.";
        info.classList.add("error");
        return;
    }
    const sumR = arrR.reduce((a,b)=>a+b,0);
    const sumC = arrC.reduce((a,b)=>a+b,0);
    if (sumR !== sumC) {
        info.textContent = "Somme des lignes (" + sumR + ") differente de la somme des colonnes (" + sumC + ").";
        info.classList.add("error");
        return;
    }

    rowNumbers = arrR;
    colNumbers = arrC;
    niveauImporte = true;
    victoireDejaAffichee = false;
    document.getElementById("victoryOverlay").classList.remove("show");
    construireGrille();
    info.textContent = "Level matters successfully (length " + sumR + " boxes). Good luck !";
}

function reinitialiser() {
    victoireDejaAffichee = false;
    document.getElementById("victoryOverlay").classList.remove("show");
    construireGrille();
}

/* ---------------------------------------------------------------------
 *  Construction de la grille + clics
 *  -- gameplay strictement identique a aventure_1.php
 * --------------------------------------------------------------------- */
function construireGrille() {
    const grid = document.getElementById("grid");
    grid.innerHTML = "";

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
        rowNumber.textContent = (rowNumbers[row] === null) ? "?" : rowNumbers[row];
        grid.appendChild(rowNumber);
    }
    for (let col = 0; col < 9; col++) {
        const colNumber = document.createElement("div");
        colNumber.classList.add("col-number");
        colNumber.textContent = (colNumbers[col] === null) ? "?" : colNumbers[col];
        grid.appendChild(colNumber);
    }

    /* -- LOGIQUE DE CLIC : copie carbone de aventure_1.php -- */
    const cells = document.querySelectorAll(".case");
    let prev_2 = [-1, -1];
    let prev_1 = [0, 0];
    let tab = [prev_2, prev_1];
    let tab_cell = document.querySelectorAll(".case");
    let tab_2 = Array.from({ length: 9 }, (_, i) =>
        Array.from({ length: 9 }, (_, j) => tab_cell[i * 9 + j]));
    let case_fausse = [0];

    cells.forEach((cell) => {
        cell.addEventListener("click", () => {
            let x = parseInt(cell.classList[1], 10);
            let y = parseInt(cell.classList[2], 10);
            if (isNaN(y)) { y = x; }
            if (!cell.classList.contains("fixed") && verif_voisin(x, y)) {
                cell.classList.toggle("selected");
                if (case_fausse.length == 2) {
                    tab_2[case_fausse[0]][case_fausse[1]].classList.remove("erreur");
                    case_fausse = NaN;
                }
                if (cell.classList.contains("selected")) {
                    let v_case = verif_case(x, y, tab.at(-1), tab.at(-2));
                    if (!verif_clic(x, y, tab.at(-1))) {
                        cell.classList.toggle("selected");
                    } else if (!v_case) {
                        case_fausse = [x, y];
                        cell.classList.toggle("selected");
                        cell.classList.add("erreur");
                    } else {
                        tab.push([x, y]);
                    }
                } else {
                    while ((tab.at(-1)[0] != x) || (tab.at(-1)[1] != y)) {
                        let val = tab.pop();
                        tab_2[val[0]][val[1]].classList.remove("selected");
                    }
                    let val = tab.pop();
                    tab_2[val[0]][val[1]].classList.remove("selected");
                }

                /* MAJ des indices lignes / colonnes + condition de victoire STRICTE */
                let row_count = parcour_ligne();
                let correct_row = 0;
                for (let i = 0; i < 9; i++) {
                    if (rowNumbers[i] === null) continue;
                    if (row_count[i] > rowNumbers[i]) {
                        document.querySelectorAll(".row-number")[i].style.color = "#ff0000";
                    } else if (row_count[i] == rowNumbers[i]) {
                        correct_row++;
                        document.querySelectorAll(".row-number")[i].style.color = "#f5d76e";
                    } else {
                        document.querySelectorAll(".row-number")[i].style.color = "#f5d76e";
                    }
                }

                let col_count = parcour_col();
                let correct_col = 0;
                for (let i = 0; i < 9; i++) {
                    if (colNumbers[i] === null) continue;
                    if (col_count[i] > colNumbers[i]) {
                        document.querySelectorAll(".col-number")[i].style.color = "#ff0000";
                    } else if (col_count[i] == colNumbers[i]) {
                        correct_col++;
                        document.querySelectorAll(".col-number")[i].style.color = "#f5d76e";
                    } else {
                        document.querySelectorAll(".col-number")[i].style.color = "#f5d76e";
                    }
                }

                /* VICTOIRE = niveau importe + tous les indices satisfaits */
                if (niveauImporte && correct_col == 9 && correct_row == 9) {
                    afficherVictoire();
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
        });
    });
}

function parcour_ligne() {
    const tab = document.querySelectorAll(".case");
    let tab_count = [];
    for (let i = 0; i < 9; i++) {
        let count = 0;
        for (let j = 0; j < 9; j++) {
            if (tab[i * 9 + j].classList.contains("selected")
             || tab[i * 9 + j].classList.contains("fixed")) {
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
            if (tab[j * 9 + i].classList.contains("selected")
             || tab[j * 9 + i].classList.contains("fixed")) {
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
        [x-1,y-1],[x-1,y],[x-1,y+1],
        [x,  y-1],         [x,  y+1],
        [x+1,y-1],[x+1,y],[x+1,y+1]
    ];
    for (const [ni, nj] of voisins) {
        if (ni<0||ni>=9||nj<0||nj>=9) continue;
        const voisin = tab_2[ni][nj];
        const occupe = voisin.classList.contains("selected") || voisin.classList.contains("fixed");
        const estPrev1 = ni===prev_1[0] && nj===prev_1[1];
        const estPrev2 = ni===prev_2[0] && nj===prev_2[1];
        const estFin = ni===8 && nj===8;
        if (occupe && !estPrev1 && !estPrev2 && !estFin) return false;
    }
    return true;
}
function verif_voisin(x, y) {
    const tab = document.querySelectorAll(".case");
    const tab_2 = Array.from({ length: 9 }, (_, i) =>
        Array.from({ length: 9 }, (_, j) => tab[i * 9 + j])
    );
    const voisins = [[x-1,y],[x,y-1],[x,y+1],[x+1,y]];
    let count = 0;
    for (const [ni, nj] of voisins) {
        if (ni<0||ni>=9||nj<0||nj>=9) continue;
        const v = tab_2[ni][nj];
        if (v.classList.contains("selected") || v.classList.contains("fixed")) count++;
    }
    return count !== 0;
}
function verif_clic(x, y, prev_1) {
    const v = [[x-1,y],[x,y-1],[x,y+1],[x+1,y]];
    for (let i = 0; i < 4; i++) {
        if (v[i][0] == prev_1[0] && v[i][1] == prev_1[1]) return true;
    }
    return false;
}
function afficherVictoire() {
    if (victoireDejaAffichee) return;
    victoireDejaAffichee = true;
    document.getElementById("victoryOverlay").classList.add("show");
}

/* ---------------------------------------------------------------------
 *  Bouton "Solution" : envoie rows/cols au solveur C (api/resoudre_niveau.php)
 *  et trace en bleu (.hint) les cases de la solution. N'efface pas les
 *  cases deja cliquees par le joueur : l'overlay vient juste s'ajouter.
 * --------------------------------------------------------------------- */
async function montrerSolution() {
    const info = document.getElementById("info");
    info.classList.remove("error");

    if (!niveauImporte) {
        info.textContent = "Importez d'abord un niveau avant de demander la solution.";
        info.classList.add("error");
        return;
    }

    info.textContent = "Calcul de la solution par le solveur C...";

    try {
        const r = await fetch('api/resoudre_niveau.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ rows: rowNumbers, cols: colNumbers })
        });
        const data = await r.json();
        if (!data.ok) {
            info.textContent = "Solveur: " + (data.error || 'erreur inconnue');
            info.classList.add("error");
            return;
        }
        const cells = document.querySelectorAll('.case');
        for (let i = 0; i < 9; i++) {
            for (let j = 0; j < 9; j++) {
                const c = cells[i * 9 + j];
                c.classList.remove('hint');
                if (data.solution[i][j] === 1) c.classList.add('hint');
            }
        }
        info.textContent = "Solution affichee en bleu (" + data.longueur + " cases).";
    } catch (e) {
        info.textContent = "Erreur fetch solveur : " + e.message;
        info.classList.add("error");
    }
}

/* Si l'utilisateur arrive avec un lien direct (?lignes=...&colonnes=...)
 * on importe automatiquement. Pratique pour partager un permalien. */
(function autoImportDepuisURL() {
    const here = new URL(window.location.href);
    if (here.searchParams.get("lignes") && here.searchParams.get("colonnes")) {
        document.getElementById("import-input").value = here.href;
        importerNiveau();
    }
})();
</script>
</body>
</html>
