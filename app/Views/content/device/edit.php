<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-2">Device Data Changes</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/device">Devices</a></li>
                <li class="breadcrumb-item active">Change</li>
            </ol>

            <form action="/device/update/<?= $device['id_device']; ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3 col-sm-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $device['name']; ?>" autofocus required>
                    </div>
                    <div class="mb-3 col-sm-6">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="<?= $device['brand']; ?>" required>
                    </div>
                    <div class="mb-3 col-sm-6">
                        <label for="ip_address" class="form-label">IP Address</label>
                        <input type="text" class="form-control" id="ip_address" name="ip_address" value="<?= $device['ip_address']; ?>" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>

    </main>

    <?= $this->endSection(); ?>