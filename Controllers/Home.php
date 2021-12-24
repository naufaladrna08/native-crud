<?php

class Home extends Controller {
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
    global $db;

    if (!isset($_SESSION['LOGGEDUSER'])) {
      header("Location: " . BASE_URL . "index.php?p=Login");
    }

    $this->render('index', [
      'user' => $_SESSION['LOGGEDUSER']
    ]);
  }

  public function getarticle() {
    global $db;
    $data = [];

    try {
      $stmt = $db->prepare("
        SELECT
          aa.id,
          aa.uid,
          aa.title,
          aa.description,
          aa.category,
          bb.username
        FROM
          posts aa
        LEFT JOIN users bb ON aa.uid = bb.user_id
      ");
      $stmt->execute();

      $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

      if ($stmt->rowCount() > 0) {
        $_data = '';

        foreach ($posts as $v) {
          $c = str_replace('/', ',', $v['category']);
          $_cats = '';

          $cat = $db->prepare('SELECT category FROM categories WHERE id IN ('. $c .')');
          $cat->execute();
          $cats = $cat->fetchAll(\PDO::FETCH_ASSOC);

          foreach ($cats as $_c) {
            $_cats .= '<span class="badge rounded-pill bg-primary mr-2">'. $_c['category'] .'</span>';
          }

          $_data .= '
            <div class="row mb-4">
              <div class="col-2 col-sm-2 col-md-1">
                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" width="48" height="48" class="avatar">
              </div>
              <div class="col-10 col-sm-10 col-md-11">
                <h5> <a href="'. BASE_URL .'index.php?p=article/'. $v['id'] .'"> '. $v['title'] .' </a> </h5>
                <div class="mb-3"> '. $_cats .'  </div>
                <p class="lead">
                  '. $v['description'] .'
                </p>

                <a href="'. BASE_URL .'index.php?p=profile/'. $v['username'] .'">
                  <i class="fas fa-user mr-4"> </i> '. $v['username'] .'
                </a>
              </div>
            </div>
          ';
        }

        $data = self::Response(200, 'Success', 'Data ditemukan', $_data);
      } else {
        $data = self::Response(404, 'Failed', 'Data tidak ditemukan', null);
      }
    } catch (PDPException $e) {
      $data = self::Response(500, 'Failed', 'Internal Server Error', $e->getMessage());
    }

    header('Content-Type: application/json; charset=utf-8');
    return $this->json($data);
  }

  public function logout() {
    unset($_SESSION['LOGGEDUSER']);
    session_destroy();
    header("Location: " . BASE_URL . "index.php?p=Login");
  }
}