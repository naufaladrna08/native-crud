<?php
/*
 * Begin Licence
 * 
 * Copyright 2020 Rakarak
 *
 * Permission is hereby granted, free of charge, to any person obtaining 
 * a copy of this software and associated documentation files (the "Software"
 * ), to deal in the Software without restriction, including without 
 * limitation the rights to use, copy, modify, merge, publish, distribute, 
 * sublicense, and/or sell copies of the Software, and to permit persons to 
 * whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in 
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS 
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS 
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * End license text. 
*/

/* NEEDED FUNCTION. Actually not needed by PHP but by me. */
function I($src = "") {
    return "Include/" . $src . ".php";
}

function LOAD_LIB($name = "") {
    require_once("Libs/" . $name . ".php");
}

session_start();
define('BASE_URL', 'http://localhost/');

/* THIS IS THE ACTUAL REQUIREMENTS */
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
