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
        .case.hint { background-color:#7fd1ff !important; opacity:0.85; }
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
 *  COBRA - Mode Infini : front-end JS
 *  Communication avec le C via fetch() vers api/generer_niveau.php
 *  et api/resoudre_niveau.php.
 * =================================================================== */

let difficulte = 0;
let niveauCourant = null;   // { rows, cols, solution, longueur, ... }
let tab = [[-1,-1], [0,0]]; // pile des cases du serpent du joueur
let victoireAffichee = false;

function setDiff(d) {
    difficulte = d;
    for (let i = 0; i < 3; i++) {
        document.getElementById('btn-diff-'+i)
                .classList.toggle('diff-active', i === d);
    }
    nouveauNiveau();
}

async function nouveauNiveau() {
    victoireAffichee = false;
    document.getElementById('victoryOverlay').classList.remove('show');
    document.getElementById('meta').textContent = 'Génération en cours…';

    try {
        const r = await fetch('api/generer_niveau.php?diff=' + difficulte);
        const data = await r.json();
        if (!data.ok) throw new Error(data.error || 'erreur inconnue');
        niveauCourant = data;
        afficherNiveau(data);
    } catch (e) {
        document.getElementById('meta').textContent =
            'Erreur lors de la génération : ' + e.message;
    }
}

function afficherNiveau(data) {
    const grid = document.getElementById('grid');
    grid.innerHTML = '';
    tab = [[-1,-1], [0,0]];

    for (let row = 0; row < 9; row++) {
        for (let col = 0; col < 9; col++) {
            const cell = document.createElement('div');
            cell.classList.add('case');
            cell.classList.add(`${row}`);
            cell.classList.add(`${col}`);
            if ((row === 0 && col === 0) || (row === 8 && col === 8)) {
                cell.classList.add('fixed');
            }
            grid.appendChild(cell);
        }
        const rn = document.createElement('div');
        rn.classList.add('row-number');
        rn.textContent = data.rows[row];
        grid.appendChild(rn);
    }
    for (let col = 0; col < 9; col++) {
        const cn = document.createElement('div');
        cn.classList.add('col-number');
        cn.textContent = data.cols[col];
        grid.appendChild(cn);
    }

    document.getElementById('meta').textContent =
        'Longueur du serpent : ' + data.longueur +
        ' / Difficulté : ' + ['facile','moyen','difficile'][data.difficulte] +
        ' / seed : ' + data.seed;

    brancherClics();
}

function brancherClics() {
    document.querySelectorAll('.case').forEach(cell => {
        cell.addEventListener('click', () => clicCase(cell));
        cell.addEventListener('contextmenu', e => {
            e.preventDefault();
            if (!cell.classList.contains('fixed')) {
                cell.classList.toggle('brouillon');
            }
        });
    });
}

function clicCase(cell) {
    const x = parseInt(cell.classList[1], 10);
    const y = parseInt(cell.classList[2], 10);
    if (cell.classList.contains('fixed')) return;
    if (!verifVoisin(x, y)) return;

    cell.classList.toggle('selected');
    if (cell.classList.contains('selected')) {
        const last = tab[tab.length-1];
        const prev = tab[tab.length-2] || [-1,-1];
        if (!verifClic(x, y, last) || !verifCase(x, y, last, prev)) {
            cell.classList.toggle('selected');
            return;
        }
        tab.push([x,y]);
    } else {
        /* on remet en arriere jusqu'a la case cliquee */
        while (tab.length > 2 && (tab[tab.length-1][0] !== x || tab[tab.length-1][1] !== y)) {
            const v = tab.pop();
            const c = document.querySelector('.case.' + v[0] + '.' + v[1]);
            if (c) c.classList.remove('selected');
        }
        tab.pop();
    }

    /* mise a jour des indices */
    majIndices();
    verifierVictoire();
}

function majIndices() {
    const rowCount = parcourLigne();
    const colCount = parcourCol();
    const rns = document.querySelectorAll('.row-number');
    const cns = document.querySelectorAll('.col-number');
    for (let i = 0; i < 9; i++) {
        rns[i].style.color = (rowCount[i] > niveauCourant.rows[i]) ? '#ff0000' : '#f5d76e';
        cns[i].style.color = (colCount[i] > niveauCourant.cols[i]) ? '#ff0000' : '#f5d76e';
    }
}

function parcourLigne() {
    const cells = document.querySelectorAll('.case');
    const out = [];
    for (let i = 0; i < 9; i++) {
        let n = 0;
        for (let j = 0; j < 9; j++) {
            const c = cells[i*9+j];
            if (c.classList.contains('selected') || c.classList.contains('fixed')) n++;
        }
        out.push(n);
    }
    return out;
}
function parcourCol() {
    const cells = document.querySelectorAll('.case');
    const out = [];
    for (let i = 0; i < 9; i++) {
        let n = 0;
        for (let j = 0; j < 9; j++) {
            const c = cells[j*9+i];
            if (c.classList.contains('selected') || c.classList.contains('fixed')) n++;
        }
        out.push(n);
    }
    return out;
}

function verifClic(x, y, prev) {
    const v = [[x-1,y],[x,y-1],[x,y+1],[x+1,y]];
    return v.some(([a,b]) => a === prev[0] && b === prev[1]);
}

function verifVoisin(x, y) {
    const cells = document.querySelectorAll('.case');
    const v = [[x-1,y],[x,y-1],[x,y+1],[x+1,y]];
    return v.some(([a,b]) => {
        if (a<0||a>=9||b<0||b>=9) return false;
        const c = cells[a*9+b];
        return c.classList.contains('selected') || c.classList.contains('fixed');
    });
}

function verifCase(x, y, p1, p2) {
    const cells = document.querySelectorAll('.case');
    const voisins = [
        [x-1,y-1],[x-1,y],[x-1,y+1],
        [x,  y-1],         [x,  y+1],
        [x+1,y-1],[x+1,y],[x+1,y+1]
    ];
    for (const [a,b] of voisins) {
        if (a<0||a>=9||b<0||b>=9) continue;
        const c = cells[a*9+b];
        const occupe = c.classList.contains('selected') || c.classList.contains('fixed');
        const ep1 = a===p1[0] && b===p1[1];
        const ep2 = a===p2[0] && b===p2[1];
        const fin = a===8 && b===8;
        if (occupe && !ep1 && !ep2 && !fin) return false;
    }
    return true;
}

function verifierVictoire() {
    if (victoireAffichee) return;
    const rowC = parcourLigne(), colC = parcourCol();
    for (let i = 0; i < 9; i++) {
        if (rowC[i] !== niveauCourant.rows[i]) return;
        if (colC[i] !== niveauCourant.cols[i]) return;
    }
    victoireAffichee = true;
    document.getElementById('victoryOverlay').classList.add('show');
}

/* Demande au solveur C l'emplacement du serpent solution et le montre
 * en surbrillance bleue. Tres utile en oral pour montrer le solveur. */
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

/* lance le premier niveau au chargement */
nouveauNiveau();
</script>
</body>
</html>
