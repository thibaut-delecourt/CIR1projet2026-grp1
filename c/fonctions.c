/* =====================================================================
 *  COBRA - Helpers communs au concepteur et au solveur
 * =====================================================================
 *  NB : par rapport a ta version initiale on a corrige deux bugs :
 *   - parcours_col / parcours_lignes ne peuvent pas retourner un tableau
 *     local en C (le tableau est detruit a la sortie de la fonction).
 *     On passe maintenant le tableau de sortie en parametre.
 *   - le test "voisin_fin == (8,8)" est genere en dur a partir de N pour
 *     rester correct si on change la taille de la grille.
 * =====================================================================
 */
#include "jeu.h"

void parcours_col(int matrice[N][N], int tab[N]) {
    for (int i = 0; i < N; i++) {
        int count = 0;
        for (int j = 0; j < N; j++) {
            if (matrice[j][i] != CASE_VIDE) {
                count++;
            }
        }
        tab[i] = count;
    }
}

void parcours_lignes(int matrice[N][N], int tab[N]) {
    for (int i = 0; i < N; i++) {
        int count = 0;
        for (int j = 0; j < N; j++) {
            if (matrice[i][j] != CASE_VIDE) {
                count++;
            }
        }
        tab[i] = count;
    }
}

bool case_existe(int x, int y) {
    return (x >= 0 && x < N && y >= 0 && y < N);
}

bool verif_case(int x, int y, int prev_1[2], int prev_2[2],
                int matrice[N][N]) {
    /* La case ne doit pas etre adjacente diagonalement a la queue,
     * sinon elle "touche" la queue par le coin -> illegal. */
    if (x + 1 == N - 1 && y + 1 == N - 1) {
        return false;
    }

    const int voisins[8][2] = {
        {x - 1, y - 1}, {x - 1, y    }, {x - 1, y + 1},
        {x    , y - 1},                 {x    , y + 1},
        {x + 1, y - 1}, {x + 1, y    }, {x + 1, y + 1}
    };

    for (int i = 0; i < 8; i++) {
        int nx = voisins[i][0];
        int ny = voisins[i][1];
        if (!case_existe(nx, ny)) continue;

        int v = matrice[nx][ny];
        bool occupe   = (v == CASE_CORPS) || (v == CASE_FIXE);
        bool estPrev1 = (nx == prev_1[0]) && (ny == prev_1[1]);
        bool estPrev2 = (nx == prev_2[0]) && (ny == prev_2[1]);
        bool estFin   = (nx == N - 1) && (ny == N - 1);

        if (occupe && !estPrev1 && !estPrev2 && !estFin) {
            return false;
        }
    }
    return true;
}

void afficher_grille(int matrice[N][N]) {
    for (int i = 0; i < N; i++) {
        for (int j = 0; j < N; j++) {
            fprintf(stderr, " %d ", matrice[i][j]);
        }
        fprintf(stderr, "\n");
    }
}

void grille_to_indices(int matrice[N][N], int rows[N], int cols[N]) {
    parcours_lignes(matrice, rows);
    parcours_col(matrice, cols);
}

void niveau_to_json(FILE *f, const Niveau *niv) {
    fprintf(f, "{\"ok\":true,");

    fprintf(f, "\"rows\":[");
    for (int i = 0; i < N; i++)
        fprintf(f, "%d%s", niv->rows[i], (i == N - 1) ? "" : ",");
    fprintf(f, "],");

    fprintf(f, "\"cols\":[");
    for (int i = 0; i < N; i++)
        fprintf(f, "%d%s", niv->cols[i], (i == N - 1) ? "" : ",");
    fprintf(f, "],");

    fprintf(f, "\"longueur\":%d,", niv->longueur);
    fprintf(f, "\"difficulte\":%d,", niv->difficulte);
    fprintf(f, "\"seed\":%u,", niv->seed);

    fprintf(f, "\"solution\":[");
    for (int i = 0; i < N; i++) {
        fprintf(f, "[");
        for (int j = 0; j < N; j++) {
            fprintf(f, "%d%s", niv->grille[i][j], (j == N - 1) ? "" : ",");
        }
        fprintf(f, "]%s", (i == N - 1) ? "" : ",");
    }
    fprintf(f, "]");

    fprintf(f, "}\n");
}
