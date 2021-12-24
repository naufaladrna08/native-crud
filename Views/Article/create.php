<div id="root">
  <div class="container">
    <h1> Create your own article </h1>

    <form id="form-create">
      <div class="form-group my-2">
        <label for="title" class="my-2"> Article Title </label>
        <input type="text" name="title" id="title" placeholder="Membuat Sendok dari Kardus" class="form-control">
      </div>
      <div class="form-group my-2">
        <label for="description" class="my-2"> Content </label>
        <textarea name="description" class="form-control"></textarea>
      </div>
      <div class="form-group my-2">
        <label id="error" class="my-2 text-danger"> </label> <br>
        <button class="btn btn-primary" id="upload-button"> Upload </button>
      </div>
    </form>
  </div>
</div>

<style>
  #root {
    padding: 6em 0;
  }
</style>
<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
<script>
  $(document).ready(() => {
    CKEDITOR.replace('description')

    $('#form-create').on('submit', (e) => {
      e.preventDefault()
      console.log()

      if (CKEDITOR.instances.description.getData() == '' ||
          $('#title').val() == '') {
        $('#error').html('Judul dan konten wajib diisi')
        return false
      }

      $.ajax({
        url: "<?= BASE_URL ?>index.php?p=article/acreate",
        method: "POST",
        data: {
          title: $('#title').val(),
          description: CKEDITOR.instances.description.getData()
        },
        dataType: "JSON",
        beforeSend: () => {
          $('#upload-button').html("Loading...")
        },
        success: (resp) => {
          if (resp.code == 200) {
            document.location.href = "<?= BASE_URL ?>index.php?p=home"
          }
        }
      })
    })
  })
</script>