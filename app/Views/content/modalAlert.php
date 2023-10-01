<div class="modal fade" id="modalAlert" tabindex="-1" aria-labelledby="modalAlertLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahsatuanLabel">Checking Alert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateForm" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $device['id_alert'] ?>">
                <div class="modal-body">
                    <table class="table" style="width: 75%;">
                        <tbody>
                            <tr>
                                <th scope="row">ID Device</th>
                                <td id="id-device"><?= $device['id_device']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Name</th>
                                <td><?= $device['name']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Brand</th>
                                <td><?= $device['brand']; ?></td>
                            </tr>
                            <tr>
                            <tr>
                                <th scope="row">IP Address</th>
                                <td><?= $device['ip_address']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Volt</th>
                                <input type="hidden" name="volt" value="<?= $device['volt']; ?>">
                                <td><?= $device['volt']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Watt</th>
                                <td id="watt"><?= $device['watt']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Ampere</th>
                                <input type="hidden" name="ampere" value="<?= $device['ampere']; ?>">
                                <td><?= $device['ampere']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">kWh</th>
                                <td id="kwh"><?= $device['kWh']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Type Alert</th>
                                <td id="kwh"><?= $device['type_alert']; ?></td>
                                <input type="hidden" name="type_alert" value="<?= $device['type_alert']; ?>">
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td>
                                    <input type="checkbox" class="form-check-input" id="status" name="status" value="<?= $device['status']; ?>">
                                    <label class="form-check-label text-primary" for="status">Check device out</label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Tangkap event submit pada form
        $('#updateForm').submit(function(event) {
            event.preventDefault(); // Mencegah form submit secara default

            // Mengambil data form
            var formData = $(this).serialize();

            // Mengirim data form ke server menggunakan Ajax
            $.ajax({
                url: '<?= base_url(); ?>alert/updatedata', // Ganti dengan URL sesuai dengan rute yang ditetapkan di CodeIgniter
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Berhasil',
                            response.success,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 800);
                            }
                        });

                    }
                    // alert('Data updated successfully!');
                    // // Lakukan tindakan lain setelah pembaruan berhasil
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>