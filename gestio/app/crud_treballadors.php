<?php
require_once 'verificacio_auth.php';
require_once 'utilitats.php';
require_once 'configuracio.php';

verificarAutoritzacio(['admin']);

$metode = obtenirMetodePeticio();
$treballadors = llegirFitxerJson(FITXER_TREBALLADORS);
if ($treballadors === null) {
    $treballadors = [];
}

if ($metode === 'POST') {
    // Crear nou treballador
    $nom_usuari = $_POST['nom_usuari'] ?? '';
    $contrasenya = $_POST['contrasenya'] ?? '';
    $rol = $_POST['rol'] ?? 'treballador';
    $nom_complet = $_POST['nom_complet'] ?? '';

    // Validacions bàsiques
    if (strlen($nom_usuari) !== 4) {
        die("El nom d'usuari ha de tenir 4 caràcters.");
    }
    if (!esContrasenyaSegura($contrasenya)) {
        die("La contrasenya no compleix els requisits de seguretat.");
    }

    // Comprovar duplicats
    foreach ($treballadors as $t) {
        if ($t['nom_usuari'] === $nom_usuari) {
            die("El nom d'usuari ja existeix.");
        }
    }

    // Generar ID
    $nou_id = 1;
    if (!empty($treballadors)) {
        $ids = array_column($treballadors, 'id');
        $nou_id = max($ids) + 1;
    }

    $nou_treballador = [
        'id' => $nou_id,
        'nom_usuari' => $nom_usuari,
        'hash_contrasenya' => hashContrasenya($contrasenya),
        'rol' => $rol,
        'nom_complet' => $nom_complet
    ];

    $treballadors[] = $nou_treballador;
    if (escriureFitxerJson(FITXER_TREBALLADORS, $treballadors)) {
        header('Location: llista_treballadors.php');
        exit;
    } else {
        die("Error al guardar les dades.");
    }

} elseif ($metode === 'PUT') {
    // Actualitzar treballador
    $id = $_POST['id'] ?? null;
    $nom_usuari = $_POST['nom_usuari'] ?? '';
    $contrasenya = $_POST['contrasenya'] ?? '';
    $rol = $_POST['rol'] ?? '';
    $nom_complet = $_POST['nom_complet'] ?? '';

    if (!$id) die("Falta l'ID.");

    $index = -1;
    foreach ($treballadors as $i => $t) {
        if ($t['id'] == $id) {
            $index = $i;
            break;
        }
    }

    if ($index === -1) die("Treballador no trobat.");

    // Validar nom d'usuari (si canvia)
    if ($treballadors[$index]['nom_usuari'] !== $nom_usuari) {
         if (strlen($nom_usuari) !== 4) {
            die("El nom d'usuari ha de tenir 4 caràcters.");
        }
        foreach ($treballadors as $t) {
            if ($t['nom_usuari'] === $nom_usuari) {
                die("El nom d'usuari ja existeix.");
            }
        }
    }

    $treballadors[$index]['nom_usuari'] = $nom_usuari;
    $treballadors[$index]['rol'] = $rol;
    $treballadors[$index]['nom_complet'] = $nom_complet;

    if (!empty($contrasenya)) {
        if (!esContrasenyaSegura($contrasenya)) {
            die("La contrasenya no compleix els requisits de seguretat.");
        }
        $treballadors[$index]['hash_contrasenya'] = hashContrasenya($contrasenya);
    }

    if (escriureFitxerJson(FITXER_TREBALLADORS, $treballadors)) {
        header('Location: llista_treballadors.php');
        exit;
    } else {
        die("Error al guardar les dades.");
    }

} elseif ($metode === 'DELETE') {
    // Eliminar treballador
    $id = $_POST['id'] ?? null;
    if (!$id) die("Falta l'ID.");

    $treballadors = array_filter($treballadors, function($t) use ($id) {
        return $t['id'] != $id;
    });

    // Reindexar array
    $treballadors = array_values($treballadors);

    if (escriureFitxerJson(FITXER_TREBALLADORS, $treballadors)) {
        header('Location: llista_treballadors.php');
        exit;
    } else {
        die("Error al guardar les dades.");
    }
} else {
    die("Mètode no suportat.");
}
?>
