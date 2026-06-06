<div class="d-flex justify-content-between align-items-center py-4 mb-2">
    <h4 class="mb-0"><span class="text-muted fw-light">Manajemen User /</span> Data Admin</h4>
    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAdmin">
        <i class="ti ti-plus me-1"></i> Tambah Admin baru
    </button>
</div>

<?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-circle-check me-2"></i>
        <div><?= $this->session->flashdata('success'); ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-alert-triangle me-2"></i>
        <div><?= $this->session->flashdata('error'); ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-datatable table-responsive p-4">
        <table class="table table-striped table-hover border-top" id="tableAdminData">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Pengelola</th>
                    <th>Email</th>
                    <th>Status Akun</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($admins as $adm) : ?>
                    <tr>
                        <td><strong><?= $no++; ?></strong></td>
                        <td>
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper me-3">
                                    <div class="avatar avatar-sm">
                                        <?php 
                                        $avatar_img = (!empty($adm['foto']) && file_exists(FCPATH . 'uploads/profile/' . $adm['foto'])) 
                                            ? base_url('uploads/profile/' . $adm['foto']) 
                                            : base_url('assets/img/avatars/1.png');
                                        ?>
                                        <img src="<?= $avatar_img; ?>" alt="Avatar" class="rounded-circle object-fit-cover">
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="emp_name text-truncate fw-bold text-heading"><?= $adm['nama']; ?></span>
                                    <small class="text-muted">ID Pengelola: ADM-<?= str_pad($adm['id'], 3, '0', STR_PAD_LEFT); ?></small>
                                </div>
                            </div>
                        </td>
                        <td><span class="text-secondary"><?= $adm['email']; ?></span></td>
                        <td>
                            <?php if ($adm['id'] == $this->session->userdata('id_user')) : ?>
                                <span class="badge bg-label-success px-2.5 py-1 rounded-pill">
                                    <span class="badge-dot bg-success me-1"></span> Anda (Aktif)
                                </span>
                            <?php else : ?>
                                <span class="badge bg-label-secondary px-2.5 py-1 rounded-pill">
                                    <span class="badge-dot bg-secondary me-1"></span> Administrator
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-icon btn-label-warning shadow-xs btn-edit-admin" 
                                        data-id="<?= $adm['id']; ?>" 
                                        data-nama="<?= $adm['nama']; ?>" 
                                        data-email="<?= $adm['email']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#modalEditAdmin">
                                    <i class="ti ti-edit"></i>
                                </button>
                                
                                <?php if ($adm['id'] != $this->session->userdata('id_user')) : ?>
                                    <a href="<?= base_url('admin/admin_manage/hapus/' . $adm['id']); ?>" class="btn btn-sm btn-icon btn-label-danger shadow-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus administrator ini?')">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                <?php else : ?>
                                    <button class="btn btn-sm btn-icon btn-label-secondary shadow-xs" disabled data-bs-toggle="tooltip" title="Tidak bisa menghapus akun sendiri"><i class="ti ti-trash"></i></button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambahAdmin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-label-primary p-4">
                <h5 class="modal-title text-primary fw-bold"><i class="ti ti-user-plus me-1"></i> Registrasi Administrator Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('admin/admin_manage/tambah'); ?>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <label for="nama" class="form-label font-medium">Nama Lengkap</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-user"></i></span>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required />
                    </div>
                </div>
                <div class="row g-3 mb-2">
                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label font-medium">Email Login</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                            <input type="email" id="email" name="email" class="form-control" placeholder="admin@sekolah.com" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label font-medium">Sandi Akses</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-key"></i></span>
                            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top pt-3">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batalkan</button>
                <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Simpan Data</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditAdmin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-label-warning p-4">
                <h5 class="modal-title text-warning fw-bold"><i class="ti ti-user-edit me-1"></i> Modifikasi Informasi Administrator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('admin/admin_manage/ubah'); ?>
            <input type="hidden" id="edit_id" name="id_admin" />
            
            <div class="modal-body p-4">
                <div class="mb-4">
                    <label for="edit_nama" class="form-label font-medium">Nama Lengkap</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-user"></i></span>
                        <input type="text" id="edit_nama" name="nama" class="form-control" required />
                    </div>
                </div>
                <div class="row g-3 mb-2">
                    <div class="col-12 col-md-6">
                        <label for="edit_email" class="form-label font-medium">Alamat Email</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                            <input type="email" id="edit_email" name="email" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="edit_password" class="form-label font-medium text-warning">Password Baru (Opsional)</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-key"></i></span>
                            <input type="password" id="edit_password" name="password" class="form-control" placeholder="Kosongkan jika tak diubah" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top pt-3">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-warning"><i class="ti ti-refresh me-1"></i> Perbarui Data</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Inisialisasi DataTables Berbahasa Indonesia + Fitur Pencarian Lengkap
        if ($.fn.DataTable) {
            $('#tableAdminData').DataTable({
                "language": {
                    "search": "Cari Admin:",
                    "lengthMenu": "Tampilkan _MENU_ baris data",
                    "zeroRecords": "Maaf, data administrator tidak ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada record data tersedia",
                    "paginate": {
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10,
                "responsive": true
            });
        }

        // 2. Logika JQuery Data Binding: Memindahkan baris data tabel ke dalam Input Form Modal Edit
        $('.btn-edit-admin').on('click', function() {
            const id    = $(this).data('id');
            const nama  = $(this).data('nama');
            const email = $(this).data('email');

            // Isi nilai form modal edit secara instan
            $('#edit_id').val(id);
            $('#edit_nama').val(nama);
            $('#edit_email').val(email);
            // Bersihkan form password lama jika sebelumnya sempat terisi
            $('#edit_password').val('');
        });
    });
</script>

<style>
    .object-fit-cover { object-fit: cover; }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,.04); }
</style>