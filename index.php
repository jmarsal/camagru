<?php
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('WEBROOT', "webroot");
define('ROOT', dirname(WEBROOT));
define('CORE', ROOT.DS.'core');
define('CONFIG', ROOT.DS.'model'.DS.'config');
define('BASE_URL', dirname($_SERVER['SCRIPT_NAME']));
define('CSS_DEFAULT', BASE_URL.DS.'webroot'.DS.'css'.DS.'style.css');

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once CORE.DS.'includes.php';

$_SERVER['debug'] = 0;

// Creation de la bdd si inexistante
$conf = Conf::$databases['default'];
new Database($conf, $conf['database']);

// Parse l'URL et envoi directement sur le bon Controller
new dispatcher();