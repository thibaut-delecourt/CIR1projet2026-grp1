<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COBRA - Mode Infini</title>
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

        .game-zone { margin-top: 40px; display: flex; justify-content: center; align-items: center; flex-direction: column; }
        .toolbar { display:flex; gap:12px; margin: 12px 0 18px; flex-wrap: wrap; justify-content:center; }
        .toolbar button {
            background:#1f7a2e; color:#fff6b0; border:2px solid #f5d76e;
            border-radius: 999px; padding:10px 18px; font-weight:bold; cursor:pointer;
            font-size:14px;
        }
        .toolbar button:hover { background:#2da33d; }
        .toolbar button.diff-active { background:#f5d76e; color:#123d18; }
        .info { color:#fdf6e3; text-align:center; margin-bottom:14px; }

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

        /* Boite de partage du lien (apparait apres clic sur "Partager") */
        #share-link-box {
            display: none;
            margin: 14px auto 0;
            padding: 12px;
            background: rgba(12, 55, 20, 0.85);
            border: 2px solid #f5d76e;
            border-radius: 12px;
            max-width: 600px;
            text-align: center;
        }
        #share-link-input {
            width: 100%;
            padding: 8px 12px;
            border-radius: 8px;
            border: 2px solid #f5d76e;
            background: #0c2f10;
            color: #f5d76e;
            font-size: 13px;
            font-family: monospace;
        }
        #copy-confirm {
            display: none;
            margin-left: 12px;
            color: #8dff9c;
            font-weight: bold;
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

    <a href="index.php" class="btn-back">&larr; Accueil</a>

    <main class="page">
        <h1 class="logo">COBRA</h1>
        <p class="logo-sub">Mode Infini - g&eacute;n&eacute;ration automatique en C</p>

        <div class="toolbar">
            <button id="btn-diff-0" class="diff-active" onclick="setDiff(0)">Facile</button>
            <button id="btn-diff-1" onclick="setDiff(1)">Moyen</button>
            <button id="btn-diff-2" onclick="setDiff(2)">Difficile</button>
            <button onclick="nouveauNiveau()">Nouveau niveau</button>
            <button onclick="montrerSolution()" title="Affiche la solution calcul&eacute;e par le solveur C">Indice (solveur)</button>
            <button onclick="partagerNiveau()" title="Copie un lien r&eacute;utilisable dans le concepteur">Partager le niveau</button>
        </div>

        <div id="share-link-box">
            <input id="share-link-input" type="text" readonly>
            <br>
            <button class="victory-button" style="margin-top:10px;" onclick="copierLien()">Copier le lien</button>
            <span id="copy-confirm">Copi&eacute;&nbsp;!</span>
            <p style="color:#fdf6e3; font-size:13px; margin-top:10px;">
                Colle ce lien dans la case « Coller le lien ici&hellip; » du <a href="concepteur.php" style="color:#f5d76e;">concepteur</a>.
            </p>
        </div>

        <div class="info" id="meta">Chargement du premier niveau&hellip;</div>

        <section class="game-zone">
            <div class="jungle-frame">
                <div class="puzzle-grid" id="grid"></div>
            </div>
        </section>
    </main>

    <div class="victory-overlay" id="victoryOverlay">
        <div class="victory-box">
            <div class="victory-title">VICTOIRE</div>
            <p style="color:white; font-size:18px; margin-top:14px;">
                Le serpent relie bien la queue &agrave; la t&ecirc;te !
            </p>
            <button class="victory-button" onclick="nouveauNiveau()">Niveau suivant</button>
        </div>
    </div>

<script>
/* ===================================================================
 *  COBRA - Mode Infini
 *  Genere un niveau via api/generer_niveau.php (binaire C concepteur),
 *  resoud via api/resoudre_niveau.php (binaire C solveur).
 *  La gameplay (clics, pile tab, victoire) est IDENTIQUE a aventure_1.php
 *  -- seulement encapsulee dans une fonction pour pouvoir etre relancee
 *  a chaque nouveau niveau.
 * =================================================================== */

let difficulte = 0;
let niveauCourant = null;
let rowNumbers = [];
let colNumbers = [];
let victoireDejaAffichee = false;

function setDiff(d) {
    difficulte = d;
    for (let i = 0; i < 3; i++) {
        document.getElementById('btn-diff-'+i)
                .classList.toggle('diff-active', i === d);
    }
    nouveauNiveau();
}

async function nouveauNiveau() {
    victoireDejaAffichee = false;
    document.getElementById('victoryOverlay').classList.remove('show');
    document.getElementById('meta').textContent = 'Génération en cours…';
    try {
        const r = await fetch('api/generer_niveau.php?diff=' + difficulte);
        const data = await r.json();
        if (!data.ok) throw new Error(data.error || 'erreur inconnue');
        niveauCourant = data;
        rowNumbers = data.rows.slice();
        colNumbers = data.cols.slice();
        document.getElementById('meta').textContent =
            'Longueur du serpent : ' + data.longueur +
            ' / Difficulté : ' + ['facile','moyen','difficile'][data.difficulte] +
            ' / seed : ' + data.seed;
        construireGrille();
    } catch (e) {
        document.getElementById('meta').textContent =
            'Erreur lors de la génération : ' + e.message;
    }
}

/* ---------------------------------------------------------------------
 *  Construction de la grille + branchement des clics
 *  -> COPIE QUASI A L'IDENTIQUE DE aventure_1.php pour fiabilite
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
        rowNumber.textContent = rowNumbers[row];
        grid.appendChild(rowNumber);
    }

    for (let col = 0; col < 9; col++) {
        const colNumber = document.createElement("div");
        colNumber.classList.add("col-number");
        colNumber.textContent = colNumbers[col];
        grid.appendChild(colNumber);
    }

    /* -- exactement la meme logique que aventure_1.php -- */
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

                let row_count = parcour_ligne();
                let correct_row = 0;
                for (let i = 0; i < 9; i++) {
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
                    if (col_count[i] > colNumbers[i]) {
                        document.querySelectorAll(".col-number")[i].style.color = "#ff0000";
                    } else if (col_count[i] == colNumbers[i]) {
                        correct_col++;
                        document.querySelectorAll(".col-number")[i].style.color = "#f5d76e";
                    } else {
                        document.querySelectorAll(".col-number")[i].style.color = "#f5d76e";
                    }
                }
                if (correct_col == 9 && correct_row == 9) {
                    afficherVictoire();
                }
            }
        });
    });

    /* clic droit : mode brouillon (gris) */
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
        [x-1, y-1], [x-1, y], [x-1, y+1],
        [x,   y-1],            [x,   y+1],
        [x+1, y-1], [x+1, y], [x+1, y+1]
    ];
    for (const [ni, nj] of voisins) {
        if (ni < 0 || ni >= 9 || nj < 0 || nj >= 9) continue;
        const voisin = tab_2[ni][nj];
        const occupe = voisin.classList.contains("selected") || voisin.classList.contains("fixed");
        const estPrev1 = ni === prev_1[0] && nj === prev_1[1];
        const estPrev2 = ni === prev_2[0] && nj === prev_2[1];
        const estFin = ni === 8 && nj === 8;
        if (occupe && !estPrev1 && !estPrev2 && !estFin) {
            return false;
        }
    }
    return true;
}

function verif_voisin(x, y) {
    const tab = document.querySelectorAll(".case");
    const tab_2 = Array.from({ length: 9 }, (_, i) =>
        Array.from({ length: 9 }, (_, j) => tab[i * 9 + j])
    );
    const voisins = [[x-1, y], [x, y-1], [x, y+1], [x+1, y]];
    let count = 0;
    for (const [ni, nj] of voisins) {
        if (ni < 0 || ni >= 9 || nj < 0 || nj >= 9) continue;
        const voisin = tab_2[ni][nj];
        const occupe = voisin.classList.contains("selected") || voisin.classList.contains("fixed");
        if (occupe) count++;
    }
    return count !== 0;
}

function verif_clic(x, y, prev_1) {
    const voisins = [[x-1, y], [x, y-1], [x, y+1], [x+1, y]];
    for (let i = 0; i < 4; i++) {
        if (voisins[i][0] == prev_1[0] && voisins[i][1] == prev_1[1]) {
            return true;
        }
    }
    return false;
}

function afficherVictoire() {
    if (victoireDejaAffichee) return;
    victoireDejaAffichee = true;
    document.getElementById('victoryOverlay').classList.add('show');
}

/* ---------------------------------------------------------------------
 *  Bouton "Indice (solveur)" : appelle le solveur C et marque en bleu
 *  les cases solution.
 * --------------------------------------------------------------------- */
/* ---------------------------------------------------------------------
 *  Partage du niveau courant -- meme format de lien que concepteur.php
 *  pour etre re-importable via sa boite "Coller le lien ici...".
 *
 *  Format produit (compatible avec importerNiveau() dans concepteur.php) :
 *     <origin>/jouer.php?lignes=1,2,...&colonnes=2,5,...&chemin=0-0,1-0,1-1,...,8-8
 * --------------------------------------------------------------------- */
function partagerNiveau() {
    if (!niveauCourant) {
        alert('Aucun niveau a partager pour le moment.');
        return;
    }

    /* On reconstruit le chemin du serpent a partir de la grille solution
     * renvoyee par le concepteur C. On part de (0,0) et on suit les
     * voisins 4-connexes occupes (1 ou 2) jusqu'a (8,8). */
    const sol = niveauCourant.solution;
    const chemin = [];
    const vu = Array.from({length:9}, () => Array(9).fill(false));
    let cx = 0, cy = 0;
    chemin.push([cx, cy]);
    vu[cx][cy] = true;
    const N = 9;
    while (!(cx === N-1 && cy === N-1)) {
        const voisins = [[cx-1,cy],[cx+1,cy],[cx,cy-1],[cx,cy+1]];
        let suivant = null;
        for (const [nx, ny] of voisins) {
            if (nx<0||nx>=N||ny<0||ny>=N) continue;
            if (vu[nx][ny]) continue;
            if (sol[nx][ny] === 1 || sol[nx][ny] === 2) { suivant = [nx, ny]; break; }
        }
        if (!suivant) break; /* securite : ne devrait jamais arriver */
        chemin.push(suivant);
        vu[suivant[0]][suivant[1]] = true;
        cx = suivant[0]; cy = suivant[1];
    }

    const params = new URLSearchParams({
        lignes:   niveauCourant.rows.join(","),
        colonnes: niveauCourant.cols.join(","),
        chemin:   chemin.map(c => c[0] + "-" + c[1]).join(",")
    });

    /* Meme format que concepteur.php : on garde l'URL "jouer.php" meme
     * si la page n'existe pas - seules les query-params comptent pour
     * importerNiveau(). */
    const lien = window.location.origin + "/jouer.php?" + params.toString();

    const box = document.getElementById("share-link-box");
    const input = document.getElementById("share-link-input");
    box.style.display = "block";
    input.value = lien;
    input.select();
}

function copierLien() {
    const input = document.getElementById("share-link-input");
    navigator.clipboard.writeText(input.value).then(() => {
        const confirm = document.getElementById("copy-confirm");
        confirm.style.display = "inline";
        setTimeout(() => confirm.style.display = "none", 2500);
    });
}

async function montrerSolution() {
    if (!niveauCourant) return;
    try {
        const r = await fetch('api/resoudre_niveau.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                rows: niveauCourant.rows,
                cols: niveauCourant.cols
            })
        });
        const data = await r.json();
        if (!data.ok) {
            alert('Solveur: ' + (data.error || 'inconnu'));
            return;
        }
        const cells = document.querySelectorAll('.case');
        for (let i = 0; i < 9; i++) for (let j = 0; j < 9; j++) {
            const c = cells[i*9+j];
            c.classList.remove('hint');
            if (data.solution[i][j] === 1) c.classList.add('hint');
        }
    } catch (e) {
        alert('Erreur fetch solveur: ' + e.message);
    }
}

nouveauNiveau();
</script>
</body>
</html>
