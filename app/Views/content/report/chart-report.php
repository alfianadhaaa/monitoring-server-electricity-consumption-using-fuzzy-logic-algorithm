<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<script src="<?= base_url(); ?>js/jspdf.umd.min.js"></script>
<script src="<?= base_url(); ?>js/moment.js"></script>

<div id="layoutSidenav_content">
    <div class="container-fluid px-4">
        <h1 class="mt-2 mb-4">Report Chart Monitoring</h1>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4" style="height: 510px;">
                    <?php foreach ($device as $d) : ?>
                        <div class="card-header d-flex justify-content-between bg-success bg-gradient text-white">
                            <h6 class="card-title"><i class="fas fa-chart-area me-1"></i><?= $d['name']; ?></h6>
                            <span><?= $d['ip_address']; ?></span>
                        </div>
                    <?php endforeach; ?>
                    <form action="/report-chart-filter" method="post">
                        <div class="container mt-2">
                            <div class="row">
                                <div class="col-2">
                                    <input class="form-control" style="width: 150px;" type="date" name="tgl" id="" value="<?= $tanggal; ?>">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-outline-success">Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                    <div class="card-footer text-center">
                        <a id="download-chart-kwh" download="chart-monitoring-kwh-<?= $tanggal; ?>.png">
                            <button class="btn btn-outline-success btn-sm" onclick="downloadChart('PNG')">PNG</button>
                        </a>
                        <button class="btn btn-outline-danger btn-sm" onclick="downloadChart('PDF')">PDF</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mb-4" style="height: 510px;">
                    <?php foreach ($device as $d) : ?>
                        <div class="card-header d-flex justify-content-between bg-success bg-gradient text-white">
                            <h6 class="card-title"><i class="fas fa-chart-area me-1"></i><?= $d['name']; ?></h6>
                            <span><?= $d['ip_address']; ?></span>
                        </div>
                    <?php endforeach; ?>
                    <div class="card-body">
                        <canvas id="myChart2"></canvas>
                    </div>
                    <div class="card-footer text-center">
                        <a id="download-chart-ampere-watt" download="chart-monitoring-ampere-watt-<?= $tanggal; ?>.png">
                            <button class="btn btn-outline-success btn-sm" onclick="downloadChart1('PNG')">PNG</button>
                        </a>
                        <button class="btn btn-outline-danger btn-sm" onclick="downloadChart1('PDF')">PDF</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const ctx2 = document.getElementById('myChart');
        const ctx1 = document.getElementById('myChart2');
        var labels = <?= $time_sensor; ?>;
        var kwhData = <?= $kwhData; ?>;
        var wattData = <?= $wattData; ?>;
        var ampereData = <?= $ampereData; ?>;
        var voltData = <?= $voltData; ?>;

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
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(75, 192, 192, 1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75, 192, 192, 1)",
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
                            max: 2500,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }]
                }
            }
        });

        const myChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: "Watt",
                        lineTension: 0.3,
                        borderColor: 'rgba(23, 89, 74, 1)',
                        backgroundColor: 'rgba(23, 89, 74, 0.5)',
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(23, 89, 74, 1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(75, 192, 192, 1)",
                        pointHitRadius: 50,
                        pointBorderWidth: 2,
                        data: wattData
                    },
                    {
                        label: "Ampere",
                        lineTension: 0.3,
                        borderColor: 'rgba(248, 111, 3, 1)',
                        backgroundColor: 'rgba(248, 111, 3, 0.5)',
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(248, 111, 3, 1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(75, 192, 192, 1)",
                        pointHitRadius: 50,
                        pointBorderWidth: 2,
                        data: ampereData
                    }
                ]
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
                            max: 2500,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }]
                }
            }
        });

        // Unduh Chart
        function downloadChart(type) {
            var download = document.getElementById('download-chart-kwh')
            var chart = document.getElementById('myChart')

            if (type === "PNG") {
                // Export PNG
                convertChartImg(download, chart)
            } else {
                // Export PDF
                convertChartPDF(chart, "chart-kwh.pdf", "Chart Monitoring")
            }
        }

        function convertChartImg(download, chart) {
            var img = chart.toDataURL('image/jpg', 1.0).replace('image/jpg', 'image/octet-stream');
            download.setAttribute('href', img)
        }

        function convertChartPDF(chart, filename, title) {
            var img = chart.toDataURL('image/jpg', 1.0).replace('image/jpg', 'image/octet-stream');
            var tgl = <?= json_encode($tanggal); ?>;
            // Mendapatkan tanggal dalam format yang diinginkan (misalnya: dd-mm-yyyy)
            var formattedDate = new Date(tgl).toLocaleDateString('en-GB').split('/').reverse().join('-');
            var date = <?= json_encode(tanggal()); ?>;

            window.jsPDF = window.jspdf.jsPDF
            var doc = new jsPDF('l', 'mm', 'A4'); // Settingan default jsPDF('p', 'mm', 'A4')

            doc.addImage(img, 'JPEG', 10, 30, 280, 100)

            // Judul
            doc.setFontSize(18)
            doc.text(10, 10, title)

            // Tanggal
            doc.setFontSize(10)
            doc.text('Tanggal: ' + new Date(tgl).toLocaleDateString('en-GB'), 10, 15);

            doc.setFontSize(12)
            doc.text('Jakarta, ' + date, 228, 155);

            // Tanda Tangan
            doc.setFontSize(12)
            doc.text('Teknisi Server', 240, 160);
            // Menambahkan garis untuk tanda tangan
            doc.setLineWidth(0.5);
            doc.line(230, 180, 280, 180);

            doc.save(formattedDate + '-' + filename)
        }

        // Unduh Chart 2
        function downloadChart1(type) {
            var download = document.getElementById('download-chart-ampere-watt')
            var chart = document.getElementById('myChart2')

            if (type === "PNG") {
                // Export PNG
                convertChartImg1(download, chart)
            } else {
                // Export PDF
                convertChartPDF1(chart, "chart-ampere-watt.pdf", "Chart Monitoring")
            }
        }

        function convertChartImg1(download, chart) {
            var img = chart.toDataURL('image/jpg', 1.0).replace('image/jpg', 'image/octet-stream');
            download.setAttribute('href', img)
        }

        function convertChartPDF1(chart, filename, title) {
            var img = chart.toDataURL('image/jpg', 1.0).replace('image/jpg', 'image/octet-stream');
            var tgl = <?= json_encode($tanggal); ?>;
            // Mendapatkan tanggal dalam format yang diinginkan (misalnya: dd-mm-yyyy)
            var formattedDate = new Date(tgl).toLocaleDateString('en-GB').split('/').reverse().join('-');
            var date = <?= json_encode(tanggal()); ?>;

            window.jsPDF = window.jspdf.jsPDF
            var doc = new jsPDF('l', 'mm', 'A4'); // Settingan default jsPDF('p', 'mm', 'A4')

            doc.addImage(img, 'JPEG', 10, 30, 280, 100)

            // Judul
            doc.setFontSize(18)
            doc.text(10, 10, title)

            // Tanggal
            doc.setFontSize(10)
            doc.text('Tanggal: ' + new Date(tgl).toLocaleDateString('en-GB'), 10, 15);

            // Tanda Tangan
            doc.setFontSize(12)
            doc.text('Jakarta, ' + date, 228, 155);

            doc.setFontSize(12)
            doc.text('Teknisi Server', 240, 160);
            // Menambahkan garis untuk tanda tangan
            doc.setLineWidth(0.5);
            doc.line(230, 180, 280, 180);

            doc.save(formattedDate + '-' + filename)
        }
    </script>

    <?= $this->endSection(); ?>