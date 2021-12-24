<div id="root">
  <div class="container">
    <h1> <?= $data['title'] ?> </h1>
    <small> by <?= $data['username'] ?> </small>

    <p class="lead mt-4"> <?= $data['description'] ?> </p>
  </div>
</div>

<style>
  #root {
    padding: 6em 0;
  }

</style>