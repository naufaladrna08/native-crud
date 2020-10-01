<?php
/*
* Begin Licence
* 
* Copyright 2020 Rakarak
*
* Permission is hereby granted, free of charge, to any person obtaining 
* a copy of this software and associated documentation files (the "Software"
* ), to deal in the Software without restriction, including without 
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

require_once("Include/DB.php");

if (isset($_POST)) {
  session_start();

  $attempt    = $_POST['attempt'];
  $correct    = $_POST['correct'];
  $incorrect  = $_POST['incorrect'];
  $uid        = $_SESSION['UID'];
  $percentage = $_POST['percent'];

  $check = $db->prepare("SELECT * FROM `result` WHERE user_id=:userId");
  $check->bindParam(":userId", $uid);
  $check->execute();
  $total = $check->rowCount();

  if ($total < 2) {
    $stmt = $db->prepare("INSERT INTO `result` (result_id, attempt, correct, wrong, percentage, user_id) VALUES (NULL, :attempt, :correct, :incorrect, :percentage, :uid)"); 
    $stmt->bindParam(":attempt", $attempt, PDO::PARAM_INT);
    $stmt->bindParam(":correct", $correct, PDO::PARAM_INT);
    $stmt->bindParam(":incorrect", $incorrect, PDO::PARAM_INT);
    $stmt->bindParam(":percentage", $percentage, PDO::PARAM_STR);
    $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);

    if ($stmt->execute()) {
      exit("success");
    } else {
      exit("failed " . mysqli_error($db) . ' ' . $query);
    }
  } else {
    exit("max_reached");
  }
}