<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-2">Dashboard</h1>
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
            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-primary text-white mb-4 shadow">
                        <div class="card-header">Total Device</div>
                        <div class="card-body text-center">
                            <h3><?= $totalDevices; ?></h3>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="/device">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-success text-white mb-4 shadow">
                        <div class="card-header">Device Online</div>
                        <div class="card-body text-center">
                            <h3><?= $status; ?></h3>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="/monitoring">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-danger text-white mb-4 shadow">
                        <div class="card-header">Total Alert</div>
                        <div class="card-body text-center">
                            <h3><?= $totalAlerts; ?></h3>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                            <div class="small text-white"><i class=""></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-display"></i>
                            Power Consumption
                        </div>
                        <div class="card-body"><canvas id="myChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-danger text-white">
                            <i class="bi bi-exclamation-octagon me-1"></i>
                            Alert
                        </div>
                        <div class="card-body">
                            <?php foreach ($alerts as $alert) : ?>
                                <a onclick="editAlert(<?= $alert['id_device']; ?>)" href="#" style="text-decoration:none" class="text-black">
                                    <div class="card mb-1">
                                        <div class="card-body d-flex">
                                            <div class=""> Device <?= $alert['name']; ?></div>
                                            <div class="badge <?= (($alert['type_alert']) == 'Waspada') ? 'bg-success' : (($alert['type_alert'] == 'Ancaman') ? 'bg-warning' : 'bg-danger'); ?> text-wrap ms-auto" style="width: 6rem;">
                                                <?= $alert['type_alert']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="viewmodal" style="display: none;"></div>

    <script>
        var labels = <?= json_encode($labels) ?>;
        var data = <?= json_encode($kwh) ?>;

        // Buat grafik menggunakan Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Kenaikan KWH',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        <?php foreach ($sensor as $s) : ?>

            function sensor() {
                function fetch_kwh() {
                    fetch('<?= base_url(); ?>sensor/<?= $s['ip_address']; ?>/kwh')
                        .then(response => response.text())
                        .then(data => {
                            // Handle the response data
                            console.log(data);
                        })
                        .catch(error => {
                            // Handle any errors
                            console.error(error);
                        });
                }

                function fetch_voltage() {
                    fetch('<?= base_url(); ?>sensor/<?= $s['ip_address']; ?>/voltage')
                        .then(response => response.text())
                        .then(data => {
                            // Handle the response data
                            console.log(data);
                        })
                        .catch(error => {
                            // Handle any errors
                            console.error(error);
                        });
                }

                function fetch_current() {
                    fetch('<?= base_url(); ?>sensor/<?= $s['ip_address']; ?>/current')
                        .then(response => response.text())
                        .then(data => {
                            // Handle the response data
                            console.log(data);
                        })
                        .catch(error => {
                            // Handle any errors
                            console.error(error);
                        });
                }

                function fetch_watt() {
                    fetch('<?= base_url(); ?>sensor/<?= $s['ip_address']; ?>/watt')
                        .then(response => response.text())
                        .then(data => {
                            // Handle the response data
                            console.log(data);
                        })
                        .catch(error => {
                            // Handle any errors
                            console.error(error);
                        });
                }

                const fetch_fuzzy = () => {
                    fetch('<?= base_url(); ?>fuzzy')
                        .then(response => response.text())
                        .then(data => {
                            // Handle the response data
                            console.log(data);
                        })
                        .catch(error => {
                            // Handle any errors
                            console.error(error);
                        });
                }

                const fetch_fuzzy_alert = () => {
                    fetch('<?= base_url(); ?>fuzzy-update-alert')
                        .then(response => response.text())
                        .then(data => {
                            // Handle the response data
                            console.log(data);
                        })
                        .catch(error => {
                            // Handle any errors
                            console.error(error);
                        });
                }

                const fetch_update_alert = () => {
                    fetch('<?= base_url(); ?>alertupdate')
                        .then(response => response.text())
                        .then(data => {
                            // Handle the response data
                            console.log(data);
                        })
                        .catch(error => {
                            // Handle any errors
                            console.error(error);
                        });
                }

                fetch_kwh();
                fetch_voltage();
                fetch_watt();
                fetch_current();
                fetch_fuzzy();
            }
        <?php endforeach ?>

        sensor();

        function editAlert(id) {
            $.ajax({
                type: "post",
                url: "<?= site_url('alert/checkAlert') ?>",
                data: {
                    idAlert: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modalAlert').on('shown.bs.modal', function(event) {
                            $('#status').focus();
                        });
                        $('#modalAlert').modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }

        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);

        setInterval(function() {
            location.reload();
        }, 60000);
    </script>

    <?= $this->endSection(); ?>