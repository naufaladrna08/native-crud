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
 * 
 * 
 */

  LOAD_LIB("excel_reader2");
  LOAD_LIB("SpreadsheetReader");

  if (isset($_POST['upload'])) {
    $quid_id = 0;

    /* Quiz data */
    $quiz_tgt = "Temp/" . time() . "-" . basename($_FILES['quiz']['name']);
    move_uploaded_file($_FILES['quiz']['tmp_name'], $quiz_tgt);

    chmod($quiz_tgt, 0777);
  
    $quiz_data = new SpreadsheetReader($quiz_tgt);

    foreach ($quiz_data as $key => $row) {
      if ($key < 1) continue;
      
      $stmt = $db->prepare("INSERT INTO `quizzes` (quiz_id, quiz_title, quiz_description, quiz_thumbnail) VALUES (NULL, :title, :description, :thumbnail)");
      $stmt->bindParam(":title", $row[0]);
      $stmt->bindParam(":description", $row[1]);
      $stmt->bindParam(":thumbnail", $row[2]);
      $stmt->execute();
  
      $stmt = $db->prepare("SELECT * FROM `quizzes` WHERE quiz_title=:title ORDER BY `quiz_id` DESC LIMIT 1");
      $stmt->bindParam(":title", $row[0]);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $quiz_id = $row['quiz_id'];
    }

    /* Question data */
    $question_tgt = "Temp/" . time() . "-" . basename($_FILES['questions']['name']);
    move_uploaded_file($_FILES['questions']['tmp_name'], $question_tgt);

    chmod($question_tgt, 0777);
  
    $question_data = new SpreadsheetReader($question_tgt);

    foreach ($question_data as $key => $row) {
      if ($key < 1) continue;
      
      $stmt2 = $db->prepare("INSERT INTO `questions` (question_id, question_number, question, answers, correct_index, quiz_id) VALUES (NULL, :num, :question, :answers, :correct, :id)");
      $stmt2->bindParam(":num", $row[0]);
      $stmt2->bindParam(":question", $row[1]);
      $stmt2->bindParam(":answers", $row[2]);
      $stmt2->bindParam(":correct", $row[3]);
      $stmt2->bindParam(":id", $quiz_id);
      $stmt2->execute(); 
    }

    /* Lesson */
    $stmt3 = $db->prepare("INSERT INTO `lessons` (lesson_id, lesson, quiz_id) VALUES (NULL, :l, :q)");
    $stmt3->bindParam(":l", $_POST['editor1']);
    $stmt3->bindParam(":q", $quiz_id);
    $stmt3->execute();

    header("Location:" . BASE_URL . "web/index.php?p=quiz");
  }
?>
<div class="container my-4">
  <form method="POST" action="?p=upload" enctype="multipart/form-data">
    <h1> Create a Lesson </h1>
    <textarea name="editor1"></textarea>
    <script>
      CKEDITOR.replace('editor1');
    </script>
    
    <h1 class="mt-4"> Upload a quiz </h1>

    <div class="form-group">
      <label for="quiz"> Quiz (Excel File) </label>
      <input name="quiz" type="file" required="required" class="form-control">
    </div>
    <div class="form-group">
      <label for="questions"> Questions (Excel File) </label>
      <input name="questions" type="file" required="required" class="form-control">
    </div>
    <div class="form-group">
      <input name="upload" type="submit" value="Upload" class="btn btn-primary mt-4">
    </div>
  </form>
</div>