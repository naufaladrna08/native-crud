<?php
  $isError = false;
  $msg = "";

  if (isset($_SESSION['LOGGEDUSER'])) {
    header("Location: index.php?p=home");
  }

  if (isset($_POST['post'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $check = $db->prepare("SELECT * FROM `users` WHERE username=:username");
    $check->bindParam(":username", $username);
    $check->execute();
    $num = $check->rowCount();

    if ($num < 1) {
      $isError = false;
      $msg = "User has been added. Please <a href='index.php?p=login'> login </a> to continue";

      $stmt = $db->prepare("INSERT INTO `users` (user_id, username, password) VALUES (NULL, :username, :password)");
      $stmt->bindParam(":username", $username);
      $stmt->bindParam(":password", $password);
      $stmt->execute();
    } else {
      $isError = true;
      $msg = "Username is already exist!";
    }
  }
?>

<div class="container">
  <?php if (isset($_POST['post'])) { if ($isError == true) { ?>
  <div class="alert alert-danger mt-4" role="alert">
    <?= $msg ?>
  </div>
  <?php } else { ?>
  <div class="alert alert-success mt-4" role="alert">
    <?= $msg ?>
  </div>
  <?php } } ?>

  <h1 class="mt-4"> Register </h1>

  <form method="POST" action="<?= BASE_URL ?>web/index.php?p=register">
    <div class="form-group">
      <label for="exampleInputEmail1">Username</label>
      <input type="text" class="form-control" name="username" placeholder="Username">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary btn-block" name="post"> Register </button>
  </form>
</div>