<div class="d-flex justify-content-between align-items-center py-4 mb-2">
    <div>
        <h4 class="mb-1"><span class="text-muted fw-light">Data Master /</span> Kelola Siswa</h4>
        <p class="text-muted small mb-0">Manajemen kartu identitas digital, sinkronisasi QR Code, dan relasi akun wali murid.</p>
    </div>
    <div>
        <a href="<?= base_url('admin/siswa/generate_ulang_qr'); ?>" class="btn btn-label-secondary me-2 shadow-xs">
            <i class="ti ti-refresh me-1"></i> Sinkronkan QR
        </a>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
            <i class="ti ti-plus me-1"></i> Tambah Siswa
        </button>
    </div>
</div>

<?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-circle-check me-2 text-success"></i>
        <div><?= $this->session->flashdata('success'); ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-datatable table-responsive p-4">
        <table class="table table-striped table-hover border-top" id="tableSiswaData">
            <thead>
                <tr>
                    <th style="width: 12%;">NIS</th>
                    <th>Nama Lengkap Siswa</th>
                    <th style="width: 12%;">Kelas</th>
                    <th>Wali Orang Tua</th>
                    <th style="width: 15%;">Kartu QR Code</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($siswa as $s) : ?>
                    <tr>
                        <td><span class="text-secondary fw-bold"><?= $s['nis']; ?></span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="badge bg-label-primary p-2 rounded-3 me-2.5">
                                    <i class="ti ti-school fs-5"></i>
                                </div>
                                <span class="fw-bold text-heading"><?= $s['nama']; ?></span>
                            </div>
                        </td>
                        <td><span class="badge bg-label-info px-2.5 py-1 rounded-pill fw-medium"><?= $s['kelas']; ?></span></td>
                        <td>
                            <?php if (!empty($s['nama_ortu'])) : ?>
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-users text-muted me-1.5 ti-xs"></i>
                                    <span class="text-body fw-medium"><?= $s['nama_ortu']; ?></span>
                                </div>
                            <?php else : ?>
                                <span class="badge bg-label-danger px-2 py-0.5 rounded-pill small"><i class="ti ti-alert-triangle ti-12px me-1"></i>Belum Terhubung</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php $path_qr = base_url('uploads/qrcode/' . $s['nis'] . '.png'); ?>
                            <div class="d-flex gap-2">
                                <a href="<?= $path_qr; ?>" target="_blank" class="btn btn-sm btn-label-primary px-2" data-bs-toggle="tooltip" title="Lihat di Tab Baru">
                                    <i class="ti ti-qrcode me-1"></i> Lihat
                                </a>
                                <a href="<?= $path_qr; ?>" download="QR_<?= $s['nis'] ?>_<?= $s['nama'] ?>.png" class="btn btn-sm btn-label-success px-2" data-bs-toggle="tooltip" title="Unduh File PNG Kartu">
                                    <i class="ti ti-download"></i> Unduh
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-icon btn-label-warning shadow-xs btn-edit-siswa" 
                                        data-id="<?= $s['id_siswa']; ?>" 
                                        data-nis="<?= $s['nis']; ?>" 
                                        data-nama="<?= $s['nama']; ?>" 
                                        data-kelas="<?= $s['kelas']; ?>" 
                                        data-ortu="<?= $s['id_orangtua']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#modalEditSiswa">
                                    <i class="ti ti-edit"></i>
                                </button>
                                
                                <a href="<?= base_url('admin/siswa/hapus/' . $s['id_siswa'] . '/' . $s['nis']); ?>" class="btn btn-sm btn-icon btn-label-danger shadow-xs" onclick="return confirm('Hapus siswa beserta file QR Code?')">
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

<div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-label-primary p-4">
                <h5 class="modal-title text-primary fw-bold"><i class="ti ti-user-plus me-1"></i> Registrasi Siswa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('admin/siswa/tambah'); ?>
            <div class="modal-body p-4">
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label for="nis_add" class="form-label fw-medium">Nomor Induk Siswa (NIS)</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-id-badge"></i></span>
                            <input type="text" id="nis_add" name="nis" class="form-control" placeholder="Contoh: SIS00125" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="kelas_add" class="form-label fw-medium">Kelas</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-building-community"></i></span>
                            <select id="kelas_add" name="kelas" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach ($kelas as $k) : ?>
                                    <option value="<?= $k['nama_kelas']; ?>"><?= $k['nama_kelas']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="nama_add" class="form-label fw-medium">Nama Lengkap</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-user"></i></span>
                        <input type="text" id="nama_add" name="nama" class="form-control" placeholder="Nama lengkap siswa" required />
                    </div>
                </div>
                <div class="mb-2">
                    <label for="ortu_add" class="form-label fw-medium">Hubungkan ke Akun Orang Tua</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-users"></i></span>
                        <select id="ortu_add" name="id_orangtua" class="form-select">
                            <option value="">-- Pilih Orang Tua (Opsional) --</option>
                            <?php foreach ($orang_tua as $o) : ?>
                                <option value="<?= $o['id_orangtua']; ?>"><?= $o['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top pt-3">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="ti ti-qrcode me-1"></i> Simpan & Buat QR</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditSiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-label-warning p-4">
                <h5 class="modal-title text-warning fw-bold"><i class="ti ti-user-edit me-1"></i> Ubah Informasi Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('', ['id' => 'formEditSiswa']); ?>
            <div class="modal-body p-4">
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label for="edit_nis" class="form-label fw-medium">NIS (Kunci Unik)</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text bg-light"><i class="ti ti-id-badge text-muted"></i></span>
                            <input type="text" id="edit_nis" class="form-control bg-light" disabled />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="edit_kelas" class="form-label fw-medium">Kelas</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-building-community"></i></span>
                            <select id="edit_kelas" name="kelas" class="form-select" required>
                                <?php foreach ($kelas as $k) : ?>
                                    <option value="<?= $k['nama_kelas']; ?>"><?= $k['nama_kelas']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="edit_nama" class="form-label fw-medium">Nama Lengkap</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-user"></i></span>
                        <input type="text" id="edit_nama" name="nama" class="form-control" required />
                    </div>
                </div>
                <div class="mb-2">
                    <label for="edit_ortu" class="form-label fw-medium">Hubungkan Orang Tua</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-users"></i></span>
                        <select id="edit_ortu" name="id_orangtua" class="form-select">
                            <option value="">-- Pilih Orang Tua --</option>
                            <?php foreach ($orang_tua as $o) : ?>
                                <option value="<?= $o['id_orangtua']; ?>"><?= $o['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
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
        // 1. Inisialisasi Fitur Pencarian Global & Pagination DataTables Siswa
        if ($.fn.DataTable) {
            $('#tableSiswaData').DataTable({
                "language": {
                    "search": "Cari Siswa:",
                    "lengthMenu": "Tampilkan _MENU_ data siswa",
                    "zeroRecords": "Maaf, data siswa tidak ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Record database siswa kosong",
                    "paginate": {
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10,
                "responsive": true
            });
        }

        // 2. Logika Pemindahan Baris Data ke dalam Input Form Modal Edit secara Instan
        $('.btn-edit-siswa').on('click', function() {
            const id    = $(this).data('id');
            const nis   = $(this).data('nis');
            const nama  = $(this).data('nama');
            const kelas = $(this).data('kelas');
            const ortu  = $(this).data('ortu');

            // Inject data terarah ke form modal edit
            $('#edit_nis').val(nis);
            $('#edit_nama').val(nama);
            $('#edit_kelas').val(kelas);
            $('#edit_ortu').val(ortu || "");

            // Ubah link form action mengarah ke target ID database
            const base_url_action = "<?= base_url('admin/siswa/ubah/'); ?>";
            $('#formEditSiswa').attr('action', base_url_action + id);
        });
    });
</script>

<style>
    .object-fit-cover { object-fit: cover; }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,.04); }
</style>