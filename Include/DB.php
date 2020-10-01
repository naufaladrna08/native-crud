<?php

$con = array();

$con['hostname'] = "localhost";
$con['username'] = "admin";
$con['password'] = "1234";
$con['database'] = "acpnepur.sch.id";

try {
  $db = new PDO("mysql:host=$con[hostname];dbname=$con[database]", $con['username'], $con['password']);
  
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}