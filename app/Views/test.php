<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Chart</title>
</head>

<body>
    <div>
        <canvas id="myChart"></canvas>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.js"></script> -->



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
        // const ctx = document.getElementById('myChart');
        // var labels = ;
        // var wattData = ;
        // var ampereData = ;

        // new Chart(ctx, {
        //     type: 'line',
        //     data: {
        //         labels: labels,
        //         datasets: [{
        //             label: 'Watt',
        //             data: wattData,
        //             borderColor: 'rgba(75, 192, 192, 1)',
        //             backgroundColor: 'rgba(75, 192, 192, 0.2)',
        //             tension: 0.1
        //         }, {
        //             label: 'Ampere',
        //             data: ampereData,
        //             borderColor: 'rgba(192, 75, 192, 1)',
        //             backgroundColor: 'rgba(192, 75, 192, 0.2)',
        //             tension: 0.1
        //         }]
        //     },
        //     options: {
        //         scales: {
        //             x: {
        //                 type: 'time',
        //                 time: {
        //                     unit: 'hour',
        //                     displayFormats: {
        //                         hour: 'YYYY-MM-DD HH:mm:ss'
        //                     },
        //                     tooltipFormat: 'YYYY-MM-DD HH:mm:ss'
        //                 },
        //                 ticks: {
        //                     source: 'labels'
        //                 }
        //             },
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });
    </script>
</body>

</html>