/* =====================================================================
 *  COBRA - Header partage entre le concepteur, le solveur et les helpers
 * =====================================================================
 *  Codes possibles d'une case :
 *      0 : case vide (non utilisee par le serpent)
 *      1 : case appartenant au corps du serpent
 *      2 : case fixe (tete en (0,0) ou queue en (N-1,N-1))
 * =====================================================================
 */
#pragma once

#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>

/* Cote de la grille (9x9 dans le jeu COBRA) */
#define N 9

#define CASE_VIDE   0
#define CASE_CORPS  1
#define CASE_FIXE   2

/* --- Difficultes proposees par le concepteur ---------------------------
 * On ajuste deux parametres :
 *   - la longueur cible du serpent (plus long = plus complexe a deduire)
 *   - le nombre maximum de virages autorises
 */
typedef enum {
    DIFF_FACILE    = 0,
    DIFF_MOYEN     = 1,
    DIFF_DIFFICILE = 2
} Difficulte;

/* --- Representation d'un niveau --------------------------------------- */
typedef struct {
    int  grille[N][N];   /* solution complete (0/1/2)            */
    int  rows[N];        /* indice ligne (somme cases du serpent) */
    int  cols[N];        /* indice colonne                        */
    int  longueur;       /* nb total de cases occupees            */
    int  difficulte;     /* 0/1/2                                 */
    unsigned int seed;   /* graine RNG utilisee (utile en debug)  */
} Niveau;

/* ---------------------------------------------------------------------
 *  Helpers (fonctions.c)
 * --------------------------------------------------------------------- */

/* Remplit tab[c] avec le nombre de cases non-vides de la colonne c. */
void parcours_col(int matrice[N][N], int tab[N]);

/* Remplit tab[l] avec le nombre de cases non-vides de la ligne l. */
void parcours_lignes(int matrice[N][N], int tab[N]);

/* Verifie que la case (x,y) est dans la grille. */
bool case_existe(int x, int y);

/* Verifie qu'on peut ajouter la case (x,y) au serpent sans qu'elle
 * touche une autre case occupee, sauf les deux precedentes du chemin
 * et la queue en (N-1, N-1). */
bool verif_case(int x, int y, int prev_1[2], int prev_2[2],
                int matrice[N][N]);

/* Affichage console pratique pour debug. */
void afficher_grille(int matrice[N][N]);

/* A partir d'une matrice complete (avec les 2 cases fixes),
 * calcule rows[] et cols[] : ce sont les indices que verra le joueur. */
void grille_to_indices(int matrice[N][N], int rows[N], int cols[N]);

/* Exporte un niveau au format JSON sur le flux donne (stdout en general).
 *  {"ok":true,
 *   "rows":[...], "cols":[...],
 *   "longueur":17, "difficulte":1,
 *   "solution":[[..],[..],...] }
 */
void niveau_to_json(FILE *f, const Niveau *niv);

/* ---------------------------------------------------------------------
 *  Concepteur (concepteur.c)
 * --------------------------------------------------------------------- */

/* Genere un niveau jouable.
 *  - diff   : difficulte voulue
 *  - seed   : graine du RNG (passer 0 pour utiliser time(NULL))
 *  Retourne true si la generation a abouti, false sinon (rare). */
bool generer_niveau(Niveau *niv, Difficulte diff, unsigned int seed);

/* ---------------------------------------------------------------------
 *  Solveur (solveur.c)
 * --------------------------------------------------------------------- */

/* Resoud un niveau a partir uniquement des indices rows[]/cols[].
 *  - solution : matrice de sortie (0/1/2)
 *  Retourne true si une solution unique a ete trouvee.
 *  Si plusieurs solutions existent, la premiere est rendue et la
 *  fonction renvoie tout de meme true (le concepteur garantit
 *  normalement l'unicite). */
bool resoudre(int rows[N], int cols[N], int solution[N][N]);
