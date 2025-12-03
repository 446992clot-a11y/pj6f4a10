<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function verificarAutoritzacio(array $rols_permesos) {
    // Verificar si l'usuari està autenticat i té un rol permès
    if (!isset($_SESSION['user_id']) || !in_array($_SESSION['rol'], $rols_permesos)) {
        // Redirigir a la pàgina d'error d'accés
        header('Location: error_acces.php');
        exit;
    }
}

function tancarSessio() {
    // Finalitza la sessió de l'usuari
    $_SESSION = [];
    // Destruir la cookie de sessió si existeix
    session_destroy();
    // Redirigir a l'inici de sessió
    header('Location: inici_sessio.php');
    exit;
}
?>