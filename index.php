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

/* Simple Routing */
$route = array(
  "home"      => "home",
  "quiz"      => "quiz",
  "startQuiz" => "Quiz/MyQuiz",
  "register"  => "register",
  "login"     => "login",
  "logout"    => "logout",
  "work"      => "work",
  "upload"    => "upload",
  "create"    => "create"
);

if (isset($_GET['p']) && isset($route[$_GET['p']])) {
  $page = $route[$_GET['p']];
} else {
  $page = "home";
}

/* Check user session */
if (isset($_SESSION['LOGGEDUSER'])) {
  $isLogged = true;
} else {
  $isLogged = false;
}

/* Render Page */
require_once("Header.php");
require_once(ucfirst($page) . ".php");
require_once("Footer.php");