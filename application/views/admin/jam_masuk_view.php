<div class="py-4 mb-2">
    <h4 class="mb-1"><span class="text-muted fw-light">Konfigurasi /</span> Jam Masuk Sekolah</h4>
    <p class="text-muted small mb-0">Atur parameter batas waktu toleransi pemindaian gerbang untuk menentukan status kehadiran siswa.</p>
</div>

<?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-circle-check me-2"></i>
        <div><?= $this->session->flashdata('success'); ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-12 col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-label-primary p-4 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 text-primary fw-bold"><i class="ti ti-clock-bolt me-1"></i> Atur Batas Waktu</h5>
                <span class="badge bg-primary rounded-pill">Sistem Aktif</span>
            </div>
            <div class="card-body pt-4 d-flex flex-column justify-content-between">
                <?= form_open('admin/jam_masuk/update'); ?>
                    
                    <div class="mb-5 p-3 bg-light rounded-3 border border-dashed">
                        <label class="form-label text-muted small d-block mb-2 text-uppercase tracking-wider">Jam Masuk Berlaku Saat Ini</label>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-label-primary fs-3 p-3 px-4 rounded-3 shadow-xs fw-bold">
                                <i class="ti ti-alarm-bell me-2 animate-bounce"></i> <?= date('H:i', strtotime($jam_masuk)); ?> WIB
                            </span>
                        </div>
                        <p class="text-muted small mt-2 mb-0"><i class="ti ti-info-circle ti-xs me-1"></i>Siswa yang melakukan pemindaian melewati batas waktu di atas otomatis diklasifikasikan sebagai <strong>Terlambat</strong>.</p>
                    </div>

                    <div class="mb-4">
                        <label for="input_jam" class="form-label fw-semibold text-heading">Ubah Jam Masuk Baru</label>
                        <div class="input-group input-group-merge input-group-lg">
                            <span class="input-group-text"><i class="ti ti-clock"></i></span>
                            <input type="time" id="input_jam" name="jam_masuk" class="form-control" value="<?= date('H:i', strtotime($jam_masuk)); ?>" required />
                        </div>
                        <small class="text-muted mt-1 d-block">Gunakan format waktu lokal 24 jam dengan presisi menit.</small>
                    </div>

                    <div class="d-flex justify-content-end border-top pt-4 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-4 shadow-xs">
                            <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card shadow-sm border-0 h-100 bg-white">
            <div class="card-header bg-label-secondary p-4">
                <h5 class="mb-0 text-dark fw-bold"><i class="ti ti-git-fork me-1"></i> Logika Validasi Waktu Otomatis</h5>
            </div>
            <div class="card-body p-4 pt-5">
                <p class="text-secondary small mb-4">Sistem membandingkan waktu ketukan (*tapping*) kartu dengan batas waktu yang Anda tentukan di sebelah kiri menggunakan simulasi berikut:</p>
                
                <div class="mb-4 border-start border-2 border-primary-subtle ms-3 ps-4 position-relative">
                    <span class="position-absolute translate-middle start-0 bg-success rounded-circle d-flex align-items-center justify-content-center border border-white" style="width: 24px; height: 24px; margin-left: -1px; top: 15px;">
                        <i class="ti ti-check text-white ti-xs"></i>
                    </span>
                    <h6 class="fw-bold text-success mb-1">Zona Tepat Waktu (Hadir)</h6>
                    <p class="small text-muted mb-3">Waktu scan &le; <strong><?= date('H:i', strtotime($jam_masuk)); ?></strong>. <br>Contoh: Scan pukul <span class="badge bg-label-success py-0 px-1.5 small">07:14</span> &rarr; Status kelulusan absensi terhitung <strong>Hadir</strong>.</p>
                </div>

                <div class="mb-2 border-start border-2 border-transparent ms-3 ps-4 position-relative">
                    <span class="position-absolute translate-middle start-0 bg-warning rounded-circle d-flex align-items-center justify-content-center border border-white" style="width: 24px; height: 24px; margin-left: -1px; top: 15px;">
                        <i class="ti ti-alert-triangle text-white ti-xs"></i>
                    </span>
                    <h6 class="fw-bold text-warning mb-1">Zona Keterlambatan (Terlambat)</h6>
                    <p class="small text-muted mb-0">Waktu scan &gt; <strong><?= date('H:i', strtotime($jam_masuk)); ?></strong>. <br>Contoh: Scan pukul <span class="badge bg-label-warning py-0 px-1.5 small">07:16</span> &rarr; Status tercatat <strong>Terlambat</strong> dan memicu notifikasi pembinaan.</p>
                </div>

                <div class="alert alert-info d-flex align-items-start mt-5 mb-0" role="alert">
                    <i class="ti ti-bolt me-2 fs-4 mt-0.5"></i>
                    <div>
                        <span class="fw-bold d-block mb-0.5">Sinkronisasi Instan Real-Time</span>
                        <small class="text-muted d-block">Perubahan parameter ini akan langsung diterapkan di seluruh tablet/komputer pos gerbang petugas saat itu juga tanpa perlu memuat ulang server web.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }
    .animate-bounce {
        animation: bounce 2s infinite ease-in-out;
    }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,.04); }
    .tracking-wider { tracking-content: 0.05em; }
</style>