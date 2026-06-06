<div class="d-flex justify-content-between align-items-center py-4 mb-2">
    <div>
        <h4 class="mb-1"><span class="text-muted fw-light">Manajemen User /</span> Data Petugas</h4>
        <p class="text-muted small mb-0">Kelola hak akses akun dan data profil petugas pos/gerbang scanning sekolah.</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPetugas">
        <i class="ti ti-plus me-1"></i> Tambah Petugas
    </button>
</div>

<?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-circle-check me-2 text-success"></i>
        <div><?= $this->session->flashdata('success'); ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (validation_errors()) : ?>
    <div class="alert alert-danger alert-dismissible d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-alert-triangle me-2 text-danger"></i>
        <div><?= validation_errors('<p class="mb-0 small">', '</p>'); ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-datatable table-responsive p-4">
        <table class="table table-striped table-hover border-top" id="tablePetugasData">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Petugas</th>
                    <th>Email Konten</th>
                    <th>Hak Akses</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($petugas as $p) : ?>
                    <tr>
                        <td><strong><?= $no++; ?></strong></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-wrapper me-2.5">
                                    <div class="avatar avatar-sm">
                                        <?php 
                                        $avatar_img = (!empty($p['foto']) && file_exists(FCPATH . 'uploads/profile/' . $p['foto'])) 
                                            ? base_url('uploads/profile/' . $p['foto']) 
                                            : base_url('assets/img/avatars/1.png');
                                        ?>
                                        <img src="<?= $avatar_img; ?>" alt="Avatar" class="rounded-circle object-fit-cover">
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-heading"><?= $p['nama']; ?></span>
                                    <small class="text-muted">PTG-<?= str_pad($p['id'], 3, '0', STR_PAD_LEFT); ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="ti ti-mail text-muted me-1.5 fs-5"></i>
                                <span><?= $p['email']; ?></span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-label-success px-2.5 py-1 rounded-pill fw-medium">
                                <span class="badge-dot bg-success me-1"></span> Petugas Gerbang
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-icon btn-label-warning shadow-xs btn-edit-petugas" 
                                        data-id="<?= $p['id']; ?>" 
                                        data-nama="<?= $p['nama']; ?>" 
                                        data-email="<?= $p['email']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#modalEditPetugas">
                                    <i class="ti ti-edit"></i>
                                </button>
                                
                                <a href="<?= base_url('admin/petugas/hapus/' . $p['id']); ?>" class="btn btn-sm btn-icon btn-label-danger shadow-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambahPetugas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-label-primary p-4">
                <h5 class="modal-title text-primary fw-bold"><i class="ti ti-user-plus me-1"></i> Registrasi Petugas Gerbang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('admin/petugas/tambah'); ?>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <label for="nama_add" class="form-label fw-medium">Nama Lengkap</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-user"></i></span>
                        <input type="text" id="nama_add" name="nama" class="form-control" placeholder="Masukkan nama petugas" required />
                    </div>
                </div>
                <div class="row g-3 mb-2">
                    <div class="col-12 col-md-6">
                        <label for="email_add" class="form-label fw-medium">Email Login</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                            <input type="email" id="email_add" name="email" class="form-control" placeholder="petugas@sekolah.com" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="password_add" class="form-label fw-medium">Sandi Akses</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-key"></i></span>
                            <input type="password" id="password_add" name="password" class="form-control" placeholder="••••••••" required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top pt-3">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Simpan Data</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditPetugas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-label-warning p-4">
                <h5 class="modal-title text-warning fw-bold"><i class="ti ti-user-edit me-1"></i> Ubah Informasi Akun Petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('', ['id' => 'formEditPetugas']); ?>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <label for="edit_nama" class="form-label fw-medium">Nama Lengkap</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-user"></i></span>
                        <input type="text" id="edit_nama" name="nama" class="form-control" required />
                    </div>
                </div>
                <div class="row g-3 mb-2">
                    <div class="col-12 col-md-6">
                        <label for="edit_email" class="form-label fw-medium">Email Login</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                            <input type="email" id="edit_email" name="email" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="edit_password" class="form-label fw-medium text-warning">Sandi Baru (Opsional)</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-key"></i></span>
                            <input type="password" id="edit_password" name="password" class="form-control" placeholder="Isi jika ingin diganti" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top pt-3">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning"><i class="ti ti-refresh me-1"></i> Perbarui Data</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Inisialisasi Fitur Pencarian & Pagination Instan DataTables
        if ($.fn.DataTable) {
            $('#tablePetugasData').DataTable({
                "language": {
                    "search": "Cari Petugas:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Data petugas tidak ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Record petugas kosong",
                    "paginate": {
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10,
                "responsive": true
            });
        }

        // 2. Logika Pemindahan Baris Tabel Ke Kolom Form Ubah
        $('.btn-edit-petugas').on('click', function() {
            const id    = $(this).data('id');
            const nama  = $(this).data('nama');
            const email = $(this).data('email');

            // Isi input modal edit
            $('#edit_nama').val(nama);
            $('#edit_email').val(email);
            $('#edit_password').val(''); // Reset input password

            // Alihkan rute form action ke endpoint ID terkait secara dinamis
            const base_url_action = "<?= base_url('admin/petugas/ubah/'); ?>";
            $('#formEditPetugas').attr('action', base_url_action + id);
        });
    });
</script>

<style>
    .object-fit-cover { object-fit: cover; }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,.04); }
    .badge-dot { width: 6px; height: 6px; display: inline-block; border-radius: 50%; }
</style>