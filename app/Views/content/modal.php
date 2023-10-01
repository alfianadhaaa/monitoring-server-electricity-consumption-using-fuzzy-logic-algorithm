<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<div id="layoutSidenav_content">
    <div class="container-fluid px-4">
        <h1 class="mt-2">Alert Check</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item">Alert Check</li>
        </ol>
        <table class="table" style="width: 50%;">
            <tbody>
                <tr>
                    <th scope="row">ID Device</th>
                    <td><?= $device['id_device']; ?></td>
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
                    <td><?= $device['volt']; ?></td>
                </tr>
                <tr>
                    <th scope="row">Watt</th>
                    <td><?= $device['watt']; ?></td>
                </tr>
                <tr>
                    <th scope="row">Ampere</th>
                    <td><?= $device['ampere']; ?></td>
                </tr>
                <tr>
                    <th scope="row">kWh</th>
                    <td><?= $device['kWh']; ?></td>
                </tr>
                <form action="/dashboard/showAlert/update/<?= $device['id_alert']; ?>" method="post">
                    <?= csrf_field(); ?>
                    <tr>
                        <th scope="row">Status</th>
                        <td>
                            <input type="checkbox" class="form-check-input" id="status" name="status" value="<?= $device['status']; ?>">
                            <label class="form-check-label text-primary" for="status">Check device out</label>
                        </td>
                    </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
        <!-- <div class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
<?= $this->endSection(); ?>