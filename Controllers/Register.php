<?php

class Register extends Controller {
  public static function Response($code, $status, $msg, $dt = []) {
    $data = [
      'code'    => $code,
      'status'  => $status,
      'message' => $msg,
      'data'    => $dt
    ];

    return $data;
  }

  public function __default($username = null) {
    if (isset($_SESSION['LOGGEDUSER'])) {
      header("Location: index.php?p=home");
    }
 
    $this->render('index', [
      'username' => $username
    ]);
  }

  public function aregister() {
    global $db;

    $data = [];

    try {
      $username = $_POST['username'];
      $password = md5($_POST['password']);
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
  
      $check = $db->prepare("SELECT * FROM `users` WHERE username=:username");
      $check->bindParam(":username", $username);
      $check->execute();
      $num = $check->rowCount();
  
      if ($num < 1) {
        $isError = false;
        
        $stmt = $db->prepare("INSERT INTO `users` (user_id, username, password, firstname, lastname) VALUES (NULL, :username, :password, :firstname, :lastname)");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":firstname", $firstname);
        $stmt->bindParam(":lastname", $lastname);
        $stmt->execute();

        $userdata = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $_SESSION['LOGGEDUSER'] = $userdata;

        $data = self::Response(200, 'Success', 'Data berhasil dibuat', $userdata);
      } else {
        $data = self::Response(404, 'Failed', 'User sudah ada', null);
      }
    } catch (PDOException $e) {
      $data = self::Response(500, 'Failed', 'Internal Server Error', $e->getMessage());
    }

    header('Content-Type: application/json; charset=utf-8');
    return $this->json($data);
  }
}