/* =====================================================================
 *  COBRA - Solveur automatique d'un niveau
 * =====================================================================
 *  On utilise un parcours en profondeur (DFS) qui construit le serpent
 *  case apres case en partant de la tete (0,0). A chaque pas on teste
 *  les 4 voisins (haut, bas, gauche, droite) et on n'en garde un que si
 *    - il est dans la grille,
 *    - il n'est pas deja sur le serpent (et n'est pas la queue),
 *    - l'ajouter ne fait pas depasser rows[ligne] ou cols[colonne],
 *    - il respecte verif_case (pas de contact diagonal avec une autre
 *      partie du serpent).
 *
 *  On considere une solution comme valide quand on est exactement a
 *  distance Manhattan 1 de la queue (en (N-1, N-2) ou (N-2, N-1)),
 *  et que rows_count[]/cols_count[] correspondent EXACTEMENT aux
 *  consignes du joueur.
 *
 *  Convention p1 / p2 :
 *    - p1 = la case juste avant (x,y) dans le chemin
 *    - p2 = la case encore avant p1
 *    - quand on place une nouvelle case (nx,ny) on appelle
 *      verif_case avec prev_1 = (x,y) et prev_2 = p1.
 *
 *  Usage CLI :
 *      ./solveur "1 1 1 1 1 1 1 1 9" "9 1 1 1 1 1 1 1 1"
 * =====================================================================
 */
#include <string.h>
#include <time.h>
#include "jeu.h"

static int g_rows[N];
static int g_cols[N];
static int g_rows_count[N];
static int g_cols_count[N];
static int g_solution[N][N];
static long g_nb_etapes;

static int manhattan_to_tail(int x, int y) {
    return abs(x - (N - 1)) + abs(y - (N - 1));
}

static bool indices_corrects(void) {
    for (int i = 0; i < N; i++) {
        if (g_rows_count[i] != g_rows[i]) return false;
        if (g_cols_count[i] != g_cols[i]) return false;
    }
    return true;
}

static bool encore_faisable(void) {
    for (int i = 0; i < N; i++) {
        int libres_ligne = 0, libres_col = 0;
        for (int j = 0; j < N; j++) {
            if (g_solution[i][j] == CASE_VIDE) libres_ligne++;
            if (g_solution[j][i] == CASE_VIDE) libres_col++;
        }
        if (g_rows_count[i] + libres_ligne < g_rows[i]) return false;
        if (g_cols_count[i] + libres_col   < g_cols[i]) return false;
    }
    return true;
}

static bool dfs(int x, int y, int p1[2], int p2[2]) {
    (void)p2;
    g_nb_etapes++;
    if (g_nb_etapes > 5000000L) return false;

    if (manhattan_to_tail(x, y) == 1 && indices_corrects()) {
        return true;
    }
    if (!encore_faisable()) return false;

    const int dx[4] = {-1, 1,  0, 0};
    const int dy[4] = { 0, 0, -1, 1};

    for (int k = 0; k < 4; k++) {
        int nx = x + dx[k];
        int ny = y + dy[k];

        if (!case_existe(nx, ny)) continue;
        if (g_solution[nx][ny] != CASE_VIDE) continue;
        if (nx == N - 1 && ny == N - 1) continue;
        if (g_rows_count[nx] + 1 > g_rows[nx]) continue;
        if (g_cols_count[ny] + 1 > g_cols[ny]) continue;

        int new_prev1[2] = {x, y};
        if (!verif_case(nx, ny, new_prev1, p1, g_solution)) continue;

        g_solution[nx][ny] = CASE_CORPS;
        g_rows_count[nx]++;
        g_cols_count[ny]++;

        if (dfs(nx, ny, new_prev1, p1)) return true;

        g_solution[nx][ny] = CASE_VIDE;
        g_rows_count[nx]--;
        g_cols_count[ny]--;
    }
    return false;
}

bool resoudre(int rows[N], int cols[N], int solution[N][N]) {
    memcpy(g_rows, rows, sizeof(g_rows));
    memcpy(g_cols, cols, sizeof(g_cols));
    memset(g_rows_count, 0, sizeof(g_rows_count));
    memset(g_cols_count, 0, sizeof(g_cols_count));
    memset(g_solution,   0, sizeof(g_solution));
    g_nb_etapes = 0;

    g_solution[0][0]         = CASE_FIXE;
    g_solution[N - 1][N - 1] = CASE_FIXE;
    g_rows_count[0]++;       g_cols_count[0]++;
    g_rows_count[N - 1]++;   g_cols_count[N - 1]++;

    for (int i = 0; i < N; i++) {
        if (g_rows_count[i] > g_rows[i]) return false;
        if (g_cols_count[i] > g_cols[i]) return false;
    }

    int p1[2] = {-1, -1};
    int p2[2] = {-1, -1};

    bool found = dfs(0, 0, p1, p2);
    if (found) memcpy(solution, g_solution, sizeof(g_solution));
    return found;
}

static bool parse_9(const char *s, int tab[N]) {
    int n = 0;
    const char *p = s;
    while (*p && n < N) {
        while (*p == ' ' || *p == ',' || *p == '\t') p++;
        if (!*p) break;
        char *end;
        long v = strtol(p, &end, 10);
        if (end == p) return false;
        tab[n++] = (int)v;
        p = end;
    }
    return n == N;
}

int main(int argc, char **argv) {
    int rows[N], cols[N];

    if (argc < 3) {
        fprintf(stdout, "{\"ok\":false,\"error\":\"usage\"}\n");
        return EXIT_FAILURE;
    }
    if (!parse_9(argv[1], rows) || !parse_9(argv[2], cols)) {
        fprintf(stdout, "{\"ok\":false,\"error\":\"bad_input\"}\n");
        return EXIT_FAILURE;
    }

    int sum_r = 0, sum_c = 0;
    for (int i = 0; i < N; i++) { sum_r += rows[i]; sum_c += cols[i]; }
    if (sum_r != sum_c) {
        fprintf(stdout, "{\"ok\":false,\"error\":\"inconsistent_sums\"}\n");
        return EXIT_FAILURE;
    }

    int solution[N][N];
    bool ok = resoudre(rows, cols, solution);
    if (!ok) {
        fprintf(stdout, "{\"ok\":false,\"error\":\"no_solution\"}\n");
        return EXIT_FAILURE;
    }

    Niveau niv;
    memset(&niv, 0, sizeof(niv));
    memcpy(niv.grille, solution, sizeof(solution));
    memcpy(niv.rows, rows, sizeof(rows[0]) * N);
    memcpy(niv.cols, cols, sizeof(cols[0]) * N);
    int len = 0;
    for (int i = 0; i < N; i++) {
        for (int j = 0; j < N; j++) {
            if (solution[i][j] != CASE_VIDE) len++;
        }
    }
    niv.longueur   = len;
    niv.difficulte = -1;
    niv.seed       = 0;

    niveau_to_json(stdout, &niv);
    return EXIT_SUCCESS;
}
