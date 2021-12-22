<?php
/*
 * Init.
 * See LICENSE
*/

function I($src = "") {
  return "Include/" . $src . ".php";
}

function LOAD_LIB($name = "") {
  require_once("Libs/" . $name . ".php");
}

session_start();
define('BASE_URL', 'http://localhost/tkjconnect/');
require_once(I("DB"));
require_once('./vs-router.php');

$app = new App("Controllers/");