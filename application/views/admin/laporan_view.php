<div class="py-4 mb-2">
    <h4 class="mb-1"><span class="text-muted fw-light">Laporan /</span> Rekap Absensi</h4>
    <p class="text-muted small mb-0">Laporan rekapitulasi penjejakan kehadiran siswa berdasarkan rentang waktu dan filter kelas.</p>
</div>

<div class="card mb-5 shadow-sm border-0">
    <div class="card-header bg-label-primary p-4 d-flex align-items-center">
        <h5 class="mb-0 text-primary fw-bold"><i class="ti ti-filter me-2"></i> Parameter Filter Data</h5>
    </div>
    <div class="card-body pt-4">
        <form method="GET" action="<?= base_url('admin/laporan'); ?>">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label fw-medium text-heading">Tanggal Mulai</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                        <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai; ?>" />
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label fw-medium text-heading">Tanggal Selesai</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-calendar-end"></i></span>
                        <input type="date" name="tgl_selesai" class="form-control" value="<?= $tgl_selesai; ?>" />
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label fw-medium text-heading">Pilih Kelas</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-building-community"></i></span>
                        <select name="kelas" class="form-select">
                            <option value="">-- Semua Kelas --</option>
                            <?php foreach ($kelas_list as $k) : ?>
                                <option value="<?= $k['nama_kelas']; ?>" <?= ($kelas_pilih == $k['nama_kelas']) ? 'selected' : ''; ?>><?= $k['nama_kelas']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="d-flex gap-2 w-100">
                        <button type="submit" class="btn btn-primary flex-grow-1 shadow-xs">
                            <i class="ti ti-search me-1"></i> Filter
                        </button>
                        <?php if (!empty($tgl_mulai) || !empty($kelas_pilih)) : ?>
                            <a href="<?= base_url('admin/laporan/cetak?tgl_mulai=' . $tgl_mulai . '&tgl_selesai=' . $tgl_selesai . '&kelas=' . $kelas_pilih); ?>" target="_blank" class="btn btn-label-success px-3 shadow-xs" data-bs-toggle="tooltip" title="Cetak Dokumen Resmi">
                                <i class="ti ti-printer fs-4"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-datatable table-responsive p-4">
        <table class="table table-striped table-hover border-top" id="tableRekapAbsensi">
            <thead>
                <tr>
                    <th style="width: 12%;">Tanggal</th>
                    <th style="width: 12%;">NIS</th>
                    <th>Nama Siswa</th>
                    <th style="width: 12%;">Kelas</th>
                    <th style="width: 15%;">Jam Scan</th>
                    <th style="width: 13%;">Status</th>
                    <th>Petugas Gate</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($absensi)) : ?>
                    <?php foreach ($absensi as $a) : ?>
                        <tr>
                            <td><strong><?= date('d-m-Y', strtotime($a['tanggal'])); ?></strong></td>
                            <td><span class="text-secondary fw-medium"><?= $a['nis']; ?></span></td>
                            <td>
                                <span class="fw-bold text-heading"><?= $a['nama_siswa']; ?></span>
                            </td>
                            <td><span class="badge bg-label-info px-2.5 py-1 rounded-pill fw-medium"><?= $a['kelas']; ?></span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-clock ti-xs me-1 text-muted"></i>
                                    <span><?= date('H:i', strtotime($a['jam_masuk'])); ?> WIB</span>
                                </div>
                            </td>
                            <td>
                                <?php if ($a['status'] == 'hadir') : ?>
                                    <span class="badge bg-label-success px-2.5 py-1 rounded-pill w-100 text-center">
                                        <i class="ti ti-circle-check-toggle ti-xs me-1"></i> Hadir
                                    </span>
                                <?php else : ?>
                                    <span class="badge bg-label-warning px-2.5 py-1 rounded-pill w-100 text-center">
                                        <i class="ti ti-alert-triangle ti-xs me-1"></i> Terlambat
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-shield-user ti-xs me-1 text-muted"></i>
                                    <small class="text-body fw-medium"><?= !empty($a['nama_petugas']) ? $a['nama_petugas'] : '-'; ?></small>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi DataTables untuk rekap data agar bisa disortir harian
        if ($.fn.DataTable) {
            $('#tableRekapAbsensi').DataTable({
                "language": {
                    "search": "Cari data rekap:",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "zeroRecords": "Tidak ada data kesesuaian parameter rekap absensi",
                    "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Belum ada record terkumpul",
                    "paginate": {
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10,
                "order": [[0, "desc"]], // Mengurutkan berdasarkan tanggal terbaru bawaan
                "responsive": true
            });
        }
    });
</script>

<style>
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,.04); }
    .badge-dot { width: 6px; height: 6px; display: inline-block; border-radius: 50%; }
</style>