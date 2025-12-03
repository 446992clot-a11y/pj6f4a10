<?php
require_once 'verificacio_auth.php';
require_once 'utilitats.php';
require_once 'configuracio.php';

verificarAutoritzacio(['admin']);

$id = $_GET['id'] ?? null;
$treballador = null;
$titol = "Crear Nou Treballador";

if ($id) {
    $treballadors = llegirFitxerJson(FITXER_TREBALLADORS);
    foreach ($treballadors as $t) {
        if ($t['id'] == $id) {
            $treballador = $t;
            $titol = "Editar Treballador";
            break;
        }
    }
    if (!$treballador) {
        die("Treballador no trobat.");
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
    <form action="crud_treballadors.php" method="POST">
        <?php if ($treballador): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($treballador['id']); ?>">
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <label for="nom_usuari">Nom d'usuari (4 caràcters):</label>
        <input type="text" id="nom_usuari" name="nom_usuari" value="<?php echo htmlspecialchars($treballador['nom_usuari'] ?? ''); ?>" required maxlength="4" minlength="4">
        <br><br>

        <label for="contrasenya">Contrasenya <?php echo $treballador ? '(Deixar en blanc per mantenir)' : ''; ?>:</label>
        <input type="password" id="contrasenya" name="contrasenya" <?php echo $treballador ? '' : 'required'; ?>>
        <br><br>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol" required>
            <option value="treballador" <?php echo ($treballador && $treballador['rol'] === 'treballador') ? 'selected' : ''; ?>>Treballador</option>
            <option value="admin" <?php echo ($treballador && $treballador['rol'] === 'admin') ? 'selected' : ''; ?>>Administrador</option>
        </select>
        <br><br>

        <label for="nom_complet">Nom Complet:</label>
        <input type="text" id="nom_complet" name="nom_complet" value="<?php echo htmlspecialchars($treballador['nom_complet'] ?? ''); ?>" required>
        <br><br>

        <button type="submit">Guardar</button>
    </form>
    <p><a href="llista_treballadors.php">Tornar a la llista</a></p>
</body>
</html>
