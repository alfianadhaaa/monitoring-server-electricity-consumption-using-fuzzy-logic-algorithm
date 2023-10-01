<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<link rel="stylesheet" href="<?= base_url(); ?>css/bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>css/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>css/buttons.bootstrap5.min.css">

<script src="<?= base_url(); ?>js/jquery.js"></script>
<script src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>

<div id="layoutSidenav_content">
  <div class="container-fluid px-4">
    <div class="container mb-2">
      <div class="row">
        <div class="col">
          <h1 class="mt-2">Report</h1>
        </div>
        <div class="col">
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <!-- Filter -->
        <form action="/report/filter" method="post">
          <div class="container">
            <div class="row mb-3">
              <div class="col-1">
                <label class="col-form-label">Tgl Awal</label>
              </div>
              <div class="col-3">
                <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" value="<?= $tanggal['tgl_awal']; ?>">
              </div>
              <div class="col-1">
                <label class="col-form-label">Tgl Akhir</label>
              </div>
              <div class="col-3">
                <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $tanggal['tgl_akhir']; ?>">
              </div>
              <div class="col-4">
                <button class="btn btn-secondary">Filter</button>
                <a onclick="exportExcel()" class="btn btn-success">Export Excel</a>
                <a target="_blank" onclick="exportPDF()" class="btn btn-danger">Export PDF</a>
              </div>
            </div>
          </div>
        </form>
        <!-- Tabel Laporan -->
        <table id="report" class="table table-striped">
          <thead>
            <tr class="text-center">
              <th scope="col">No</th>
              <th scope="col">Ampere</th>
              <th scope="col">Volt</th>
              <th scope="col">Watt</th>
              <th scope="col">kWh</th>
              <th scope="col">Time</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <?php $i = 1; ?>
            <?php foreach ($device as $d) : ?>
              <tr class="text-center">
                <td scope="row"><?= $i++; ?></td>
                <td><?= $d['ampere']; ?></td>
                <td><?= $d['volt']; ?></td>
                <td><?= $d['watt']; ?></td>
                <td><?= $d['kwh']; ?></td>
                <td><?= $d['created_at']; ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    new DataTable('#report');

    function exportExcel() {
      let tgl1 = $('#tgl_awal').val()
      let tgl2 = $('#tgl_akhir').val()
      window.location.href = "/export-excel/" + tgl1 + "/" + tgl2
    }

    function exportPDF() {
      let tgl1 = $('#tgl_awal').val()
      let tgl2 = $('#tgl_akhir').val()
      let url = "/export-pdf/" + tgl1 + "/" + tgl2;
      window.open(url, "_blank");
    }
  </script>

  <?= $this->endSection(); ?>