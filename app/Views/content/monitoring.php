<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-2 mb-4">Monitoring</h1>

            <!-- Notifikasi -->
            <?php if (session()->getFlashdata('warning')) : ?>
                <div class="alert alert-warning" role="alert">
                    <?= session()->getFlashdata('warning'); ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('danger')) : ?>
                <a href="<?= base_url(); ?>" style="text-decoration:none">
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('danger'); ?>
                    </div>
                </a>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')) : ?>
                <a href="<?= base_url(); ?>" style="text-decoration:none">
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('success'); ?>
                    </div>
                </a>
            <?php endif; ?>

            <?php foreach ($sensor as $s) : ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4" style="height: 400px;">
                            <div class="card-header d-flex justify-content-between bg-success bg-gradient text-white">
                                <h6 class="card-title"><i class="fas fa-chart-area me-1"></i><?= $s['name']; ?></h6>
                                <span>Volt : <?= $s['volt']; ?></span>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card mb-4" style="height: 400px;">
                            <div class="card-header d-flex justify-content-between bg-success bg-gradient text-white">
                                <h6 class="card-title"><i class="fas fa-chart-area me-1"></i><?= $s['name']; ?></h6>
                                <span>Volt : <?= $s['volt']; ?></span>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart2"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card mb-4" style="height: 400px;">
                            <div class="card-header d-flex justify-content-between bg-success bg-gradient text-white">
                                <h6 class="card-title"><i class="fas fa-chart-area me-1"></i><?= $s['name']; ?></h6>
                                <span>Volt : <?= $s['volt']; ?></span>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </main>

    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 10000);

        const ctx = document.getElementById('myChart').getContext('2d');

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Watt', 'Ampere'
                ],
                datasets: [{
                    label: ['<?= $s['ip_address']; ?>'],
                    backgroundColor: [
                        'rgba(29, 91, 121, 0.5)',
                        'rgba(239, 98, 98, 0.5)'
                    ],
                    borderColor: [
                        'rgba(29, 91, 121, 1)',
                        'rgba(239, 98, 98, 1)'
                    ],
                    data: [
                        <?= $s['watt']; ?>, <?= $s['ampere']; ?>
                    ],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        function sensor() {
            async function fetch_kwh() {
                try {
                    const response = await fetch('<?= base_url(); ?>sensor/<?= $s['ip_address']; ?>/kwh');
                    const data = await response.text();
                    // Handle the response data
                    console.log(data);
                } catch (error) {
                    // Handle any errors
                    console.error(error);
                    // Show SweetAlert2 with error message
                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Your Device is Offline',
                        showConfirmButton: false,
                        timer: 5000
                    });
                }
            }

            async function fetch_voltage() {
                try {
                    const response = await fetch('<?= base_url(); ?>sensor/<?= $s['ip_address']; ?>/voltage');
                    const data = await response.text();
                    // Handle the response data
                    console.log(data);
                } catch (error) {
                    // Handle any errors
                    console.error(error);
                }
            }

            async function fetch_current() {
                try {
                    const response = await fetch('<?= base_url(); ?>sensor/<?= $s['ip_address']; ?>/current');
                    const data = await response.text();
                    // Handle the response data
                    console.log(data);
                } catch (error) {
                    // Handle any errors
                    console.error(error);
                }
            }

            async function fetch_watt() {
                try {
                    const response = await fetch('<?= base_url(); ?>sensor/<?= $s['ip_address']; ?>/watt');
                    const data = await response.text();
                    // Handle the response data
                    console.log(data);
                } catch (error) {
                    // Handle any errors
                    console.error(error);
                }
            }

            const fetch_fuzzy = async () => {
                try {
                    const response = await fetch('<?= base_url(); ?>fuzzy');
                    const data = await response.text();
                    // Handle the response data
                    console.log(data);
                } catch (error) {
                    // Handle any errors
                    console.error(error);
                }
            };

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
            // fetch_fuzzy_alert();
            // fetch_update_alert();
        }

        sensor();
        <?php endforeach; ?>
        // setInterval(sensor, 5000);

        const getMessageWarning = () => {
            let warningMessage = "<?= session()->getFlashdata('warning'); ?>";

            // Periksa apakah pesan flash ada
            if (warningMessage) {
                // Tampilkan SweetAlert2 dengan pesan flash
                Swal.fire({
                    position: 'top-end',
                    icon: 'warning',
                    title: 'Warning',
                    text: warningMessage,
                    showConfirmButton: false,
                    timer: 5000
                });
            }
        }

        const getMessageDanger = () => {
            let warningMessage = "<?= session()->getFlashdata('danger'); ?>";

            // Periksa apakah pesan flash ada
            if (warningMessage) {
                // Tampilkan SweetAlert2 dengan pesan flash
                Swal.fire({
                    icon: 'warning',
                    title: 'DANGER!!!',
                    text: 'There are Device to Check',
                    width: 600,
                    padding: '3em',
                    color: '#d91414',
                    background: '#fff url(<?= base_url(); ?>img/warning.png)',
                    backdrop: `
                        rgba(217, 20, 20,0.4)
                        url('<?= base_url(); ?>img/danger.gif')
                        left top
                        no-repeat
                    `
                });
            }
        }

        getMessageWarning();
        getMessageDanger();

        // function insertSensorAlert() {
        // Fungsi untuk memanggil URL sensor/insert-data
        const fetchSensorDetail = () => {
            fetch('<?= base_url(); ?>insert-sensor-detail')
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

        const ctx2 = document.getElementById('myChart2');
        var labels = <?= $time_sensor; ?>;
        var wattData = <?= $wattData; ?>;
        var kwhData = <?= $kwhData; ?>;
        var voltData = <?= $voltData; ?>

        // Memformat label menjadi jam:menit dengan format waktu Indonesia
        labels = labels.map(label => new Date(label).toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        }));

        const myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "kWh",
                    lineTension: 0.3,
                    borderColor: 'rgba(192, 75, 192, 1)',
                    backgroundColor: 'rgba(192, 75, 192, 0.5)',
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(192, 75, 192, 1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 2,
                    pointHoverBackgroundColor: "rgba(192, 75, 192, 1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: kwhData
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'hour',
                            displayFormats: {
                                hour: 'HH:mm'
                            },
                            tooltipFormat: 'HH:mm'
                        },
                        ticks: {
                            source: 'labels',
                            maxRotation: 45, // Rotasi maksimum label dalam derajat
                            minRotation: 45 // Rotasi minimum label dalam derajat
                        }
                    },
                    y: [{
                        ticks: {
                            min: 0,
                            max: 5000,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }]
                }
            }
        });

        const ctx3 = document.getElementById('myChart3');

        const myChart3 = new Chart(ctx3, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Volt",
                    lineTension: 0.3,
                    borderColor: 'rgba(134, 43, 13, 1)',
                    backgroundColor: 'rgba(134, 43, 13, 0.5)',
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(134, 43, 13, 1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 2,
                    pointHoverBackgroundColor: "rgba(134, 43, 13, 1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: voltData
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'hour',
                            displayFormats: {
                                hour: 'HH:mm'
                            },
                            tooltipFormat: 'HH:mm'
                        },
                        ticks: {
                            source: 'labels',
                            maxRotation: 45, // Rotasi maksimum label dalam derajat
                            minRotation: 45 // Rotasi minimum label dalam derajat
                        }
                    },
                    y: [{
                        ticks: {
                            min: 0,
                            max: 5000,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }]
                }
            }
        });

        setInterval(function() {
            location.reload();
        }, 10000);
    </script>


    <?= $this->endSection(); ?>