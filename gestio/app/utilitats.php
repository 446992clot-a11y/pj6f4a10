<?php

require_once 'configuracio.php';

// Gestió dels mètodes HTTP i spoofing

function obtenirMetodePeticio() {
    $metode = $_SERVER['REQUEST_METHOD'];
    // L'spoofing només s'aplica si el mètode original és POST
    if ($metode === 'POST') {
        // Comprovar si hi ha un camp ocult que indica PUT o DELETE
        $metode_spoofing = strtoupper($_POST ['_method'] ?? '');
        if (in_array($metode_spoofing, ['PUT', 'DELETE'])) {
            return $metode_spoofing;
        }
    }

    return $metode; // Si no hi ha spoofing, retornar el mètode original
}

// -----------------------------------------------------
// Seguretat de les contrasenyes
// -----------------------------------------------------

function esContrasenyaSegura(string $contrasenya): bool {
    if (strlen($contrasenya) < LONGITUD_MIN_CONTRASENYA) {
        return false;
    }

    if (REQUEREIX_MAJUSCULA && !preg_match('/[A-Z]/', $contrasenya)) {
        return false;
    }

    if (REQUEREIX_MINUSCULA && !preg_match('/[a-z]/', $contrasenya)) {
        return false;
    }

    if (REQUEREIX_DIGIT && !preg_match('/[0-9]/', $contrasenya)) {
        return false;
    }

    if (REQUEREIX_SIMBOL && !preg_match('/[\W_]/', $contrasenya)) {
        return false;
    }

    return true;
}

// Funció per fer hash de la contrasenya
function hashContrasenya(string $contrasenya): string {
    return password_hash($contrasenya, PASSWORD_BCRYPT);
}

// Funció per verificar la contrasenya
function verificarContrasenya(string $contrasenya, string $hash): bool {
    return password_verify($contrasenya, $hash);
}

// -----------------------------------------------------
// Gestió de fitxers JSON
// -----------------------------------------------------

function llegirFitxerJson(string $ruta_fitxer): ?array {
    if (!file_exists($ruta_fitxer)) {
        // Si el fitxer no existeix, retornar un array buit
        return [];
    }

    $contingut = file_get_contents($ruta_fitxer);
    if ($contingut === false) {
        return null;
    }   
    // Si el fitxer està buit, retornar un array buit per evitar errors de json_decode
    if (trim($contingut) === '') {
        return [];
    }

    $dades = json_decode($contingut, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return null; // Retornem null en cas d'error
    }
    return $dades;
}

function escriureFitxerJson(string $ruta_fitxer, array $dades): bool {
    $contingutJson = json_encode($dades, JSON_PRETTY_PRINT);
    if ($contingutJson === false) {
        return false; // Error al codificar a JSON
    }

    $dir = dirname($ruta_fitxer);
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0770, true)) {
            return false; 
        }
    }

    // Escriure el contingut JSON al fitxer amb bloqueig exclusiu
    if (file_put_contents($ruta_fitxer, $contingutJson, LOCK_EX) === false) {
        return false; 
    }

    return true;
}
?>