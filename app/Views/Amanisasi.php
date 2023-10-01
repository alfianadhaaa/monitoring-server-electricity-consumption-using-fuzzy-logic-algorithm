const ctx2 = document.getElementById('myChart2');
var labels = <?= $time_sensor; ?>;
var wattData = <?= $wattData; ?>;
var kwhData = <?= $kwhData; ?>;

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
backgroundColor: 'rgba(192, 75, 192, 0.2)',
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

// Fungsi untuk membuat grafik awal
function createChart(labels, kwhData) {
const ctx2 = document.getElementById('myChart2').getContext('2d');
const myChart2 = new Chart(ctx2, {
type: 'line',
data: {
labels: labels,
datasets: [{
label: "kWh",
lineTension: 0.3,
borderColor: 'rgba(192, 75, 192, 1)',
backgroundColor: 'rgba(192, 75, 192, 0.2)',
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

return myChart2;
}

// Fungsi untuk memperbarui grafik dengan data baru dari server
function updateChart() {
$.ajax({
url: '<?= base_url(); ?>monitoring/real-time-chart', // URL untuk mengambil data terbaru dari server Anda
method: 'GET',
dataType: 'json',
success: function(data) {
// Ubah label waktu menjadi format jam:menit dengan format waktu Indonesia
const labels = data.labels.map(label => new Date(label).toLocaleTimeString('id-ID', {
hour: '2-digit',
minute: '2-digit'
}));

// Memperbarui data dan label grafik
myChart2.data.labels = labels;
myChart2.data.datasets[0].data = data.kwhData;
myChart2.update();
},
error: function(xhr, status, error) {
console.error(error);
}
});
}

// Panggil fungsi untuk pertama kali membuat grafik
const myChart2 = createChart(<?= $time_sensor; ?>, <?= $kwhData; ?>);

// Panggil fungsi untuk memperbarui grafik setiap 1 detik (persepuluh detik)
setInterval(updateChart, 1000);