<h4 class="py-4 mb-6"><span class="text-muted fw-light">Pengaturan /</span> Profil Saya</h4>

<?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (validation_errors()) : ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <?= validation_errors('<p class="mb-0">', '</p>'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?= form_open_multipart('admin/admin_manage/proses_update_profil'); ?>
<div class="row">
    
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center pt-12">
                <div class="user-avatar-section mt-4">
                    <div class="d-flex align-items-center flex-column">
                        <div class="position-relative d-inline-block rounded-circle overflow-hidden shadow-sm border border-2 border-primary p-1 bg-white mb-4" style="width: 130px; height: 130px;">
                            <?php 
                            $foto_path = (!empty($user['foto']) && file_exists('./uploads/profile/' . $user['foto'])) 
                                ? base_url('uploads/profile/' . $user['foto']) 
                                : base_url('assets/img/avatars/1.png');
                            ?>
                            <img class="img-fluid rounded-circle h-100 w-100 object-fit-cover" src="<?= $foto_path; ?>" id="uploadedAvatar" alt="User Avatar" />
                        </div>
                        
                        <div class="user-info text-center">
                            <h5 class="mb-1 fw-bold"><?= $user['nama']; ?></h5>
                            <span class="badge bg-label-primary text-uppercase"><?= $user['role']; ?></span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-top">
                    <label for="uploadFoto" class="btn btn-outline-primary btn-sm me-2 mb-2">
                        <i class="ti ti-upload me-1"></i> Pilih Foto Baru
                        <input type="file" id="uploadFoto" name="foto" class="account-file-input" hidden accept="image/png, image/jpeg, image/jpg" onchange="previewImage(this);" />
                    </label>
                    <p class="text-muted small mb-0">Format: JPG, JPEG, PNG. Maks 2MB.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-label-primary p-4">
                <h5 class="mb-0 text-primary"><i class="ti ti-user-edit me-1"></i> Detail Informasi Akun Pengguna</h5>
            </div>
            <div class="card-body pt-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="nama_lskp" class="form-label font-medium">Nama Lengkap</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="nama_lskp" name="nama" class="form-control" value="<?= $user['nama']; ?>" required />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="email_add" class="form-label font-medium">Alamat Email</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                            <input type="email" id="email_add" name="email" class="form-control" value="<?= $user['email']; ?>" required />
                        </div>
                    </div>

                    <div class="col-12 border-top pt-4 mt-5">
                        <h6 class="text-warning fw-bold mb-3"><i class="ti ti-lock me-1"></i> Kredensial Keamanan (Opsional)</h6>
                    </div>

                    <div class="col-md-12">
                        <label for="pass_new" class="form-label font-medium">Ganti Password Baru</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-key"></i></span>
                            <input type="password" id="pass_new" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah sandi" />
                        </div>
                        <small class="text-muted mt-2 d-block">Sistem manskripsi keamanan data menggunakan algoritma lapis BCRYPT biner.</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-6 border-top pt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan Profil
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
<?= form_close(); ?>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                // Ganti src gambar secara instan tanpa reload halaman demi UX yang cepat
                document.getElementById('uploadedAvatar').src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>