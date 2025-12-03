<?php
require_once 'configuracio.php';
require_once 'utilitats.php';

$fitxer = FITXER_TREBALLADORS;

if (!file_exists($fitxer)) {
    $admin = [
        'id' => 1,
        'nom_usuari' => 'admi',
        'hash_contrasenya' => hashContrasenya('Admin123!'),
        'rol' => 'admin',
        'nom_complet' => 'Administrador del Sistema'
    ];

    $dades = [$admin];
    if (escriureFitxerJson($fitxer, $dades)) {
        echo "Usuari 'admi' creat correctament amb contrasenya 'Admin123!'.\n";
    } else {
        echo "Error al crear l'usuari admin.\n";
    }
} else {
    echo "El fitxer de treballadors ja existeix.\n";
}
?>
