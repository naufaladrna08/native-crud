<?php
session_destroy();
$_SESSION['LOGGEDUSER'] = "";
header("Location: index.php?p=home");