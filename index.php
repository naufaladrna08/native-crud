<?php
/*
 * Init.
 * See LICENSE
*/

session_start();
define('BASE_URL',  "http://" . $_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"]. '/');
require_once('Include/DB.php');
require_once('Include/Router.php');
require_once('Include/Controller.php');

$app = new App("Controllers/");