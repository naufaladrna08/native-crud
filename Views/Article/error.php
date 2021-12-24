<div id="root">
  <div class="container">
    <?php if ($type == 'no_param') { ?>
    <div class="text-center display-4">
      Oops, artikel tidak ditemukan.
      <p class="lead mt-4">
        Kunjungi <a href="<? BASE_URL ?>index.php?p=home">Halaman Utama</a> untuk mencari artikel.
      </p>
    </div>
    <?php } else if ($type == 'server_error') { ?>
      <div class="text-center display-4">
      Internal Server Error
    </div>
    <?php } ?>
  </div>
</div>

<style>
  #root {
    padding: 8em 0;
  }
</style>