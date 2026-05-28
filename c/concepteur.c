/* =====================================================================
 *  COBRA - Concepteur automatique de niveaux
 * =====================================================================
 *  Principe :
 *   1. On part de la tete en (0,0) et on pose la queue en (N-1,N-1).
 *   2. Marche aleatoire avec backtracking :
 *        - depuis la case courante, on tire une direction au hasard
 *          parmi celles non encore essayees,
 *        - si la nouvelle case respecte verif_case (pas de voisins
 *          occupes hors les precedents et la queue) on la prend,
 *        - sinon on retire cette direction du tirage,
 *        - si toutes les directions echouent on recule (depile la
 *          derniere direction utilisee).
 *   3. On s'arrete quand on est a distance Manhattan 1 de la queue.
 *   4. On controle la longueur finale en fonction de la difficulte.
 *      Si elle n'est pas dans l'intervalle vise, on relance avec une
 *      autre graine.
 *
 *  Sortie : JSON sur stdout (voir niveau_to_json).
 *  Tout message de debug est envoye sur stderr pour ne pas polluer
 *  le JSON consomme par PHP.
 *
 *  Usage CLI :
 *      ./concepteur                 -> facile, seed = time(NULL)
 *      ./concepteur 1               -> moyen
 *      ./concepteur 2 1234          -> difficile avec seed fixe (debug)
 * =====================================================================
 */
#include <string.h>
#include <time.h>
#include "jeu.h"

static int  manhattan_to_tail(int x, int y) {
    return abs(x - (N - 1)) + abs(y - (N - 1));
}

/* Tente une marche aleatoire complete depuis (0,0). */
static bool une_tentative(Niveau *niv) {
    int matrice[N][N] = {0};
    matrice[0][0]         = CASE_FIXE;
    matrice[N - 1][N - 1] = CASE_FIXE;

    int tab[N * N + 2][2];
    tab[0][0] = -1; tab[0][1] = -1;
    tab[1][0] =  0; tab[1][1] =  0;
    int idx_tab = 1;

    int courant[2] = {0, 0};
    int direction[4] = {1, 2, 3, 4};
    int pile[N * N + 2];
    int idx_pile = -1;

    int compteur = 0;
    const int MAX_ITER = 1500;

    while (manhattan_to_tail(courant[0], courant[1]) != 1
           && compteur < MAX_ITER) {

        int candidats[4], nb_cand = 0;
        for (int i = 0; i < 4; i++) {
            if (direction[i] != 0) candidats[nb_cand++] = i;
        }
        if (nb_cand == 0) {
            if (idx_pile < 0) return false;
            int last_dir = pile[idx_pile];
            pile[idx_pile] = 0;
            idx_pile--;

            for (int i = 0; i < 4; i++) direction[i] = i + 1;
            direction[last_dir - 1] = 0;

            matrice[courant[0]][courant[1]] = CASE_VIDE;
            tab[idx_tab][0] = 0; tab[idx_tab][1] = 0;
            idx_tab--;
            courant[0] = tab[idx_tab][0];
            courant[1] = tab[idx_tab][1];

            compteur++;
            continue;
        }

        int choix = candidats[rand() % nb_cand];
        int dir = direction[choix];

        int case_cote[2];
        if      (dir == 1) { case_cote[0] = courant[0];     case_cote[1] = courant[1] - 1; }
        else if (dir == 2) { case_cote[0] = courant[0];     case_cote[1] = courant[1] + 1; }
        else if (dir == 3) { case_cote[0] = courant[0] - 1; case_cote[1] = courant[1];     }
        else               { case_cote[0] = courant[0] + 1; case_cote[1] = courant[1];     }

        bool ok = false;
        if (case_existe(case_cote[0], case_cote[1])
            && verif_case(case_cote[0], case_cote[1],
                          tab[idx_tab], tab[idx_tab - 1], matrice)
            && (case_cote[0] != tab[idx_tab - 1][0]
                || case_cote[1] != tab[idx_tab - 1][1])) {
            ok = true;
        }

        if (ok) {
            matrice[case_cote[0]][case_cote[1]] = CASE_CORPS;
            courant[0] = case_cote[0];
            courant[1] = case_cote[1];
            idx_tab++;
            tab[idx_tab][0] = courant[0];
            tab[idx_tab][1] = courant[1];

            idx_pile++;
            pile[idx_pile] = dir;

            for (int i = 0; i < 4; i++) direction[i] = i + 1;
        } else {
            direction[choix] = 0;
        }

        compteur++;
    }

    if (manhattan_to_tail(courant[0], courant[1]) != 1) return false;

    int len = 0;
    for (int i = 0; i < N; i++)
        for (int j = 0; j < N; j++) {
            niv->grille[i][j] = matrice[i][j];
            if (matrice[i][j] != CASE_VIDE) len++;
        }
    niv->longueur = len;
    return true;
}

bool generer_niveau(Niveau *niv, Difficulte diff, unsigned int seed) {
    if (seed == 0) seed = (unsigned int)time(NULL);
    srand(seed);
    niv->seed = seed;
    niv->difficulte = (int)diff;

    int len_min, len_max;
    switch (diff) {
        case DIFF_FACILE:    len_min = 15; len_max = 22; break;
        case DIFF_MOYEN:     len_min = 23; len_max = 32; break;
        case DIFF_DIFFICILE: len_min = 33; len_max = 45; break;
        default:             len_min = 15; len_max = 45; break;
    }

    const int MAX_TENTATIVES = 400;
    Niveau best;
    memset(&best, 0, sizeof(best));
    int best_score = -1;

    for (int t = 0; t < MAX_TENTATIVES; t++) {
        Niveau essai;
        memset(&essai, 0, sizeof(essai));
        if (!une_tentative(&essai)) continue;

        if (essai.longueur >= len_min && essai.longueur <= len_max) {
            memcpy(niv->grille, essai.grille, sizeof(essai.grille));
            niv->longueur = essai.longueur;
            grille_to_indices(niv->grille, niv->rows, niv->cols);
            return true;
        }

        int dist;
        if (essai.longueur < len_min) dist = len_min - essai.longueur;
        else                          dist = essai.longueur - len_max;
        if (best_score < 0 || dist < best_score) {
            best_score = dist;
            best = essai;
        }
    }

    if (best_score >= 0) {
        memcpy(niv->grille, best.grille, sizeof(best.grille));
        niv->longueur = best.longueur;
        grille_to_indices(niv->grille, niv->rows, niv->cols);
        return true;
    }
    return false;
}

int main(int argc, char **argv) {
    Difficulte diff = DIFF_FACILE;
    unsigned int seed = 0;

    if (argc >= 2) {
        int d = atoi(argv[1]);
        if (d >= 0 && d <= 2) diff = (Difficulte)d;
    }
    if (argc >= 3) {
        seed = (unsigned int)strtoul(argv[2], NULL, 10);
    }

    Niveau niv;
    memset(&niv, 0, sizeof(niv));
    if (!generer_niveau(&niv, diff, seed)) {
        fprintf(stdout, "{\"ok\":false,\"error\":\"generation_failed\"}\n");
        return EXIT_FAILURE;
    }

    niveau_to_json(stdout, &niv);
    return EXIT_SUCCESS;
}
