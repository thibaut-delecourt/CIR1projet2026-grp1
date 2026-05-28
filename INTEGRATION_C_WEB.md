# COBRA — Intégration C ↔ Web

Ce document explique **comment** le concepteur et le solveur écrits en C sont
branchés au site PHP. Il sert de référence pour ton oral 2 (présentation des
principes du concepteur et du solveur) et pour le rapport final (partie
« redéploiement »).

## 1. Arborescence ajoutée

```
CIR1projet2026-grp1/
├── c/                              # code source C
│   ├── jeu.h                       # header partagé (struct Niveau, prototypes)
│   ├── fonctions.c                 # helpers (verif_case, case_existe, ...)
│   ├── concepteur.c                # générateur automatique (marche + backtracking)
│   ├── solveur.c                   # solveur DFS + contraintes ligne/colonne
│   └── Makefile                    # cible all/clean
├── bin/                            # binaires compilés (à créer, voir §3)
│   ├── concepteur.exe              # ou « concepteur » sous Linux/Mac
│   └── solveur.exe
├── api/                            # pont PHP -> binaires C
│   ├── generer_niveau.php          # GET ?diff=0|1|2 [&seed=N]
│   └── resoudre_niveau.php         # POST { rows:[...], cols:[...] }
├── infini.php                      # consomme l'API, mode jeu infini
└── INTEGRATION_C_WEB.md            # ce document
```

## 2. Pipeline complet

```
   Navigateur                    Apache/PHP (MAMP)               C
   ──────────                    ───────────────                ───
   infini.php
       │
       │ fetch('api/generer_niveau.php?diff=1')
       ▼
   generer_niveau.php  ── proc_open() ──▶  bin/concepteur.exe 1
       │                                            │
       │                                       écrit JSON
       │                                       sur stdout
       ◀── stdout (JSON) ──────────────────────────┘
       │
   echo $stdout (Content-Type: application/json)
       │
       ▼
   navigateur reçoit
   { ok:true, rows:[...], cols:[...], solution:[[..]], ... }
       │
       │ JS dessine la grille, le joueur clique
       │
       ▼
   Le joueur veut un indice :
   fetch('api/resoudre_niveau.php', POST, { rows, cols })
       │
       ▼
   resoudre_niveau.php  ── proc_open() ──▶  bin/solveur.exe "1 2 1 …" "2 5 1 …"
       │                                            │
       ◀── stdout (JSON, solution) ────────────────┘
       │
   JS surligne en bleu les cases solution
```

## 3. Compilation des binaires sous MAMP / Windows

MAMP n'inclut pas de compilateur C. Il faut donc soit installer **MSYS2/MinGW**,
soit utiliser le compilateur C que Visual Studio installe (qui a `gcc` via
le sous-système Windows / `cl.exe`).

### Option A — MSYS2 (le plus simple)

1. Installer MSYS2 : <https://www.msys2.org/>
2. Dans le terminal MSYS2 :
   ```
   pacman -S mingw-w64-x86_64-gcc make
   ```
3. Compiler :
   ```
   cd /c/MAMP/htdocs/CIR1projet2026-grp1/c
   make
   mkdir -p ../bin
   cp concepteur.exe solveur.exe ../bin/
   ```

### Option B — Visual Studio Developer Command Prompt

```
cd C:\MAMP\htdocs\CIR1projet2026-grp1\c
cl /O2 /TC concepteur.c fonctions.c /Fe:..\bin\concepteur.exe
cl /O2 /TC solveur.c    fonctions.c /Fe:..\bin\solveur.exe
```

### Option C — Linux/Mac (déploiement serveur)

```
cd c/
make
mkdir -p ../bin && cp concepteur solveur ../bin/
chmod +x ../bin/concepteur ../bin/solveur
```

Le PHP détecte automatiquement l'extension `.exe` sous Windows et sans
extension sous Linux/Mac.

## 4. Test direct des binaires (sans le serveur)

```
./bin/concepteur 1        # difficulté moyenne, seed = time(NULL)
./bin/concepteur 2 42     # difficulté difficile, seed reproductible 42
./bin/solveur "1 2 1 5 4 5 1 1 1" "2 5 1 2 2 1 1 3 4"
```

Sortie attendue : du JSON sur une seule ligne. Pratique pour le screencast
de la démo de l'oral 2.

## 5. Algorithmes (à reformuler à l'oral)

### Concepteur — marche aléatoire + backtracking
1. On pose la tête en (0,0) et la queue en (N-1,N-1).
2. À chaque pas on tire une direction parmi {haut, bas, gauche, droite}.
3. On valide la case candidate avec `verif_case` : ne doit pas toucher une
   autre case du serpent (pas même en diagonale), sauf les deux précédentes.
4. Si toutes les directions échouent on dépile et on recule (backtracking).
5. On s'arrête quand on est à distance Manhattan 1 de la queue.
6. La **difficulté** est gérée par la longueur cible du serpent :
   * facile    : 15-22 cases
   * moyen     : 23-32 cases
   * difficile : 33-45 cases
   On régénère tant que la longueur n'est pas dans la fourchette
   (jusqu'à 400 tentatives, sinon on garde le moins mauvais).
7. À la fin on calcule rows[] et cols[] avec `parcours_lignes` /
   `parcours_col` pour produire les indices visibles par le joueur.

### Solveur — DFS + contraintes ligne/colonne
1. État initial : tête en (0,0), queue en (N-1,N-1), counts initialisés.
2. À chaque étape, on essaye les 4 voisins de la case courante.
3. **Prunings** avant de descendre :
   * la case est-elle dans la grille ?
   * est-elle déjà occupée ?
   * `rows_count[ligne] + 1 ≤ rows[ligne]` ?
   * `cols_count[col]   + 1 ≤ cols[col]` ?
   * `verif_case` accepte-t-elle la case ?
   * Heuristique globale : pour chaque ligne/col, le nombre de cases libres
     restantes doit suffire à atteindre l'indice voulu.
4. Succès quand on est à distance 1 de la queue ET que tous les
   `rows_count` et `cols_count` sont exactement les valeurs cibles.

Sur les niveaux 9x9 cette méthode résout en quelques millisecondes
(< 5 ms même en difficile dans nos tests). Le pruning par sommes
ligne/colonne est très efficace : c'est exactement ce qu'un humain fait
en remplissant d'abord les lignes faciles (1 ou 9) puis en propageant.

## 6. Pourquoi `proc_open()` et pas `shell_exec()` ?

`proc_open` permet :
- de capturer stdout et stderr séparément (on garde stderr de côté pour le
  debug sans polluer le JSON),
- d'obtenir le code de retour, utile si le solveur échoue (`{"ok":false}`),
- d'éviter l'invocation d'un shell, ce qui supprime un vecteur d'injection.

On combine avec `escapeshellarg()` sur chaque argument utilisateur (la
difficulté et les nombres rows/cols), pour bétonner contre toute valeur
malveillante.

## 7. Sécurité

- Le concepteur ne lit aucune entrée utilisateur sensible : il prend juste
  une difficulté (0/1/2) et une seed entière.
- Le solveur lit deux chaînes de 9 entiers ; côté PHP on les force en `int`
  avant de les envoyer, donc aucune chaîne arbitraire n'arrive au binaire.
- Aucun fichier n'est écrit par les binaires, tout passe par stdin/stdout.

## 8. Pièges courants & dépannage

| Symptôme | Cause probable | Solution |
| --- | --- | --- |
| `bin/ folder not found` dans la réponse JSON | Le dossier `bin/` n'existe pas ou les binaires n'ont pas été compilés | Faire la compilation §3 et placer les .exe dans `bin/` |
| `binary not found at …\solveur.exe` | L'extension est mauvaise (cherche `.exe` sous Linux par exemple) | Vérifier `PHP_OS_FAMILY` dans le PHP — il devrait être correct, sinon renommer le binaire |
| `invalid json from concepteur` | Le binaire crashe avant d'imprimer le JSON, ou imprime du debug sur stdout | Vérifier que tous les `printf` de debug utilisent **stderr** (`fprintf(stderr, …)`) |
| `cannot launch the C process` | `proc_open` est désactivé dans php.ini | Dans `php.ini`, vérifier que `disable_functions` ne contient pas `proc_open` |
| Niveau impossible à générer (`generation_failed`) | Très rare ; la combinaison difficulté + seed donne une grille toujours bloquée en 400 essais | Recharger la page (la seed change) |

## 9. À mettre dans le rapport final

- Le diagramme du §2 illustre l'« intégration ».
- Les explications du §5 répondent au critère « expliquer les mécanismes
  de génération et de résolution ».
- Le §3 fournit le « comment redéployer » exigé par le PDF des consignes.
- Mentionner que la **complexité** du solveur est exponentielle dans le
  pire des cas (DFS sur grille) mais que les **prunings** (sommes
  ligne/colonne + non-contact diagonal) la ramènent en pratique à
  quelques milliers d'opérations sur du 9×9.
