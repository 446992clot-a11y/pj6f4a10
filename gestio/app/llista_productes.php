<?php
require_once 'verificacio_auth.php';
require_once 'utilitats.php';
require_once 'configuracio.php';

verificarAutoritzacio(['admin', 'treballador']);

$productes = llegirFitxerJson(FITXER_PRODUCTES);
if ($productes === null) {
    $productes = [];
}

$nom_usuari = $_SESSION['nom_usuari'];
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestió de Productes</title>
</head>
<body>
    <div>
        Usuari: <strong><?php echo htmlspecialchars($nom_usuari); ?></strong> (<?php echo htmlspecialchars($_SESSION['rol']); ?>) |
        <a href="tancar_sessio.php">Tancar sessió</a>
    </div>

    <h2>Gestió de Productes (CRUD)</h2>

    <p><a href="formulari_producte.php"><strong>+ Crear Nou Producte</strong></a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Descripció</th>
                <th>Preu</th>
                <th>Categoria</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productes as $producte): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producte['id']); ?></td>
                    <td><?php echo htmlspecialchars($producte['nom_producte']); ?></td>
                    <td><?php echo htmlspecialchars($producte['descripcio']); ?></td>
                    <td><?php echo htmlspecialchars($producte['preu']); ?> €</td>
                    <td><?php echo htmlspecialchars($producte['categoria']); ?></td>
                    <td>
                        <a href="formulari_producte.php?id=<?php echo $producte['id']; ?>">Editar</a> |
                        <form method="POST" action="crud_productes.php" style="display:inline;" onsubmit="return confirm('Estàs segur que vols eliminar el producte <?php echo $producte['nom_producte']; ?>?')">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="<?php echo $producte['id']; ?>">
                            <button type="submit" style="background: none; border: none; color: red; text-decoration: underline; cursor: pointer;">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><a href="tauler_control.php">Tornar al Tauler de Control</a></p>
</body>
</html>
