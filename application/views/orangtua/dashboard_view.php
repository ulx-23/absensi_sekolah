<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 bg-label-primary shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between p-4 py-5">
                <div class="card-title mb-0">
                    <h4 class="text-primary mb-1 fw-bold">Selamat Datang, Bapak/Ibu <?= $this->session->userdata('nama'); ?> 👋</h4>
                    <p class="mb-0 text-muted small d-none d-sm-block">Sistem pemantauan kehadiran anak Anda berjalan terintegrasi secara *real-time*.</p>
                </div>
                <div class="badge bg-primary p-2.5 rounded-pill shadow-sm fs-7">
                    <i class="ti ti-calendar-event me-1"></i> <?= date('d F Y'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex align-items-center mb-4">
    <div class="badge bg-label-secondary p-1.5 rounded me-2">
        <i class="ti ti-device-analytics text-secondary fs-5"></i>
    </div>
    <h5 class="mb-0 fw-bold text-heading">Status Kehadiran Anak Anda Hari Ini</h5>
</div>

<div class="row g-4">
    <?php foreach ($anak as $a) : ?>
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0 h-100 card-child-status">
                <div class="card-body p-4 d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
                    
                    <div class="d-flex align-items-center">
                        <div class="avatar-wrapper me-3">
                            <div class="avatar avatar-md">
                                <div class="avatar-initial rounded-3 bg-label-primary">
                                    <i class="ti ti-school fs-3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="badge bg-label-secondary mb-1.5 align-self-start fw-semibold">NIS: <?= $a['nis']; ?></span>
                            <h5 class="fw-bold mb-1 text-heading"><?= $a['nama_siswa']; ?></h5>
                            <small class="text-muted">
                                <i class="ti ti-building-community ti-xs me-1"></i>Kelas: <strong class="text-secondary"><?= $a['kelas']; ?></strong>
                            </small>
                        </div>
                    </div>
                    
                    <div class="text-start text-sm-end w-100 w-sm-auto pt-2 pt-sm-0 border-top border-sm-top-0 border-dashed d-flex d-sm-block justify-content-between align-items-center">
                        <?php if ($a['jam_masuk'] != null) : ?>
                            <?php 
                                $is_hadir = ($a['status'] == 'hadir');
                                $badge_class = $is_hadir ? 'bg-label-success' : 'bg-label-warning';
                                $icon_class = $is_hadir ? 'ti-circle-check-toggle text-success' : 'ti-alert-triangle text-warning';
                            ?>
                            <span class="badge <?= $badge_class; ?> p-2 px-3 rounded-pill fw-bold fs-7 mb-0 mb-sm-2 d-inline-flex align-items-center">
                                <i class="ti <?= $icon_class; ?> me-1.5"></i>
                                <?= ucfirst($a['status']); ?>
                            </span>
                            <h5 class="mb-0 fw-bold mt-0 mt-sm-1 text-heading d-flex align-items-center justify-content-sm-end">
                                <i class="ti ti-clock me-1 text-secondary"></i> 
                                <?= date('H:i', strtotime($a['jam_masuk'])); ?> <span class="fs-7 text-muted fw-normal ms-1">WIB</span>
                            </h5>
                        <?php else : ?>
                            <span class="badge bg-label-danger p-2 px-3 rounded-pill fw-bold fs-7 mb-0 mb-sm-2 d-inline-flex align-items-center animate-pulse">
                                <i class="ti ti-clock-bolt me-1.5 text-danger"></i> Belum Hadir
                            </span>
                            <p class="text-muted small mb-0 mt-0 mt-sm-1"><i class="ti ti-help-circle ti-14px me-0.5"></i>Menunggu tapping gate</p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<style>
    .card-child-status {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-child-status:hover {
        transform: translateY(-3px);
        box-shadow: 0 .4rem .8rem rgba(0,0,0,.06) !important;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    .animate-pulse {
        animation: pulse 2s infinite ease-in-out;
    }
    /* Memperbaiki alignment border-dashed saat responsive mobile */
    @media (max-width: 575.98px) {
        .border-sm-top-0 { border-top: 1px dashed #dbdade !important; }
    }
</style>