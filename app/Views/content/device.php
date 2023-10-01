<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<div id="layoutSidenav_content">
  <div class="container-fluid px-4">
    <div class="container mb-2">
      <div class="row">
        <div class="col">
          <h1 class="mt-2">Device</h1>
        </div>
        <div class="col mt-3 text-end">
          <a href="/device/create">
            <button type="button" class="btn btn-primary">
              Add Device
            </button>
          </a>
        </div>
      </div>
    </div>

    <!-- Notifikasi -->
    <?php if (session()->getFlashdata('message')) : ?>
      <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('message'); ?>
      </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('danger')) : ?>
      <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('danger'); ?>
      </div>
    <?php endif; ?>

    <table class="table table-bordered">
      <thead>
        <tr class="text-center">
          <th scope="col">No</th>
          <th scope="col">ID Device</th>
          <th scope="col">Name</th>
          <th scope="col">Brand</th>
          <th scope="col">Ip Address</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <?php $i = 1; ?>
        <?php foreach ($devices as $device) : ?>
          <tr class="text-center">
            <th scope="row"><?= $i++; ?></th>
            <td><?= $device['id_device']; ?></td>
            <td><?= $device['name']; ?></td>
            <td><?= $device['brand']; ?></td>
            <td><?= $device['ip_address']; ?></td>
            <td>
              <form action="/device/<?= $device['id_device']; ?>" method="post" class="d-inline">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda Yakin akan Menghapus Device ?')">Delete</button>
              </form>
              <a href="/device/edit/<?= $device['id_device']; ?>" class="btn btn-warning btn-sm">Edit</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 3000);
  </script>

  <?= $this->endSection(); ?>