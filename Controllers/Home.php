<?php

class Home extends Controller {
  public function __default() {
    global $db;

    if (!isset($_SESSION['LOGGEDUSER'])) {
      header("Location: " . BASE_URL . "index.php?p=Login");
    }

    $this->render('index', [
      'user' => $_SESSION['LOGGEDUSER']
    ]);
  }

  public function logout() {
    unset($_SESSION['LOGGEDUSER']);
    session_destroy();
    header("Location: " . BASE_URL . "index.php?p=Login");
  }
}