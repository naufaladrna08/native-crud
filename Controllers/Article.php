<?php

class Article extends Controller {
  public static function Response($code, $status, $msg, $dt = []) {
    $data = [
      'code'    => $code,
      'status'  => $status,
      'message' => $msg,
      'data'    => $dt
    ];

    return $data;
  }

  public function __default($id = null) {
    global $db;

    try {
      $data = [];

      if ($id != null) {
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
          WHERE 
            aa.id = :id
          ORDER BY aa.created_at DESC
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $post = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];
      
        $this->render('index', ['data' => $post]);
      
      } else {
        /* No data */
        $this->render('error', ['type' => 'no_param']);
      }

    } catch (PDOException $e) {
      $this->render('error', ['type' => 'server_error']);
    }
  }

  public function create() {
    $this->render('create');
  }

  public function update($id = null) {
    global $db;
    $error = null;
    $data = null;

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
        WHERE 
          aa.id = :id
        ORDER BY aa.created_at DESC
      ");
      $stmt->bindParam(":id", $id);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];

        if ($data['uid'] != $_SESSION['LOGGEDUSER'][0]['user_id']) {
          header("Location: " . BASE_URL . "index.php?p=home");
        }
      }
    } catch (PDOException $e) {
      $error = $e->getMessage();
    }

    $this->render('update', [
      'error' => $error,
      'data' => $data
    ]);
  }

  public function acreate() {
    global $db;
    $data = [];
    $body = $_POST;

    try {
      $current_date = date("Y-m-d H:i:s");
      $category = "1";
      
      $stmt = $db->prepare("
        INSERT INTO posts (id, uid, title, description, category, created_by, created_at)
        VALUES (NULL, :uid, :title, :description, :category, :created_by, :created_at)
      ");
      $stmt->bindParam(':uid', $_SESSION['LOGGEDUSER'][0]['user_id']);
      $stmt->bindParam(':title', $_POST['title']);
      $stmt->bindParam(':description', $_POST['description']);
      $stmt->bindParam(':category', $category);
      $stmt->bindParam(':created_by', $_SESSION['LOGGEDUSER'][0]['user_id']);
      $stmt->bindParam(':created_at', $current_date);
      
      if ($stmt->execute()) {
        $data = self::Response(200, 'success', 'Data berhasil dibuat', $body);
      } else {
        $data = self::Response(500, 'Failed', 'Internal Server Error', $e->getMessage());
      }

    } catch (PDOException $e) {
      $data = self::Response(500, 'Failed', 'Internal Server Error', $e->getMessage());
    }

    header('Content-Type: application/json; charset=utf-8');
    return $this->json($data);
  }

  public function aupdate() {
    global $db;
    $data = [];

    try {
      $stmt = $db->prepare("
        UPDATE posts SET title = :title, description = :description
        WHERE id = :id
      ");
      $stmt->bindParam(':id', $_POST['id']);
      $stmt->bindParam(':title', $_POST['title']);
      $stmt->bindParam(':description', $_POST['description']);

      if ($stmt->execute()) {
        $data = self::Response('200', 'Success', 'Data berhasil disimpan', null);
      } else {
        $data = self::Response('404', 'Failed', 'Data tidak ditemukan', null);
      }

    } catch (PDOException $e) {
        $data = self::Response('500', 'Failed', 'Internal Server Error', $e->getMessage());
    }

    header('Content-Type: application/json; charset=utf-8');
    return $this->json($data);
  }

  public function adelete() {
    global $db;
    $data = [];

    $id = $_POST['id'];
    $uid = $_POST['uid'];

    if ($uid != $_SESSION['LOGGEDUSER'][0]['user_id']) {
      header("Location: " . BASE_URL . "index.php?p=home");
    }

    try {
      $stmt = $db->prepare("
        UPDATE posts SET is_active=0 WHERE id=:id
      ");
      $stmt->bindParam(':id', $id);

      if ($stmt->execute()) {
        $data = self::Response('200', 'Success', 'Data berhasil disimpan', null);
      } else {
        $data = self::Response('404', 'Failed', 'Data tidak ditemukan', null);
      }

    } catch (PDOException $e) {
        $data = self::Response('500', 'Failed', 'Internal Server Error', $e->getMessage());
    }

    header('Content-Type: application/json; charset=utf-8');
    return $this->json($data);
  }
}