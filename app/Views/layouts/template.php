<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>MONELIS</title>
    <link rel="stylesheet" href="<?= base_url(); ?>css/bootstrap-icons.css">
    <link href="<?= base_url(); ?>css/styles.css" rel="stylesheet" />
    <link rel="shortcut icon" href="<?= base_url(); ?>img/logo.png" type="image/x-icon">
    <script src="<?= base_url(); ?>js/all.js" crossorigin="anonymous"></script>
    <script src="<?= base_url(); ?>js/Chart.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url('assets/sweetalert2/sweetalert2.min.css') ?>">
    <script src="<?= base_url('assets/sweetalert2/sweetalert2.all.min.js') ?>"></script>

</head>

<body class="sb-nav-fixed">

    <!-- Header -->
    <?= $this->include('layouts/topbar'); ?>

    <div id="layoutSidenav">

        <!-- Sidebar -->
        <?= $this->include('layouts/sidebar'); ?>

        <!-- Content -->

        <?= $this->renderSection('content'); ?>
    </div>
    </div>

    <script src="<?= base_url(); ?>js/jquery-3.7.0.min.js"></script>
    <script src="<?= base_url(); ?>js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>
    <script src="<?= base_url(); ?>js/main/insert-alert-detail.js"></script>
    <script src="<?= base_url(); ?>js/main/insert-sensor-detail.js"></script>

</body>

</html>