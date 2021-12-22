<section id="register">
  <div class="container">
    <h1> Selamat datang, <?= $username ?>! </h1>

    <p class="lead">
      Kami memerlukan beberapa informasi darimu untuk melanjutkan.
    </p>

    <form id="register-form">
      <input type="hidden" name="username" id="username" value="<?= $username ?>"">
      <div class="form-group" id="first">
        <label for="password" class="my-2"> Buat kata sandi untuk akunmu </label>
        <input type="password" name="password" id="password" placeholder="Rahasia" class="form-control">
        <span class="badge bg-danger mt-2 mb-4" id="pwerror" style="font-size: 14px"></span>
      </div>
      <div class="form-group row" id="second">
        <div class="col-sm-12 col-md-6">
          <label for="firstname" class="my-2"> Nama Awal </label>
          <input type="text" name="firstname" id="firstname" placeholder="John" class="form-control">
        </div>
        <div class="col-sm-12 col-md-6">
          <label for="lastname" class="my-2"> Nama Akhir </label>
          <input type="text" name="lastname" id="lastname" placeholder="Doe" class="form-control">
        </div>
        <div class="col-md-12">
          <span class="badge bg-danger mt-2 mb-4" id="nmerror" style="font-size: 14px"></span>
        </div>
      </div>
      <div class="form-group mt-4">
        <button id="next" class="btn btn-warning btn-block w-100" step="0"> Selanjutnya </button>
      </div>
    </form>
  </div>
</section>

<style>
  .container {
    width: 50%;
  }

  #register {
    padding: 12em 0;
    height: 100vh;
    color: #fff;
    background: linear-gradient(156.19deg, #3498DB 41.82%, rgba(41, 128, 185, 0.71) 87.46%);
  }

  @media only screen and (max-device-width: 480px) {
    .container {
      width: 98%;
    }

    #register {
      padding: 6em 0;
    }
  }

  @media only screen and (device-width: 768px) {
    .container {
      width: 98%;
    }

    #register {
      padding: 6em 0;
    }
  }
</style>

<script>
  $(document).ready(() => {
    $('#second').hide()

    $('#next').on('click', (e) => {
      e.preventDefault()
      let step = $('#next').attr('step')
      
      if ($('#password').val().length < 8) {
        $('#pwerror').html('Kata sandi harus lebih dari 8 karakter')
        return false
      }

      if (step == 0) {
        $('#first').hide()
        $('#second').show()

        $('#next').html('Sign Up')
      } else if (step == 1) {
        if ($('#firstname').val().length < 3) {
          $('#nmerror').html('Nama Awal harus lebih dari 3 karakter')
          return false
        }

        if ($('#lastname').val().length < 3) {
          $('#nmerror').html('Nama Akhir harus lebih dari 3 karakter')
          return false
        }

        /* Send */
        $.ajax({
          url: "<?= BASE_URL ?>index.php?p=register/aregister",
          method: "POST",
          dataType: "JSON",
          data: $('#register-form').serializeArray(),
          beforeSend: (e) => {
            $('#next').html('Loading...')
          },
          success: (resp) => {
            if (resp.code == 200) {
              document.location.href = "<?= BASE_URL ?>index.php?p=home"
            } else if (resp.code == 404) {
              $('#error').html('Username atau password salah')
            } else {
              $('#error').html('Terjadi kesalahan sistem')
            }

            $('#next').html('Sign Up')
          }
        })
      } else {
        return false
      }

      $('#next').attr('step', parseInt(step) + 1)
    })
  })
</script>