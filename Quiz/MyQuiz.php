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

  /* Single Line code to check session. fuck! */
  if ($isLogged == false) { header("Location: index.php?p=home"); } 

  $uid = $_SESSION['UID'];
  $isError = false;

  if (isset($_GET['c'])) {
    $code = $_GET['c'];

    $check = $db->prepare("SELECT * FROM `result` WHERE user_id=:userId AND code=:code");
    $check->bindParam(":userId", $uid);
    $check->bindParam(":code", $code);
    $check->execute();
    $total = $check->rowCount();

    $stmt = $db->prepare("SELECT * FROM `questions` WHERE quiz_id=:quizId");
    $stmt->bindParam(":quizId", $code);
    $stmt->execute();
    $totalQuestion = $stmt->rowCount();

  } else {
    $isError = true;
    $msg = "<div class='container alert alert-danger mt-4'> Invalid or Empty Quiz Code! </div>";
    die($msg);
  }
?>

<link rel="stylesheet" type="text/css" href="Quiz/css/MyQuiz.css">

<div class="home-box custom-box">
  <h3>Instruction:</h3>
  <p>Total number of questions: <?= $totalQuestion ?> </p>
  <p>Attemp: <?= $total ?>/2 </p>

  <?php if ($total < 2) { ?>
  <a type="button" href="?p=work&c=<?= $_GET['c'] ?>" class="btn"> Start Quiz </a>
  <?php } else { ?>
  <button type="button" class="btn" disabled> Max Attempt Reached </button>
  <?php } ?>
</div>
