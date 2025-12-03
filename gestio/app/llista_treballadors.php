<?php

require_once 'verificacio_auth.php';
require_once 'utilitats.php';
require_once 'configuracio.php';

verificarAutoritzacio(['admin']);

$treballadors = llegirFitxerJson(FITXER_TREBALLADORS);
if ($treballadors === null) {
    die('Error llegint les dades dels treballadors.');
}

$nom_usuari = $_SESSION['nom_usuari'];
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestió de Treballadors i Administradors</title>
</head>
<body>
    <div>
        Usuari: <strong><?php echo htmlspecialchars($nom_usuari); ?></strong> (<?php echo htmlspecialchars($_SESSION['rol']); ?>) |
        <a href="tancar_sessio.php">Tancar sessió</a>
    </div>

    <h2>Gestió de Treballadors i Administradors (CRUD)</h2>

    <p><a href="formulari_treballador.php"><strong>+ Crear Nou Treballador/Admin</strong></a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom d'usuari (4 caràcters)</th>
                <th>Rol</th>
                <th>Nom complet</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($treballadors as $treballador): ?>
                <tr>
                    <td><?php echo htmlspecialchars($treballador['id']); ?></td>
                    <td><?php echo htmlspecialchars($treballador['nom_usuari']); ?></td>
                    <td><strong><?php echo htmlspecialchars(ucfirst($treballador['rol'])); ?></strong></td>
                    <td><?php echo htmlspecialchars($treballador['nom_complet']); ?></td>
                    <td>
                        <a href="formulari_treballador.php?id=<?php echo $treballador['id']; ?>">Editar (GET)</a> |
                        <form method="POST" action="crud_treballadors.php" style="display:inline;" onsubmit="return confirm('Estàs segur que vols eliminar a <?php echo $treballador['nom_usuari']; ?>?')">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="<?php echo $treballador['id']; ?>">
                            <button type="submit" style="background: none; border: none; color: red; text-decoration: underline; cursor: pointer;">Eliminar (DELETE)</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><a href="tauler_control.php">Tornar al Tauler de Control</a></p>
</body>
</html>