<div id="root">
  <div class="container my-4">
    <div class="col-sm-12 col-md-8">
      <h4> Discover new Articles </h4>

      <div id="post"></div>
    </div>
    <div class="col-sm-12 col-md-4">

    </div>
  </div>
</div>

<style>
  #root {
    padding: 2em 0;
  }

  body {
    font-family: 'Raleway', sans-serif;
  }
</style>

<script>
  $(document).ready(() => {
    $.ajax({
      url: "<?= BASE_URL ?>index.php?p=home/getarticle",
      dataType: "JSON",
      beforeSend: () => {
        $('#post').html('Loading...')
      },
      success: (resp) => {
        if (resp.code != 200) {
          $('#post').html('Oops, artikelnya masih kosong nih. Ayo bikin artikel baru!.')
        } else {
          $('#post').html(resp.data)
        }
      }
    })
  })
</script>