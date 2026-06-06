<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?= base_url($this->session->userdata('role') . '/dashboard') ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <div class="avatar bg-label-primary rounded p-2 d-flex align-items-center justify-content-center shadow-sm">
                    <i class="ti ti-qrcode fs-4"></i>
                </div>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">E-Absensi</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    
    <ul class="menu-inner py-1">

        <?php if ($this->session->userdata('role') == 'admin') : ?>
            
            <li class="menu-item <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/dashboard') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-smart-home"></i>
                    <div>Dashboard</div>
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Data Master</span>
            </li>

            <li class="menu-item <?= in_array($this->uri->segment(2), ['admin_manage', 'petugas', 'orangtua']) ? 'active open' : '' ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div>Manajemen User</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item <?= ($this->uri->segment(2) == 'admin_manage') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/admin_manage') ?>" class="menu-link">
                            <div>Data Admin</div>
                        </a>
                    </li>
                    <li class="menu-item <?= ($this->uri->segment(2) == 'petugas') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/petugas') ?>" class="menu-link">
                            <div>Data Petugas</div>
                        </a>
                    </li>
                    <li class="menu-item <?= ($this->uri->segment(2) == 'orangtua') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/orangtua') ?>" class="menu-link">
                            <div>Data Orang Tua</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item <?= ($this->uri->segment(2) == 'siswa') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/siswa') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-id-badge"></i>
                    <div>Data Siswa</div>
                </a>
            </li>

            <li class="menu-item <?= ($this->uri->segment(2) == 'akademik') ? 'active open' : '' ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-book"></i>
                    <div>Data Akademik</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item <?= ($this->uri->segment(3) == 'kelas') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/akademik/kelas') ?>" class="menu-link">
                            <div>Kelola Kelas</div>
                        </a>
                    </li>
                    <li class="menu-item <?= ($this->uri->segment(3) == 'tahun_ajaran') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/akademik/tahun_ajaran') ?>" class="menu-link">
                            <div>Tahun Ajaran</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Laporan</span>
            </li>
            
            <li class="menu-item <?= ($this->uri->segment(2) == 'laporan') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/laporan') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-file-analytics"></i>
                    <div>Laporan Absensi</div>
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Konfigurasi</span>
            </li>

            <li class="menu-item <?= ($this->uri->segment(2) == 'jam_masuk') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/jam_masuk') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-clock-bolt"></i>
                    <div>Jam Masuk Sekolah</div>
                </a>
            </li>

            <li class="menu-item <?= ($this->uri->segment(2) == 'notifikasi') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/notifikasi') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-bell-ringing"></i>
                    <div>Pengaturan Notifikasi</div>
                </a>
            </li>

            <li class="menu-item <?= ($this->uri->segment(2) == 'homepage') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/homepage') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-home"></i>
                    <div>Pengaturan Homepage</div>
                </a>
            </li>

            <li class="menu-item <?= ($this->uri->segment(2) == 'sliders') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/sliders') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-photo-star"></i>
                    <div>Slider Homepage</div>
                </a>
            </li>


        <?php elseif ($this->session->userdata('role') == 'petugas') : ?>

            <li class="menu-item <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : '' ?>">
                <a href="<?= base_url('petugas/dashboard') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-focus-2"></i>
                    <div>Scan QR Absensi</div>
                    <div class="badge bg-label-danger rounded-pill ms-auto">Live</div>
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Aktivitas Hari Ini</span>
            </li>

            <li class="menu-item <?= ($this->uri->segment(2) == 'riwayat') ? 'active' : '' ?>">
                <a href="<?= base_url('petugas/riwayat') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-history"></i>
                    <div>Riwayat Absen Hari Ini</div>
                </a>
            </li>

            <li class="menu-item <?= ($this->uri->segment(2) == 'laporan') ? 'active' : '' ?>">
                <a href="<?= base_url('petugas/laporan') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-printer"></i>
                    <div>Cetak Laporan</div>
                </a>
            </li>


        <?php elseif ($this->session->userdata('role') == 'orangtua') : ?>

            <li class="menu-item <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : '' ?>">
                <a href="<?= base_url('orangtua/dashboard') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-smart-home"></i>
                    <div>Status Kehadiran Anak</div>
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Monitoring</span>
            </li>

            <li class="menu-item <?= ($this->uri->segment(2) == 'riwayat') ? 'active' : '' ?>">
                <a href="<?= base_url('orangtua/riwayat') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-calendar-stats"></i>
                    <div>Riwayat Absensi Anak</div>
                </a>
            </li>

        <?php endif; ?>


        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Sistem</span>
        </li>
        
        <li class="menu-item">
            <a href="<?= base_url() ?>" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons ti ti-world-www text-primary"></i>
                <div class="text-primary">Lihat Website</div>
            </a>
        </li>

        <li class="menu-item mt-2">
            <a href="<?= base_url('auth/logout') ?>" class="menu-link text-danger" onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">
                <i class="menu-icon tf-icons ti ti-logout text-danger"></i>
                <div>Keluar Aplikasi</div>
            </a>
        </li>

    </ul>
</aside>