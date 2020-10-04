<!DOCTYPE html>
<html lang="en">
<head>    
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <title>Hello, world!</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="Quiz.css">
  <link rel="stylesheet" type="text/css" href="New.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light+Two&display=swap" rel="stylesheet">
  <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand mr-4" href="#"> TKJ </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="?p=home">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="?p=quiz">Quiz</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Visi & Misi
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <div class="p-2"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita, nobis. </div>
            </div>
          </li>
        </ul>
            
        <form class="form-inline my-2 my-lg-0">
          <?php if (!isset($_SESSION['LOGGEDUSER'])) { ?>
          <a href="?p=login" class="btn btn-primary my-2 mr-2 my-sm-0" type="submit">Login</a>
          <a href="?p=register" class="btn btn-outline-success my-2 my-sm-0" type="submit">Register</a>
          <?php } else {  ?>
          <div class="text-white"> Hi, <?= $_SESSION['LOGGEDUSER']; ?>! </div>
          <a href="?p=logout" class="btn btn-danger btn-sm ml-4"> Logout </a>
          <?php } ?>
        </form>
    </div>
  </div>
</nav>
