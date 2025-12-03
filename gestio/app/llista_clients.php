<?php
require_once 'verificacio_auth.php';
require_once 'utilitats.php';
require_once 'configuracio.php';

verificarAutoritzacio(['admin', 'treballador']);

$clients = llegirFitxerJson(FITXER_CLIENTS);
if ($clients === null) {
    $clients = [];
}

$nom_usuari = $_SESSION['nom_usuari'];
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestió de Clients</title>
</head>
<body>
    <div>
        Usuari: <strong><?php echo htmlspecialchars($nom_usuari); ?></strong> (<?php echo htmlspecialchars($_SESSION['rol']); ?>) |
        <a href="tancar_sessio.php">Tancar sessió</a>
    </div>

    <h2>Gestió de Clients (CRUD)</h2>

    <p><a href="formulari_client.php"><strong>+ Crear Nou Client</strong></a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Telèfon</th>
                <th>Adreça</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?php echo htmlspecialchars($client['id']); ?></td>
                    <td><?php echo htmlspecialchars($client['nom_client']); ?></td>
                    <td><?php echo htmlspecialchars($client['email']); ?></td>
                    <td><?php echo htmlspecialchars($client['telefon']); ?></td>
                    <td><?php echo htmlspecialchars($client['adreca']); ?></td>
                    <td>
                        <a href="formulari_client.php?id=<?php echo $client['id']; ?>">Editar</a> |
                        <form method="POST" action="crud_clients.php" style="display:inline;" onsubmit="return confirm('Estàs segur que vols eliminar el client <?php echo $client['nom_client']; ?>?')">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
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
