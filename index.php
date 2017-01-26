<?php
define('DS', DIRECTORY_SEPARATOR);
define('WEBROOT', "webroot");
define('ROOT', dirname(WEBROOT));
define('CORE', ROOT.DS.'core');
define('CONFIG', ROOT.DS.'model'.DS.'config');
define('BASE_URL', dirname($_SERVER['SCRIPT_NAME']));

require CORE.DS.'includes.php';

$_SERVER['debug'] = 1;
// Creation de la bdd si inexistante
new Database('CamagruDb');

// Parse l'URL et envoi directement sur le bon Controller
new dispatcher();