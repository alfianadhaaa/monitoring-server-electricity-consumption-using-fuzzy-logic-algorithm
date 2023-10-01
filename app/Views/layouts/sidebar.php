<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link <?= ($title == 'Dashboard') ? 'active' : ''; ?>" href="<?= base_url(); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link collapsed <?= ($title == 'Monitoring') ? 'active' : ''; ?>" href="<?= base_url(); ?>monitoring">
                    <div class="sb-nav-link-icon"><i class="bi bi-tv"></i></div>
                    Monitoring
                </a>
                <a class="nav-link collapsed <?= ($title == 'Devices') ? 'active' : ''; ?>" href="<?= base_url(); ?>device">
                    <div class="sb-nav-link-icon"><i class="bi bi-hdd-rack"></i></div>
                    Devices
                </a>
                <a class="nav-link collapsed <?= ($title == 'Alert') ? 'active' : ''; ?>" href="<?= base_url(); ?> alert">
                    <div class="sb-nav-link-icon"><i class="bi bi-exclamation-octagon"></i></div>
                    Alert
                </a>
                <a class="nav-link collapsed <?= ($title == 'monitoring' || $title == 'Chart') ? 'active' : ''; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Reports
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link collapsed <?= ($title == 'monitoring') ? 'active' : ''; ?>" href="<?= base_url(); ?>report">
                            <div class="sb-nav-link-icon"><i class="bi bi-file-earmark-bar-graph"></i></div>
                            Monitoring
                        </a>
                        <a class="nav-link <?= ($title == 'Chart') ? 'active' : ''; ?>" href="<?= base_url(); ?>report-chart">
                            <div class="sb-nav-link-icon"><i class="bi bi-graph-up"></i></div>
                            Chart
                        </a>
                    </nav>
                </div>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Administrator
        </div>
    </nav>
</div>