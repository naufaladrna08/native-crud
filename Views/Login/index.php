<div id="root">
  <section id="register" class="banner">
    <h1 class="display-4"> Discover something new today.</h1>
    <p class="lead"> Join us. We change the world. </p>

    <div class="mt-4">
      <input id="newusername" type="text" class="form-control newusername" placeholder="Buat username (Tekan Enter untuk Melanjutkan)">
    </div>
  </div>

  <section id="login">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-md-6">
          <h1> Sign In </h1>
          <form id="login-form" class="form">
            <div class="form-group my-2">
              <label for="username"> Username </label>
              <input type="text" placeholder="John Doe" id="username" name="username" class="form-control">
            </div>
            <div class="form-group my-2">
              <label for="password"> Password </label>
              <input type="password" placeholder="********" id="password" name="password" class="form-control">
            </div>
            <div class="form-group my-2">
              <span class="badge bg-danger mt-2 mb-4" id="error" style="font-size: 14px"></span>
              <button class="btn btn-warning btn-block w-100" id="signin-button"> Sign In </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  html {
    scroll-behavior: smooth;
  }

  .banner {
    color: #fff;
    text-align: center;
    background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1496181133206-80ce9b88a853?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=871&q=80');
    background-size: cover;
    background-attachment: fixed;
    padding: 16em 0;
    height: 100vh;
  }

  #login {
    height: 100vh;
    padding: 12em 0;
    color: #fff;
    background: linear-gradient(156.19deg, #3498DB 41.82%, rgba(41, 128, 185, 0.71) 87.46%);
  }

  .newusername {
    margin: auto;
    width: 60%;
  }

  @media only screen and (max-device-width: 480px) {
    .newusername {
      margin: auto;
      width: 90%;
    }

    #login {
      height: 100vh;
      padding: 6em 0;
      color: #fff;
      background: linear-gradient(156.19deg, #3498DB 41.82%, rgba(41, 128, 185, 0.71) 87.46%);
    }
  }

  @media only screen and (device-width: 768px) {
    .newusername {
      margin: auto;
      width: 90%;
    }

    #login {
      height: 100vh;
      padding: 6em 0;
      color: #fff;
      background: linear-gradient(156.19deg, #3498DB 41.82%, rgba(41, 128, 185, 0.71) 87.46%);
    }
  }
</style>

<script>
  $(document).ready(() => {
    $("a").on('click', function(event) {
      if (this.hash !== "") {
        event.preventDefault()

        var hash = this.hash

        $('html, body').animate({
          scrollTop: $(hash).offset().top
        }, 800, function(){

          window.location.hash = hash
        })
      }
    })

    $('#login-form').on('submit', (e) => {
      e.preventDefault()

      $.ajax({
        url: "<?= BASE_URL ?>index.php?p=login/alogin",
        method: "POST",
        dataType: "JSON",
        data: $('#login-form').serializeArray(),
        beforeSend: (e) => {
          $('#signin-button').html('Loading...')
        },
        success: (resp) => {
          if (resp.code == 200) {
            document.location.href = "<?= BASE_URL ?>index.php?p=home"
          } else if (resp.code == 404) {
            $('#error').html('Username atau password salah')
          } else {
            $('#error').html('Terjadi kesalahan sistem')
          }

          $('#signin-button').html('Sign In')
        }
      })
    })

    $('#newusername').on('keypress', (e) => {      
      if (e.keyCode == 13) {
        e.preventDefault()
        document.location.href = "<?= BASE_URL ?>index.php?p=register/" + $('#newusername').val()
      }
    })
  })
</script>