<div id="root">
  <div class="container">
    <div class="row">
      <div class="col-md-9 content">
        <h1> <?= $data['title'] ?> </h1>
        <small> by <?= $data['username'] ?> on <?= $data['created_at'] ?> </small>

        <?php 
        if ($data['username'] == $_SESSION['LOGGEDUSER'][0]['username']) {
        ?>
        <nav class="mt-4">
          <button id="update-button" class="btn btn-primary btn-sm"> Update </a>
          <button id="delete-button" class="btn btn-danger btn-sm mx-2"> Delete </a>
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

<script>
  $(document).ready(() => {
    $('#update-button').on('click', (e) => {
      document.location.href = "<?= BASE_URL ?>index.php?p=article/update/<?= $data['id'] ?>"
    })

    $('#delete-button').on('click', (e) => {
      Swal.fire({
        title: 'Are you sure to delete this article?',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?= BASE_URL ?>index.php?p=article/adelete",
            method: "POST",
            dataType: "JSON",
            data: {
              id: "<?= $data['id'] ?>",
              uid: "<?= $data['uid'] ?>"
            },
            beforeSend: () => {
              Swal.showLoading()
            },
            success: (resp) => {
              Swal.close()

              if (resp.code == 200) {
                document.location.href = "<?= BASE_URL ?>index.php?p=home"
              }
            }
          })
        }
      })
    })
  })
</script>