<?php

require_once 'configuracio.php';
require_once 'utilitats.php';


session_start();

if (isset($_SESSION['rol']) && ($_SESSION['rol'] === 'admin' || $_SESSION['rol'] === 'treballador')) {
    // Usuari ja autenticat, redirigir al tauler de control
    header('Location: tauler_control.php');
    exit;
}

$missatge_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_usuari = $_POST['nom_usuari'] ?? '';
    $contrasenya = $_POST['contrasenya'] ?? '';

    // Validar els requisits del nom d'usuari (4 caràcters)

    if (strlen($nom_usuari) !== 4) {
        $missatge_error = 'El nom d\'usuari ha de tenir exactament 4 caràcters.';
    } else {
        $treballadors = llegirFitxerJson(FITXER_TREBALLADORS);

        if ($treballadors === null) {
            $missatge_error = 'Error llegint les dades dels treballadors.';
        } else {
            $usuari_trobat = null;

            foreach ($treballadors as $usuari) {
                if ($usuari['nom_usuari'] === $nom_usuari) {
                    if (verificarContrasenya($contrasenya, $usuari['hash_contrasenya'])) {
                        $usuari_trobat = $usuari;
                        break;
                    }
                }
            }

            if ($usuari_trobat) {
                // Autenticació exitosa, iniciar sessió
                $_SESSION['user_id'] = $usuari_trobat['id'];
                $_SESSION['nom_usuari'] = $usuari_trobat['nom_usuari'];
                $_SESSION['rol'] = $usuari_trobat['rol'];

                // Redirigir al tauler de control
                header('Location: tauler_control.php');
                exit;
            } else {
                $missatge_error = 'Nom d\'usuari o contrasenya incorrectes.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inici de Sessió</title>
</head>
<body>
    <h2>Inici de Sessió</h2>
    <?php if ($missatge_error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($missatge_error); ?></p>
    <?php endif; ?>
    <form method="POST" action="inici_sessio.php">
        <label for="nom_usuari">Nom d'usuari (4 caràcters):</label>
        <input type="text" id="nom_usuari" name="nom_usuari" required maxlength="4">
        <br>
        <label for="contrasenya">Contrasenya:</label>
        <input type="password" id="contrasenya" name="contrasenya" required>
        <br>
        <button type="submit">Iniciar Sessió</button>
    </form>
</body>
</html>