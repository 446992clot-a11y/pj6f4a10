<?php
require_once 'verificacio_auth.php';
require_once 'utilitats.php';
require_once 'configuracio.php';

verificarAutoritzacio(['admin', 'treballador']);

$id = $_GET['id'] ?? null;
$producte = null;
$titol = "Crear Nou Producte";

if ($id) {
    $productes = llegirFitxerJson(FITXER_PRODUCTES);
    foreach ($productes as $p) {
        if ($p['id'] == $id) {
            $producte = $p;
            $titol = "Editar Producte";
            break;
        }
    }
    if (!$producte) {
        die("Producte no trobat.");
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
    <form action="crud_productes.php" method="POST">
        <?php if ($producte): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($producte['id']); ?>">
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <label for="nom_producte">Nom del Producte:</label>
        <input type="text" id="nom_producte" name="nom_producte" value="<?php echo htmlspecialchars($producte['nom_producte'] ?? ''); ?>" required>
        <br><br>

        <label for="descripcio">Descripció:</label>
        <textarea id="descripcio" name="descripcio"><?php echo htmlspecialchars($producte['descripcio'] ?? ''); ?></textarea>
        <br><br>

        <label for="preu">Preu (€):</label>
        <input type="number" id="preu" name="preu" step="0.01" value="<?php echo htmlspecialchars($producte['preu'] ?? ''); ?>" required>
        <br><br>

        <label for="categoria">Categoria:</label>
        <input type="text" id="categoria" name="categoria" value="<?php echo htmlspecialchars($producte['categoria'] ?? ''); ?>">
        <br><br>

        <button type="submit">Guardar</button>
    </form>
    <p><a href="llista_productes.php">Tornar a la llista</a></p>
</body>
</html>
