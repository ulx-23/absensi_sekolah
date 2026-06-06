<div class="d-flex justify-content-between align-items-center py-4 mb-2">
    <div>
        <h4 class="mb-1"><span class="text-muted fw-light">Akademik /</span> Tahun Ajaran</h4>
        <p class="text-muted small mb-0">Manajemen periode tahun ajaran aktif untuk pengelompokan rekapitulasi absensi berkala.</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahTahun">
        <i class="ti ti-plus me-1"></i> Tambah Periode
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
        <table class="table table-striped table-hover border-top" id="tableTahunData">
            <thead>
                <tr>
                    <th style="width: 10%;">No</th>
                    <th>Tahun Ajaran</th>
                    <th style="width: 25%;">Status Konfigurasi</th>
                    <th class="text-center" style="width: 25%;">Aksi Operasional</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($tahun as $t) : ?>
                    <tr>
                        <td><strong><?= $no++; ?></strong></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="badge bg-label-primary p-2 rounded-3 me-2.5">
                                    <i class="ti ti-calendar-stats fs-5"></i>
                                </div>
                                <span class="fw-bold text-heading fs-6"><?= $t['tahun_ajaran']; ?></span>
                            </div>
                        </td>
                        <td>
                            <?php if ($t['status'] == 'aktif') : ?>
                                <span class="badge bg-label-success px-2.5 py-1 rounded-pill fw-medium">
                                    <span class="badge-dot bg-success me-1"></span> Aktif Berjalan
                                </span>
                            <?php else : ?>
                                <span class="badge bg-label-secondary px-2.5 py-1 rounded-pill fw-medium">
                                    <span class="badge-dot bg-secondary me-1"></span> Tidak Aktif
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <?php if ($t['status'] != 'aktif') : ?>
                                    <a href="<?= base_url('admin/akademik/tahun_aktifkan/' . $t['id_tahun']); ?>" class="btn btn-sm btn-label-success px-3 shadow-xs d-flex align-items-center gap-1">
                                        <i class="ti ti-circle-check ti-xs"></i> Aktifkan
                                    </a>
                                    <a href="<?= base_url('admin/akademik/tahun_hapus/' . $t['id_tahun']); ?>" class="btn btn-sm btn-icon btn-label-danger shadow-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus periode tahun ajaran ini?')">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                <?php else : ?>
                                    <button class="btn btn-sm btn-label-secondary w-100 shadow-none border-0" disabled data-bs-toggle="tooltip" title="Periode ini sedang digunakan sebagai parameter utama sistem">
                                        <i class="ti ti-lock-open me-1 ti-xs"></i> Sedang Digunakan
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambahTahun" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-label-primary p-4">
                <h5 class="modal-title text-primary fw-bold"><i class="ti ti-calendar-plus me-1"></i> Periode Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('admin/akademik/tahun_tambah'); ?>
            <div class="modal-body p-4">
                <div class="mb-2">
                    <label for="tahun_ajaran_input" class="form-label fw-medium">Tahun Periode</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                        <input type="text" id="tahun_ajaran_input" name="tahun_ajaran" class="form-control" placeholder="Contoh: 2026/2027" required />
                    </div>
                    <small class="text-muted mt-1.5 d-block">Gunakan format pemisah garis miring (`/`).</small>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi DataTables + Fitur Pencarian Pintar Real-time
        if ($.fn.DataTable) {
            $('#tableTahunData').DataTable({
                "language": {
                    "search": "Cari Periode:",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "zeroRecords": "Data periode tahun ajaran tidak ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Record data kosong",
                    "paginate": {
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10,
                "responsive": true
            });
        }
    });
</script>

<style>
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,.04); }
    .badge-dot { width: 6px; height: 6px; display: inline-block; border-radius: 50%; }
</style>