<?php

define('DIRECTORI_ARREL', dirname(dirname(__DIR__)));


define('FITXER_CLIENTS', DIRECTORI_ARREL . '/gestio/clients/clients');
define('FITXER_PRODUCTES', DIRECTORI_ARREL . '/gestio/productes/productes');
define('FITXER_TREBALLADORS', DIRECTORI_ARREL . '/gestio/treballadors/treballadors');

define('LONGITUD_MIN_CONTRASENYA', 8);
define('REQUEREIX_MAJUSCULA', true);
define('REQUEREIX_MINUSCULA', true);
define('REQUEREIX_DIGIT', true);
define('REQUEREIX_SIMBOL', true);

?>