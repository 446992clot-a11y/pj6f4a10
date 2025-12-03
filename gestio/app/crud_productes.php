<?php
require_once 'verificacio_auth.php';
require_once 'utilitats.php';
require_once 'configuracio.php';

verificarAutoritzacio(['admin', 'treballador']);

$metode = obtenirMetodePeticio();
$productes = llegirFitxerJson(FITXER_PRODUCTES);
if ($productes === null) {
    $productes = [];
}

if ($metode === 'POST') {
    // Crear nou producte
    $nom_producte = $_POST['nom_producte'] ?? '';
    $descripcio = $_POST['descripcio'] ?? '';
    $preu = $_POST['preu'] ?? 0;
    $categoria = $_POST['categoria'] ?? '';

    if (empty($nom_producte)) {
        die("El nom del producte és obligatori.");
    }

    // Generar ID
    $nou_id = 1;
    if (!empty($productes)) {
        $ids = array_column($productes, 'id');
        $nou_id = max($ids) + 1;
    }

    $nou_producte = [
        'id' => $nou_id,
        'nom_producte' => $nom_producte,
        'descripcio' => $descripcio,
        'preu' => $preu,
        'categoria' => $categoria
    ];

    $productes[] = $nou_producte;
    if (escriureFitxerJson(FITXER_PRODUCTES, $productes)) {
        header('Location: llista_productes.php');
        exit;
    } else {
        die("Error al guardar les dades.");
    }

} elseif ($metode === 'PUT') {
    // Actualitzar producte
    $id = $_POST['id'] ?? null;
    $nom_producte = $_POST['nom_producte'] ?? '';
    $descripcio = $_POST['descripcio'] ?? '';
    $preu = $_POST['preu'] ?? 0;
    $categoria = $_POST['categoria'] ?? '';

    if (!$id) die("Falta l'ID.");

    $index = -1;
    foreach ($productes as $i => $p) {
        if ($p['id'] == $id) {
            $index = $i;
            break;
        }
    }

    if ($index === -1) die("Producte no trobat.");

    $productes[$index]['nom_producte'] = $nom_producte;
    $productes[$index]['descripcio'] = $descripcio;
    $productes[$index]['preu'] = $preu;
    $productes[$index]['categoria'] = $categoria;

    if (escriureFitxerJson(FITXER_PRODUCTES, $productes)) {
        header('Location: llista_productes.php');
        exit;
    } else {
        die("Error al guardar les dades.");
    }

} elseif ($metode === 'DELETE') {
    // Eliminar producte
    $id = $_POST['id'] ?? null;
    if (!$id) die("Falta l'ID.");

    $productes = array_filter($productes, function($p) use ($id) {
        return $p['id'] != $id;
    });

    // Reindexar array
    $productes = array_values($productes);

    if (escriureFitxerJson(FITXER_PRODUCTES, $productes)) {
        header('Location: llista_productes.php');
        exit;
    } else {
        die("Error al guardar les dades.");
    }
} else {
    die("Mètode no suportat.");
}
?>
