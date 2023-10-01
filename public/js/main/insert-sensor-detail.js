async function insertData() {
    var currentMinute = new Date().getMinutes();
    var currentSecond = new Date().getSeconds();

    // Memeriksa apakah waktu saat ini adalah 30 menit sekali
    if (
        (currentMinute === 29 && currentSecond === 59) ||
        (currentMinute === 30 && (currentSecond === 0 || currentSecond === 1)) ||
        (currentMinute === 59 && currentSecond === 59) ||
        (currentMinute === 0 && (currentSecond === 0 || currentSecond === 1))
    ) {
        try {
            // Mengirim permintaan HTTP menggunakan Fetch API ke URL /insert-sensor-detail
            const response = await fetch('http://localhost:8080/insert-sensor-detail');
            console.log('Data inserted successfully.');
        } catch (error) {
            console.error('Error:', error);
        }
    }
}

// Menjalankan fungsi insertData setiap detik
setInterval(insertData, 1000);