<?php
require_once 'verificacio_auth.php';
require_once 'configuracio.php';

// Verificar que l'usuari està autenticat (qualsevol rol)
verificarAutoritzacio(['admin', 'treballador']);

$nom_usuari = $_SESSION['nom_usuari'];
$rol = $_SESSION['rol'];
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tauler de Control</title>
</head>
<body>
    <h1>Benvingut al Tauler de Control</h1>
    <p>Hola, <strong><?php echo htmlspecialchars($nom_usuari); ?></strong>. El teu rol és: <strong><?php echo htmlspecialchars($rol); ?></strong>.</p>

    <nav>
        <ul>
            <?php if ($rol === 'admin'): ?>
                <li><a href="llista_treballadors.php">Gestió de Treballadors</a></li>
            <?php endif; ?>
            <li><a href="llista_clients.php">Gestió de Clients</a></li>
            <li><a href="llista_productes.php">Gestió de Productes</a></li>
            <li><a href="tancar_sessio.php">Tancar Sessió</a></li>
        </ul>
    </nav>
</body>
</html>
