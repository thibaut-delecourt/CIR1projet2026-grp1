<?php
/* =====================================================================
 *  COBRA - api/resoudre_niveau.php
 * =====================================================================
 *  Appelle le binaire C solveur.exe sur les indices rows et cols
 *  d'un niveau et renvoie la solution en JSON.
 *
 *  Methode : POST avec un body JSON
 *      { "rows": [r1, r2, ..., r9], "cols": [c1, ..., c9] }
 *  ou GET avec parametres :
 *      ?rows=r1,r2,...,r9&cols=c1,...,c9
 *
 *  Reponse : JSON tel que produit par le binaire solveur.
 * =====================================================================
 */
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function err($msg, $extra = []) {
    echo json_encode(array_merge(['ok' => false, 'error' => $msg], $extra));
    exit;
}

/* --- Recuperation des entrees ---------------------------------------- */
$rows = null;
$cols = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (is_array($data) && isset($data['rows'], $data['cols'])) {
        $rows = $data['rows'];
        $cols = $data['cols'];
    }
} else {
    if (isset($_GET['rows'], $_GET['cols'])) {
        $rows = array_map('intval', explode(',', $_GET['rows']));
        $cols = array_map('intval', explode(',', $_GET['cols']));
    }
}

if (!is_array($rows) || !is_array($cols)
    || count($rows) !== 9 || count($cols) !== 9) {
    err('rows and cols must be arrays of 9 integers');
}

/* On force des entiers et on rejette toute valeur aberrante. */
foreach ($rows as $v) if (!is_numeric($v) || (int)$v < 0 || (int)$v > 9) err('bad row');
foreach ($cols as $v) if (!is_numeric($v) || (int)$v < 0 || (int)$v > 9) err('bad col');

$rows_str = implode(' ', array_map('intval', $rows));
$cols_str = implode(' ', array_map('intval', $cols));

/* --- Localisation du binaire ----------------------------------------- */
$bin_dir = realpath(__DIR__ . '/../bin');
if ($bin_dir === false) err('bin/ folder not found - compile the C binaries first');

$exe = (PHP_OS_FAMILY === 'Windows') ? 'solveur.exe' : 'solveur';
$bin = $bin_dir . DIRECTORY_SEPARATOR . $exe;
if (!file_exists($bin)) err("binary not found at $bin");

/* --- Appel proc_open ------------------------------------------------- */
$cmd  = escapeshellarg($bin)
      . ' ' . escapeshellarg($rows_str)
      . ' ' . escapeshellarg($cols_str);

$descriptors = [
    1 => ['pipe', 'w'],
    2 => ['pipe', 'w'],
];
$process = proc_open($cmd, $descriptors, $pipes);
if (!is_resource($process)) err('cannot launch the C process');

$stdout = stream_get_contents($pipes[1]); fclose($pipes[1]);
$stderr = stream_get_contents($pipes[2]); fclose($pipes[2]);
$code   = proc_close($process);

$decoded = json_decode($stdout, true);
if ($decoded === null) {
    err('invalid json from solveur', [
        'stdout' => $stdout,
        'stderr' => $stderr,
        'code' => $code
    ]);
}
echo $stdout;
