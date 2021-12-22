<?php
  /*
  * Login page.
  * See LICENSE
  */

class Login extends Controller {

  public static function Response($code, $status, $msg, $dt = []) {
    $data = [
      'code'    => $code,
      'status'  => $status,
      'message' => $msg,
      'data'    => $dt
    ];

    return $data;
  }

  public function __default() {
    $this->title = 'Login Page';

    if (isset($_SESSION['LOGGEDUSER'])) {
      header("Location: " . BASE_URL . "index.php?p=home");
    }

    $this->render('index');
  }

  public function alogin() {
    global $db;

    $req  = $_POST;
    $data = [];

    try {
      $password = md5($req['password']);

      $stmt = $db->prepare("
        SELECT
          *
        FROM 
          users
        WHERE
          username = :username
          AND password = :password");
      $stmt->bindParam(':username', $req['username']);
      $stmt->bindParam(':password', $password);
      $stmt->execute();

      $userdata = $stmt->fetchAll(\PDO::FETCH_ASSOC);

      if (!empty($userdata)) {
        $_SESSION['LOGGEDUSER'] = $userdata;

        $data = self::Response(200, 'Success', 'Data ditemukan', $userdata);
      } else {
        $data = self::Response(404, 'Failed', 'Data tidak ditemukan', null);
      }      

    } catch (PDPException $e) {
      $data = self::Response(500, 'Failed', 'Internal Server Error', $e->getMessage());
    }

    header('Content-Type: application/json; charset=utf-8');
    return $this->json($data);
  }
}