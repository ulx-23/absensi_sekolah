<div class="d-flex justify-content-between align-items-center py-4 mb-2">
    <div>
        <h4 class="mb-1"><span class="text-muted fw-light">Manajemen User /</span> Data Orang Tua</h4>
        <p class="text-muted small mb-0">Kelola data kontak kredensial wali murid untuk integrasi notifikasi gerbang.</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahOrtu">
        <i class="ti ti-plus me-1"></i> Tambah Orang Tua
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
        <table class="table table-striped table-hover border-top" id="tableOrtuData">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Orang Tua / Wali</th>
                    <th>No. WhatsApp / HP</th>
                    <th>Email Konten</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($orang_tua as $o) : ?>
                    <tr>
                        <td><strong><?= $no++; ?></strong></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="badge bg-label-primary p-2 rounded-3 me-2.5">
                                    <i class="ti ti-user fs-5"></i>
                                </div>
                                <span class="fw-bold text-heading fs-6"><?= $o['nama']; ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="ti ti-brand-whatsapp text-success me-1.5 fs-5"></i>
                                <span class="text-secondary fw-medium"><?= $o['hp']; ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="ti ti-mail text-muted me-1.5 fs-5"></i>
                                <span><?= $o['email']; ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-icon btn-label-warning shadow-xs btn-edit-ortu" 
                                        data-id="<?= $o['id_user']; ?>" 
                                        data-nama="<?= $o['nama']; ?>" 
                                        data-hp="<?= $o['hp']; ?>" 
                                        data-email="<?= $o['email']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#modalEditOrtu">
                                    <i class="ti ti-edit"></i>
                                </button>
                                
                                <a href="<?= base_url('admin/orangtua/hapus/' . $o['id_user']); ?>" class="btn btn-sm btn-icon btn-label-danger shadow-xs" onclick="return confirm('Menghapus data orang tua akan memengaruhi relasi data siswa. Lanjutkan?')">
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

<div class="modal fade" id="modalTambahOrtu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-label-primary p-4">
                <h5 class="modal-title text-primary fw-bold"><i class="ti ti-user-plus me-1"></i> Registrasi Wali Murid Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('admin/orangtua/tambah'); ?>
            <div class="modal-body p-4">
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label for="nama_ortu" class="form-label fw-medium">Nama Lengkap</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="nama_ortu" name="nama" class="form-control" placeholder="Nama wali murid" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="hp" class="form-label fw-medium">Nomor HP / WhatsApp</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-brand-whatsapp"></i></span>
                            <input type="text" id="hp" name="hp" class="form-control" placeholder="Contoh: 0822xxxxxxxx" required />
                        </div>
                    </div>
                </div>
                <div class="row g-3 mb-2">
                    <div class="col-12 col-md-6">
                        <label for="email_ortu" class="form-label fw-medium">Email Login</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                            <input type="email" id="email_ortu" name="email" class="form-control" placeholder="ortu@sekolah.com" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="password_ortu" class="form-label fw-medium">Sandi Akses</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-key"></i></span>
                            <input type="password" id="password_ortu" name="password" class="form-control" placeholder="••••••••" required />
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

<div class="modal fade" id="modalEditOrtu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-label-warning p-4">
                <h5 class="modal-title text-warning fw-bold"><i class="ti ti-user-edit me-1"></i> Ubah Data Wali Murid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('', ['id' => 'formEditOrtu']); ?>
            <div class="modal-body p-4">
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label for="edit_nama" class="form-label fw-medium">Nama Lengkap</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="edit_nama" name="nama" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="edit_hp" class="form-label fw-medium">Nomor HP / WhatsApp</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-brand-whatsapp"></i></span>
                            <input type="text" id="edit_hp" name="hp" class="form-control" required />
                        </div>
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
                        <label for="edit_password" class="form-label fw-medium text-warning">Password Baru (Opsional)</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-key"></i></span>
                            <input type="password" id="edit_password" name="password" class="form-control" placeholder="Isi jika ingin diubah" />
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
        // 1. Inisialisasi DataTables + Fitur Pencarian Global Riil-time
        if ($.fn.DataTable) {
            $('#tableOrtuData').DataTable({
                "language": {
                    "search": "Cari Wali:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Data orang tua tidak ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Record kosong",
                    "paginate": {
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10,
                "responsive": true
            });
        }

        // 2. Data Binding: Lempar baris kolom tabel ke Form internal Modal Edit
        $('.btn-edit-ortu').on('click', function() {
            const id    = $(this).data('id');
            const nama  = $(this).data('nama');
            const hp    = $(this).data('hp');
            const email = $(this).data('email');

            // Inject nilai data ke elemen input modal edit
            $('#edit_nama').val(nama);
            $('#edit_hp').val(hp);
            $('#edit_email').val(email);
            $('#edit_password').val(''); // Kosongkan placeholder password lama

            // Modifikasi rute action URL pengiriman form agar mengarah ke method update controller Anda
            const base_url_action = "<?= base_url('admin/orangtua/ubah/'); ?>";
            $('#formEditOrtu').attr('action', base_url_action + id);
        });
    });
</script>

<style>
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,.04); }
</style>