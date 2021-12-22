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

  $stmt = $db->prepare("SELECT * FROM `quizzes`");
  $stmt->execute();
  
  $quizzes = $stmt->fetchAll();
?>

<style>
  #zs p, #zs h5 { color: #222; }
</style>

<section id="landing">
  <div class="container">
    <h1 class="display-4"> Quiz </h1>
    <p class="lead">
      Sebuah Quiz yang mempelajari tentang cara merakit komputer, mengenal dan mempelajari komponen hardware serta fokus mempelajari jaringan.
    </p>

    <section id="zs" class="container">
      <?php 
      if ((isset($_SESSION['LOGGEDUSER'])) && $_SESSION['LOGGEDUSER'] == "root") {
        echo "<a href='?p=upload' class='btn btn-primary btn-block mt-2 mb-4'> Create a Post </a>";
      }
      ?>

      <div class="row mb-4">
        <?php foreach ($quizzes as $quiz): ?>
        <div class="col-12 col-md-3">
          <div class="card">
            <img class="card-img-top" src="<?= $quiz['quiz_thumbnail'] ?>" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title"> <?= $quiz['quiz_title'] ?> </h5>
              <p class="card-text"> <?= $quiz['quiz_description'] ?> </p>
              <a href="?p=lesson&c=<?= $quiz['quiz_id'] ?>" class="btn btn-outline-primary mt-4"> Enroll this Lesson </a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </section>
  </div>
</section>