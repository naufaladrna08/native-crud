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

require_once("Include/DB.php");

if (isset($_GET['c'])) {
  $code = $_GET['c'];
  $num  = $_GET['n'] + 1; 

  $stmt = $db->prepare("SELECT * FROM `questions` WHERE quiz_id=:code AND question_number=:number");
  $stmt->bindParam(":code", $code);
  $stmt->bindParam(":number", $num);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $return = array(
    "q" => $result['question'],
    "a" => explode('; ', $result['answers'])
  );
 
  exit(json_encode($return));
} else {
  exit("code_404");
}