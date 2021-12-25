<?php

class Profile extends Controller {
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
    global $db;
    $data = null;
    $error = null;

    try {
      if ($username != null) {
        $stmt = $db->prepare("
          SELECT
            * 
          FROM users
          WHERE username = :username
        ");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
          $data = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];
        }

      } else {
        $data = $_SESSION['LOGGEDUSER'][0];
      }
    } catch (PDOException $e) {
      $error = $e->getMessage();
    }

    $this->render('index', [
      'data' => $data,
      'error' => $error
    ]);
  }

  public function getposts() {
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
          aa.created_at,
          bb.username
        FROM
          posts aa
        LEFT JOIN users bb ON aa.uid = bb.user_id
        WHERE is_active = 1
        AND uid = :uid
        ORDER BY aa.created_at DESC
      ");
      $stmt->bindParam(":uid", $_POST['uid']);
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

          if (strlen($v['description']) > 255) {
            $description = substr($v['description'], 0, 255) . ' <a href="'. BASE_URL .'index.php?p=article/'. $v['id'] .'"> <badge class="badge bg-primary ml-2"> Continue Reading </badge> </a>';
          } else {
            $description = $v['description'];
          }

          foreach ($cats as $_c) {
            $_cats .= '<span class="badge rounded-pill bg-primary mr-2">'. $_c['category'] .'</span>';
          }

          $_data .= '
            <div class="row mb-4">
              <div class="col-2 col-sm-2 col-md-1">
                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" width="48" height="48" class="avatar">
              </div>
              <div class="col-10 col-sm-10 col-md-11 content">
                <h5> <a href="'. BASE_URL .'index.php?p=article/'. $v['id'] .'"> '. $v['title'] .' </a> </h5>
                <div class="mb-3"> '. $_cats .'  </div>
                <p class="lead">
                  '. $description .'
                </p>

                <a href="'. BASE_URL .'index.php?p=profile/'. $v['username'] .'">
                  <i class="fas fa-user mr-4"> </i> '. $v['username'] .'
                </a>

                <div class="created-by"> <i class="fas fa-clock ml-2"></i> '. self::time_elapsed_string($v['created_at']) .' </div>
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
}