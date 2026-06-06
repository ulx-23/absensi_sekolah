<div class="py-4 mb-2">
    <h4 class="mb-1"><span class="text-muted fw-light">Monitoring /</span> Riwayat Absensi Anak</h4>
    <p class="text-muted small mb-0">Lihat dan lacak seluruh rekam jejak log kehadiran anak Anda secara transparan.</p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-label-primary p-4 d-flex align-items-center justify-content-between border-bottom-0">
        <h5 class="mb-0 text-primary fw-bold"><i class="ti ti-calendar-stats me-1"></i> Log Kehadiran Keseluruhan</h5>
        <span class="badge bg-primary rounded-pill">Data Terintegrasi</span>
    </div>
    <div class="card-datatable table-responsive p-4 pt-0">
        <table class="table table-striped table-hover border-top" id="tableRiwayatAnak">
            <thead>
                <tr>
                    <th style="width: 15%;">Tanggal</th>
                    <th>Nama Anak (NIS)</th>
                    <th style="width: 12%;">Kelas</th>
                    <th style="width: 18%;">Jam Masuk</th>
                    <th style="width: 15%;">Status Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($riwayat)) : ?>
                    <?php foreach ($riwayat as $r) : ?>
                        <tr>
                            <td><strong><?= date('d-m-Y', strtotime($r['tanggal'])); ?></strong></td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-heading"><?= $r['nama_siswa']; ?></span>
                                    <small class="text-muted">NIS: <?= $r['nis']; ?></small>
                                </div>
                            </td>
                            <td><span class="badge bg-label-info px-2.5 py-1 rounded-pill fw-medium"><?= $r['kelas']; ?></span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-clock text-muted me-1.5 ti-xs"></i>
                                    <span class="fw-medium text-secondary"><?= date('H:i', strtotime($r['jam_masuk'])); ?> WIB</span>
                                </div>
                            </td>
                            <td>
                                <?php if ($r['status'] == 'hadir') : ?>
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
                        <td colspan="5" class="text-center py-5 text-muted italic">Belum ada riwayat absensi tercatat untuk anak Anda.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi DataTables untuk menyaring log pencarian absensi anak
        if ($.fn.DataTable) {
            $('#tableRiwayatAnak').DataTable({
                "language": {
                    "search": "Cari Log:",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "zeroRecords": "Maaf, riwayat kehadiran tidak ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Belum ada rekaman log",
                    "paginate": {
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10,
                "order": [[0, "desc"]], // Menyusun otomatis dari tanggal paling baru (terkini)
                "responsive": true
            });
        }
    });
</script>

<style>
    /* Mengurangi padding atas datatable agar rapat dengan header card label */
    .card-datatable {
        padding-top: 0 !important;
    }
</style>