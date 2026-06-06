<div class="d-flex justify-content-between align-items-center py-4 mb-2">
    <div>
        <h4 class="mb-1"><span class="text-muted fw-light">Akademik /</span> Kelola Kelas</h4>
        <p class="text-muted small mb-0">Manajemen data rumpun kelas dan jenjang pendidikan siswa.</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
        <i class="ti ti-plus me-1"></i> Tambah Kelas
    </button>
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
        <table class="table table-striped table-hover border-top" id="tableKelasData">
            <thead>
                <tr>
                    <th style="width: 10%;">No</th>
                    <th>Nama Rumpun Kelas</th>
                    <th class="text-center" style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($kelas as $k) : ?>
                    <tr>
                        <td><strong><?= $no++; ?></strong></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="badge bg-label-primary p-2.5 rounded-3 me-2">
                                    <i class="ti ti-building-community fs-5"></i>
                                </div>
                                <span class="fw-bold text-heading fs-6"><?= $k['nama_kelas']; ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-icon btn-label-warning shadow-xs btn-edit-kelas" 
                                        data-id="<?= $k['id_kelas']; ?>" 
                                        data-nama="<?= $k['nama_kelas']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#modalUbahKelas">
                                    <i class="ti ti-edit"></i>
                                </button>
                                
                                <a href="<?= base_url('admin/akademik/kelas_hapus/' . $k['id_kelas']); ?>" 
                                   class="btn btn-sm btn-icon btn-label-danger shadow-xs" 
                                   onclick="return confirm('Menghapus kelas dapat berdampak pada data siswa terkait. Lanjutkan?')">
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

<div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-label-primary p-4">
                <h5 class="modal-title text-primary fw-bold"><i class="ti ti-square-plus me-1"></i> Tambah Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('admin/akademik/kelas_tambah'); ?>
            <div class="modal-body p-4">
                <div class="mb-2">
                    <label for="nama_kelas_add" class="form-label fw-medium">Nama Kelas</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-building"></i></span>
                        <input type="text" id="nama_kelas_add" name="nama_kelas" class="form-control" placeholder="Contoh: XI IPA 1" required />
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top pt-3">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Simpan</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUbahKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-label-warning p-4">
                <h5 class="modal-title text-warning fw-bold"><i class="ti ti-edit me-1"></i> Ubah Data Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('', ['id' => 'formUbahKelas']); ?>
            <div class="modal-body p-4">
                <div class="mb-2">
                    <label for="nama_kelas_edit" class="form-label fw-medium">Nama Kelas</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-building"></i></span>
                        <input type="text" id="nama_kelas_edit" name="nama_kelas" class="form-control" required />
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top pt-3">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning"><i class="ti ti-refresh me-1"></i> Perbarui</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Inisialisasi DataTables dengan Pencarian Instan
        if ($.fn.DataTable) {
            $('#tableKelasData').DataTable({
                "language": {
                    "search": "Cari Kelas:",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "zeroRecords": "Data kelas tidak ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Tidak ada record data",
                    "paginate": {
                        "next": "Suatu",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10,
                "responsive": true
            });
        }

        // 2. Proses Pengiriman Data Baris ke Form Modal Edit Secar Dinamis
        $('.btn-edit-kelas').on('click', function() {
            const id_kelas  = $(this).data('id');
            const nama_kelas = $(this).data('nama');

            // Set nilai input di form modal edit
            $('#nama_kelas_edit').val(nama_kelas);
            
            // Set action attribute form secara dinamis mengarah ke id_kelas tujuan
            const base_url_action = "<?= base_url('admin/akademik/kelas_ubah/'); ?>";
            $('#formUbahKelas').attr('action', base_url_action + id_kelas);
        });
    });
</script>

<style>
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,.04); }
</style>