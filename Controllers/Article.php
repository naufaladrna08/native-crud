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
            bb.username
          FROM
            posts aa
          LEFT JOIN users bb ON aa.uid = bb.user_id
          WHERE 
            aa.id = :id
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

  public function update() {
    $this->render('update');

  }

  public function acreate() {
    global $db;
    $data = [];
    $body = $_POST;

    try {
      $category = "1";
      $stmt = $db->prepare("
        INSERT INTO posts (id, uid, title, description, category)
        VALUES (NULL, :uid, :title, :description, :category)
      ");
      $stmt->bindParam(':uid', $_SESSION['id']);
      $stmt->bindParam(':title', $_POST['title']);
      $stmt->bindParam(':description', $_POST['description']);
      $stmt->bindParam(':category', $category);
      
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

  }

  public function adelete() {

  }
}