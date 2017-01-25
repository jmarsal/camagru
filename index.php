<?php
require("model/config/setup.php");
require("model/router/router.php");
require("controller/controller.php");

$dbName = 'CamagruDb';
$url = $_SERVER['REQUEST_URI'];

$serveur = new Controller($dbName, $url);

