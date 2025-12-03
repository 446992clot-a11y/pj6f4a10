<?php
// error_acces.php (a botiga/gestio/app)

// Només necessitem assegurar la sessió, ja que verificacio_auth.php ja ha redirigit aquí.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accés Denegat</title>
</head>
<body>
    <h1 style="color: red;">❌ ERROR: Accés Denegat</h1>
    <p>Ho sentim, no teniu els permisos necessaris per accedir a la pàgina sol·licitada.</p>
    
<?php 
if (isset($_SESSION['user_id'])): 
?>
<p>El vostre usuari actual (<strong><?php echo htmlspecialchars($_SESSION['nom_usuari']); ?></strong>) amb rol <strong><?php echo htmlspecialchars($_SESSION['rol']); ?></strong> <strong>no està autoritzat</strong> per a aquesta funcionalitat.</p>
<p>Si us plau, <strong>torneu al Tauler de Control</strong> o <strong>tanqueu la sessió</strong>:</p>
<p>
    <a href="tauler_control.php">Anar al Tauler de Control</a> | 
    <a href="tancar_sessio.php">Tancar Sessió</a>
</p>
<?php
else:
?>
<p>Sembla que la vostra sessió ha expirat o no heu iniciat sessió.</p>
<p><a href="inici_sessio.php">Iniciar Sessió</a></p>
<?php endif; ?>

<p><a href="inici_sessio.php">Tornar a la pàgina d'inici de sessió</a></p>

</body>
</html>