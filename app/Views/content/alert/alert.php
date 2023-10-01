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
        <h1 class="mt-2 mb-3">Alert</h1>
        <div class="card">
            <div class="card-body">
                <!-- Filter -->
                <form action="/alert/filter" method="post">
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
                            <th scope="col">Type Alert</th>
                            <th scope="col">Time Alert</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php $i = 1; ?>
                        <?php foreach ($alert as $a) : ?>
                            <tr class="text-center">
                                <td scope="row"><?= $i++; ?></td>
                                <td><?= $a['ampere']; ?></td>
                                <td><?= $a['volt']; ?></td>
                                <td><?= $a['type_alert']; ?></td>
                                <td><?= $a['time_alert']; ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Card Alert -->
        <div class="row mt-3">
            <div class="col-xl-4 col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-warning bg-gradient text-white">Volt</div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td rowspan="2" class="align-middle">1</td>
                                <td>Rendah</td>
                                <td>:</td>
                                <td>200 V - 220 V</td>
                            </tr>
                            <tr>
                                <td>Puncak</td>
                                <td>:</td>
                                <td>210 V</td>
                            </tr>
                            <tr>
                                <td rowspan="2" class="align-middle">2</td>
                                <td>Sedang</td>
                                <td>:</td>
                                <td>220 V - 240 V</td>
                            </tr>
                            <tr>
                                <td>Puncak</td>
                                <td>:</td>
                                <td>230 V</td>
                            </tr>
                            <tr>
                                <td rowspan="2" class="align-middle">3</td>
                                <td>Sedang</td>
                                <td>:</td>
                                <td>230 V - ∞ V</td>
                            </tr>
                            <tr>
                                <td>Puncak</td>
                                <td>:</td>
                                <td>230 V - ∞ V</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success bg-gradient text-white">Ampere</div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td rowspan="2" class="align-middle">1</td>
                                <td>Rendah</td>
                                <td>:</td>
                                <td>200 V - 220 V</td>
                            </tr>
                            <tr>
                                <td>Puncak</td>
                                <td>:</td>
                                <td>210 V</td>
                            </tr>
                            <tr>
                                <td rowspan="2" class="align-middle">2</td>
                                <td>Sedang</td>
                                <td>:</td>
                                <td>220 V - 240 V</td>
                            </tr>
                            <tr>
                                <td>Puncak</td>
                                <td>:</td>
                                <td>230 V</td>
                            </tr>
                            <tr>
                                <td rowspan="2" class="align-middle">3</td>
                                <td>Sedang</td>
                                <td>:</td>
                                <td>230 V - ∞ V</td>
                            </tr>
                            <tr>
                                <td>Puncak</td>
                                <td>:</td>
                                <td>230 V - ∞ V</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-danger bg-gradient text-white">Energy Consumption</div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>1</td>
                                <td>Waspada</td>
                                <td>:</td>
                                <td>1000 Watt - 1399 Watt</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Ancaman</td>
                                <td>:</td>
                                <td>1400 Watt - 1999 V</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Darurat</td>
                                <td>:</td>
                                <td>2000 Watt - ∞ Watt</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Normal</td>
                                <td>:</td>
                                <td>
                                    < 1000 Watt</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        new DataTable('#report');

        function exportPDF() {
            let tgl1 = $('#tgl_awal').val()
            let tgl2 = $('#tgl_akhir').val()
            let url = "/alert-export-pdf/" + tgl1 + "/" + tgl2;
            window.open(url, "_blank");
        }
    </script>

    <?= $this->endSection(); ?>