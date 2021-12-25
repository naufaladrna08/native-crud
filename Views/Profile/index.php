<div id="root">
  <div class="container">
    <?php if ($data != null) { ?>
    <input type="hidden" id="no_error" value="1">
    <div class="row">
      <div class="col-sm-0 col-md-2"></div>
      <div class="col-sm-12 col-md-8">
        <div class="card" style="width: 100%;">
          <img src="https://media.tarkett-image.com/large/TH_24567080_24594080_24596080_24601080_24563080_24565080_24588080_001.jpg" class="card-img-top cover-image" alt="...">
          <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" class="card-img-top avatar-image" alt="...">
          <div class="card-body">
            <h5 class="card-title mt-4"> <?= $data['firstname'] ?> <?= $data['lastname'] ?> (@<?= $data['username'] ?>) </h5>
            <p class="card-text">Any details such as age, occupation or city. Example: 23 y.o. designer from Sans Fransisco</p>
          </div>
        </div>
      </div>
      <div class="col-sm-0 col-md-2"></div>
    </div>

    <div class="row mt-4">
      <div class="col-sm-0 col-md-2"></div>
      <div class="col-sm-12 col-md-8 mt-4" id="posts">

      </div>
      <div class="col-sm-0 col-md-2"></div>
    </div>

    <?php } else { ?>
    <div class="h5">Maaf pengguna tidak ditemukan!</div>
    <?php } ?>
  </div>
</div>

<style>
  #root {
    padding: 6em 0;
  }

  .avatar-image {
    width: 64px;
    height: 64px;
    border: 5px solid white;
    position: absolute;
    margin-top: 140px;
    margin-left: 14px;
  }

  .cover-image {
    height: 180px;
  }

  body {
    font-family: 'Raleway', sans-serif;
  }
</style>

<script>
  $(document).ready(() => {
    if ($('#no_error').val() == 1) {
      $.ajax({
        url: "<?= BASE_URL ?>index.php?p=profile/getposts",
        dataType: "JSON",
        method: "POST",
        data: {
          uid: "<?= $data['user_id'] ?>"
        },
        success: (resp) => {
          if (resp.code == 200) {
            $('#posts').html(resp.data)
          }
        }
      })
    }
  })
</script>