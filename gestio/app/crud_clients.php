<?php
require_once 'verificacio_auth.php';
require_once 'utilitats.php';
require_once 'configuracio.php';

verificarAutoritzacio(['admin', 'treballador']);

$metode = obtenirMetodePeticio();
$clients = llegirFitxerJson(FITXER_CLIENTS);
if ($clients === null) {
    $clients = [];
}

if ($metode === 'POST') {
    // Crear nou client
    $nom_client = $_POST['nom_client'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefon = $_POST['telefon'] ?? '';
    $adreca = $_POST['adreca'] ?? '';

    if (empty($nom_client) || empty($email)) {
        die("El nom i l'email són obligatoris.");
    }

    // Generar ID
    $nou_id = 1;
    if (!empty($clients)) {
        $ids = array_column($clients, 'id');
        $nou_id = max($ids) + 1;
    }

    $nou_client = [
        'id' => $nou_id,
        'nom_client' => $nom_client,
        'email' => $email,
        'telefon' => $telefon,
        'adreca' => $adreca
    ];

    $clients[] = $nou_client;
    if (escriureFitxerJson(FITXER_CLIENTS, $clients)) {
        header('Location: llista_clients.php');
        exit;
    } else {
        die("Error al guardar les dades.");
    }

} elseif ($metode === 'PUT') {
    // Actualitzar client
    $id = $_POST['id'] ?? null;
    $nom_client = $_POST['nom_client'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefon = $_POST['telefon'] ?? '';
    $adreca = $_POST['adreca'] ?? '';

    if (!$id) die("Falta l'ID.");

    $index = -1;
    foreach ($clients as $i => $c) {
        if ($c['id'] == $id) {
            $index = $i;
            break;
        }
    }

    if ($index === -1) die("Client no trobat.");

    $clients[$index]['nom_client'] = $nom_client;
    $clients[$index]['email'] = $email;
    $clients[$index]['telefon'] = $telefon;
    $clients[$index]['adreca'] = $adreca;

    if (escriureFitxerJson(FITXER_CLIENTS, $clients)) {
        header('Location: llista_clients.php');
        exit;
    } else {
        die("Error al guardar les dades.");
    }

} elseif ($metode === 'DELETE') {
    // Eliminar client
    $id = $_POST['id'] ?? null;
    if (!$id) die("Falta l'ID.");

    $clients = array_filter($clients, function($c) use ($id) {
        return $c['id'] != $id;
    });

    // Reindexar array
    $clients = array_values($clients);

    if (escriureFitxerJson(FITXER_CLIENTS, $clients)) {
        header('Location: llista_clients.php');
        exit;
    } else {
        die("Error al guardar les dades.");
    }
} else {
    die("Mètode no suportat.");
}
?>
