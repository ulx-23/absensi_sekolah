<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center py-4 mb-2 gap-3">
    <div>
        <h4 class="mb-1"><span class="text-muted fw-light">Laporan /</span> Cetak Laporan Harian</h4>
        <p class="text-muted small mb-0">Pratinjau rekapitulasi data *tapping* gerbang siswa sebelum dicetak ke lembar fisik.</p>
    </div>
    <a href="<?= base_url('petugas/laporan/cetak_harian'); ?>" target="_blank" class="btn btn-success shadow-sm w-100 w-sm-auto">
        <i class="ti ti-printer me-1.5"></i> Cetak Laporan Hari Ini
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-label-secondary p-4 d-flex align-items-center justify-content-between border-bottom-0">
        <h5 class="mb-0 text-dark fw-bold"><i class="ti ti-file-text me-2 text-secondary"></i> Data Log Kehadiran Hari Ini</h5>
        <span class="badge bg-label-dark rounded-pill"><?= date('d-m-Y'); ?></span>
    </div>
    <div class="card-datatable table-responsive p-4 pt-0">
        <table class="table table-striped table-hover border-top" id="tablePratinjauHarian">
            <thead>
                <tr>
                    <th style="width: 80px;">No</th>
                    <th>Jam Masuk</th>
                    <th>NIS</th>
                    <th>Nama Lengkap Siswa</th>
                    <th style="width: 15%;">Kelas</th>
                    <th style="width: 15%;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($absensi)) : ?>
                    <?php $no = 1; foreach ($absensi as $a) : ?>
                        <tr>
                            <td><strong><?= $no++; ?></strong></td>
                            <td>
                                <div class="d-flex align-items-center text-heading fw-medium">
                                    <i class="ti ti-clock text-muted me-1.5 ti-xs"></i>
                                    <span><?= date('H:i', strtotime($a['jam_masuk'])); ?> WIB</span>
                                </div>
                            </td>
                            <td><span class="text-secondary fw-semibold"><?= $a['nis']; ?></span></td>
                            <td>
                                <span class="fw-bold text-heading"><?= $a['nama_siswa']; ?></span>
                            </td>
                            <td><span class="badge bg-label-info px-2.5 py-1 rounded-pill fw-medium"><?= $a['kelas']; ?></span></td>
                            <td>
                                <?php if ($a['status'] == 'hadir') : ?>
                                    <span class="badge bg-label-success px-2.5 py-1 rounded-pill w-100 text-center fw-bold">
                                        <i class="ti ti-circle-check-toggle ti-xs me-1"></i> Hadir
                                    </span>
                                <?php else : ?>
                                    <span class="badge bg-label-warning px-2.5 py-1 rounded-pill w-100 text-center fw-bold">
                                        <i class="ti ti-alert-triangle ti-xs me-1"></i> Terlambat
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted italic">Tidak ada aktivitas absensi siswa untuk dicetak hari ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi DataTables untuk menyaring pratinjau log harian petugas
        if ($.fn.DataTable) {
            $('#tablePratinjauHarian').DataTable({
                "language": {
                    "search": "Cari Murid/Kelas:",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "zeroRecords": "Tidak ada data kesesuaian aktivitas absensi hari ini",
                    "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Belum ada record data masuk",
                    "paginate": {
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10,
                "order": [[0, "asc"]], // Berurutan berdasarkan nomor log pertama masuk
                "responsive": true
            });
        }
    });
</script>

<style>
    /* Sinkronisasi margin padding dataTables agar presisi */
    .card-datatable {
        padding-top: 0 !important;
    }
</style>