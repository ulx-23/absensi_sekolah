<div class="py-4 mb-2">
    <h4 class="mb-1"><span class="text-muted fw-light">Pengaturan /</span> Halaman Beranda</h4>
    <p class="text-muted small mb-0">Kelola konten dinamis bagian Tentang dan Kontak pada halaman utama agar dapat diubah langsung oleh admin.</p>
</div>

<?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-circle-check me-2 text-success"></i>
        <div><?= $this->session->flashdata('success'); ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-alert-circle me-2 text-danger"></i>
        <div><?= $this->session->flashdata('error'); ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?= form_open('admin/homepage/update'); ?>
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-label-info p-4">
                    <h5 class="mb-0 text-info fw-bold"><i class="ti ti-home me-1"></i> Konten Bagian Tentang</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label for="home_about_title" class="form-label fw-semibold">Judul Utama</label>
                        <input type="text" id="home_about_title" name="home_about_title" class="form-control" value="<?= isset($config['home_about_title']) ? $config['home_about_title'] : 'Kenali E-Absensi Lebih Dekat'; ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="home_about_subtitle" class="form-label fw-semibold">Subjudul Ringkas</label>
                        <input type="text" id="home_about_subtitle" name="home_about_subtitle" class="form-control" value="<?= isset($config['home_about_subtitle']) ? $config['home_about_subtitle'] : 'Solusi absensi modern untuk sekolah yang lebih efektif'; ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="home_about_description" class="form-label fw-semibold">Deskripsi Lengkap</label>
                        <textarea id="home_about_description" name="home_about_description" rows="6" class="form-control" required><?= isset($config['home_about_description']) ? $config['home_about_description'] : 'E-Absensi hadir untuk memudahkan proses kehadiran siswa dengan sistem QR Code, laporan terpadu, dan keamanan gerbang sekolah secara real-time.'; ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end border-top pt-3 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-label-primary p-4">
                    <h5 class="mb-0 text-primary fw-bold"><i class="ti ti-phone me-1"></i> Konten Bagian Kontak</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label for="home_contact_title" class="form-label fw-semibold">Judul Kontak</label>
                        <input type="text" id="home_contact_title" name="home_contact_title" class="form-control" value="<?= isset($config['home_contact_title']) ? $config['home_contact_title'] : 'Hubungi Kami'; ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="home_contact_subtitle" class="form-label fw-semibold">Subjudul Kontak</label>
                        <input type="text" id="home_contact_subtitle" name="home_contact_subtitle" class="form-control" value="<?= isset($config['home_contact_subtitle']) ? $config['home_contact_subtitle'] : 'Tim kami siap membantu setiap kebutuhan sekolah dan wali murid.'; ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="home_contact_phone" class="form-label fw-semibold">Nomor Telepon</label>
                        <input type="text" id="home_contact_phone" name="home_contact_phone" class="form-control" value="<?= isset($config['home_contact_phone']) ? $config['home_contact_phone'] : '+62 812-3456-7890'; ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="home_contact_email" class="form-label fw-semibold">Email</label>
                        <input type="email" id="home_contact_email" name="home_contact_email" class="form-control" value="<?= isset($config['home_contact_email']) ? $config['home_contact_email'] : 'info@e-absensi.sch.id'; ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="home_contact_address" class="form-label fw-semibold">Alamat</label>
                        <textarea id="home_contact_address" name="home_contact_address" rows="3" class="form-control" required><?= isset($config['home_contact_address']) ? $config['home_contact_address'] : 'Jl. Pendidikan No. 10, Kota Pendidikan, Indonesia'; ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-label-secondary p-4">
                    <h5 class="mb-0 text-secondary fw-bold"><i class="ti ti-info-circle me-1"></i> Petunjuk</h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-3">Bagian ini akan muncul di homepage pada anchor <code>#tentang</code>. Seluruh perubahan akan langsung tampil setelah disimpan.</p>
                    <p class="text-muted small mb-0">Gunakan bahasa yang jelas dan memberi gambaran singkat tentang manfaat sistem untuk sekolah, siswa, dan orang tua.</p>
                </div>
            </div>
        </div>
    </div>
<?= form_close(); ?>
