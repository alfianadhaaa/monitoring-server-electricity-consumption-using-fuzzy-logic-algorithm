async function insertAlertDetail() {
    var currentMinute = new Date().getMinutes();
    var currentSecond = new Date().getSeconds();

    // Memeriksa apakah waktu saat ini adalah 30 menit sekali
    if ((currentMinute === 30 && currentSecond === 0) || (currentMinute === 0 && currentSecond === 0)) {
        try {
            // Mengirim permintaan HTTP menggunakan Fetch API ke URL /insert-sensor-detail
            const response = await fetch('http://localhost:8080/insert-alert-detail');
            console.log('Data inserted successfully.');
        } catch (error) {
            console.error('Error:', error);
        }
    }
}

// Menjalankan fungsi insertData setiap detik
setInterval(insertAlertDetail, 1000);