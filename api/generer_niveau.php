<?php
/* =====================================================================
 *  COBRA - api/generer_niveau.php
 * =====================================================================
 *  Appelle le binaire C concepteur.exe avec une difficulte et renvoie
 *  son JSON tel quel au front. JS consomme via fetch('api/generer_niveau.php?diff=1').
 *  Parametres :
 *    diff  : 0 (facile), 1 (moyen), 2 (difficile)  -- defaut 0
 *    seed  : entier optionnel, pour reproduire un niveau
 *
 *  Le binaire doit etre present sous bin/ (cf README).
 * =====================================================================
 */
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

$diff = isset($_GET['diff']) ? (int)$_GET['diff'] : 0;
if ($diff < 0 || $diff > 2) $diff = 0;

$seed = isset($_GET['seed']) ? (int)$_GET['seed'] : 0;

/* On detecte l'extension du binaire selon l'OS */
$bin_dir = realpath(__DIR__ . '/../bin');
if ($bin_dir === false) {
    echo json_encode([
        'ok' => false,
        'error' => 'bin/ folder not found - compile the C binaries first'
    ]);
    exit;
}

$exe = (PHP_OS_FAMILY === 'Windows') ? 'concepteur.exe' : 'concepteur';
$bin = $bin_dir . DIRECTORY_SEPARATOR . $exe;

if (!is_executable($bin) && !file_exists($bin)) {
    echo json_encode([
        'ok' => false,
        'error' => "binary not found at $bin"
    ]);
    exit;
}

/* Construction sure de la commande -- escapeshellarg evite toute
 * injection si jamais on ajoute plus tard des arguments venant du
 * client. */
$cmd  = escapeshellarg($bin);
$cmd .= ' ' . escapeshellarg((string)$diff);
if ($seed > 0) {
    $cmd .= ' ' . escapeshellarg((string)$seed);
}

/* On capture stdout, stderr et le code de retour. */
$descriptors = [
    1 => ['pipe', 'w'],
    2 => ['pipe', 'w'],
];
$process = proc_open($cmd, $descriptors, $pipes);
if (!is_resource($process)) {
    echo json_encode([
        'ok' => false,
        'error' => 'cannot launch the C process'
    ]);
    exit;
}
$stdout = stream_get_contents($pipes[1]); fclose($pipes[1]);
$stderr = stream_get_contents($pipes[2]); fclose($pipes[2]);
$code   = proc_close($process);

/* Le binaire sort deja du JSON. On le passe quasi-tel quel mais on
 * verifie qu'il est bien forme pour eviter de masquer une erreur. */
$decoded = json_decode($stdout, true);
if ($decoded === null) {
    echo json_encode([
        'ok' => false,
        'error' => 'invalid json from concepteur',
        'stdout' => $stdout,
        'stderr' => $stderr,
        'code' => $code
    ]);
    exit;
}
echo $stdout;
