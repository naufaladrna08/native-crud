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

<div class="quiz-box custom-box">
  <div class="question-number">

  </div>
  <div class="question-text" id="question" num="0">

  </div>
  <div class="option-container">

  </div>
  <div class="next-question-btn">
      <button type="button" class="btn" onclick="next()">Next</button>
  </div>
  <div class="answers-indicator">

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>web/Quiz/js/app.js?<?= time() ?>"></script>
<script type="text/javascript">
  (function() {
    const questionBox   = document.getElementById("question")
    const currentNumber = questionBox.getAttribute("num")

    let questionCounter = 0

    const get_data = () => {
      axios.get("<?= BASE_URL ?>web/GetQuestions.php?c=<?= $_GET['c'] ?>&n=" + questionCounter)
      .then(function (response) {
        /* first question */
        
        questionBox.innerHTML = response.data.q
      })
    }

    get_data()
  })()
</script>