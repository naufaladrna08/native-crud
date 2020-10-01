<?php
  /*
  * Begin Licence
  * 
  * Copyright 2020 Rakarak
  *
  * Permission is hereby granted, free of charge, to any person obtaining 
  * a copy of this software and associated documentation files (the "Software"), 
  * to deal in the Software without restriction, including without 
  * limitation the rights to use, copy, modify, merge, publish, distribute, 
  * sublicense, and/or sell copies of the Software, and to permit persons to 
  * whom the Software is furnished to do so, subject to the following conditions:
  *
  * The above copyright notice and this permission notice shall be included in 
  * all copies or substantial portions of the Software.
  *
  * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS 
  * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
  * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS 
  * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
  * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
  * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
  *
  * End license text. 
  */

  $isError = false;
  $msg = "";

  if (isset($_SESSION['LOGGEDUSER'])) {
    header("Location: index.php?p=home");
  }

  if (isset($_POST['post'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $stmt = $db->prepare("SELECT * FROM `users` WHERE username=:username AND password=:password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    $num  = $stmt->rowCount();

    if ($num == 1) {
      $_SESSION['UID']        = $rows['user_id'];
      $_SESSION['LOGGEDUSER'] = $username;

      header("Location: index.php?p=home");
    } else {
      $isError = true;
      $msg = "Username or Password is Incorrect. Please try again! Quick, quick!";
    }
  }
?>

<div class="container">
  <?php if (isset($_POST['post']) && $isError == true) { ?>
  <div class="alert alert-danger mt-4" role="alert">
    <?= $msg ?>
  </div>
  <?php } ?>

  <h1 class="mt-4"> Login </h1>

  <form method="POST" action="<?= BASE_URL ?>web/index.php?p=login">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="Username">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    </div>

    <button type="submit" class="btn btn-primary btn-block" name="post">Login</button>
  </form>
</div>