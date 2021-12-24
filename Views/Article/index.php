<div id="root">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <h1> <?= $data['title'] ?> </h1>
        <small> by <?= $data['username'] ?> on <?= $data['created_at'] ?> </small>

        <?php 
        if ($data['username'] == $_SESSION['LOGGEDUSER'][0]['username']) {
        ?>
        <nav class="mt-4">
          <a href="<?= BASE_URL ?>index.php?p=article/update/<?= $data['id'] ?>" class="btn btn-primary btn-sm"> Update </a>
          <a href="<?= BASE_URL ?>index.php?p=article/adelete/<?= $data['id'] ?>" class="btn btn-danger btn-sm"> Delete </a>
        </nav>
        <?php 
        }
        ?>

        <p class="lead mt-2"> <?= $data['description'] ?> </p>
      </div>
      <div class="col-md-3">
        <div id="ad-banner"></div>
        <div id="ad-banner" class="mt-2"></div>
      </div>
    </div>
  </div>
</div>

<style>
  #root {
    padding: 6em 0;
  }

  #ad-banner {
    width: 100%;
    height: 400px;
    background: #ebebeb;
  }
</style>