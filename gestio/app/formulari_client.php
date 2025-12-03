<?php
require_once 'verificacio_auth.php';
require_once 'utilitats.php';
require_once 'configuracio.php';

verificarAutoritzacio(['admin', 'treballador']);

$id = $_GET['id'] ?? null;
$client = null;
$titol = "Crear Nou Client";

if ($id) {
    $clients = llegirFitxerJson(FITXER_CLIENTS);
    foreach ($clients as $c) {
        if ($c['id'] == $id) {
            $client = $c;
            $titol = "Editar Client";
            break;
        }
    }
    if (!$client) {
        die("Client no trobat.");
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titol; ?></title>
</head>
<body>
    <h1><?php echo $titol; ?></h1>
    <form action="crud_clients.php" method="POST">
        <?php if ($client): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($client['id']); ?>">
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <label for="nom_client">Nom del Client:</label>
        <input type="text" id="nom_client" name="nom_client" value="<?php echo htmlspecialchars($client['nom_client'] ?? ''); ?>" required>
        <br><br>

        <label for="email">Correu Electrònic:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($client['email'] ?? ''); ?>" required>
        <br><br>

        <label for="telefon">Telèfon:</label>
        <input type="text" id="telefon" name="telefon" value="<?php echo htmlspecialchars($client['telefon'] ?? ''); ?>">
        <br><br>

        <label for="adreca">Adreça:</label>
        <textarea id="adreca" name="adreca"><?php echo htmlspecialchars($client['adreca'] ?? ''); ?></textarea>
        <br><br>

        <button type="submit">Guardar</button>
    </form>
    <p><a href="llista_clients.php">Tornar a la llista</a></p>
</body>
</html>
