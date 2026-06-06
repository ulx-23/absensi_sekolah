<div class="d-flex justify-content-between align-items-center py-4 mb-2">
    <div>
        <h4 class="mb-1"><span class="text-muted fw-light">Aktivitas /</span> Riwayat Absen Hari Ini</h4>
        <p class="text-muted small mb-0">Pantau log lalu lintas pemindaian kartu siswa yang masuk gerbang secara langsung.</p>
    </div>
    <div class="badge bg-label-primary p-2.5 fs-6 shadow-2xs rounded-3">
        <i class="ti ti-calendar me-1.5"></i> <?= date('d F Y'); ?>
    </div>
</div>

<div class="card mb-5 border-0 shadow-sm bg-label-info">
    <div class="card-body p-4">
        <div class="d-flex align-items-start">
            <div class="avatar bg-info text-white rounded-3 p-2 me-3 shadow-xs">
                <i class="ti ti-info-circle fs-3"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-1 fw-bold text-info">Informasi Petugas Gate</h6>
                <p class="mb-0 text-secondary small">Daftar di bawah ini menampilkan seluruh siswa yang berhasil melakukan pemindaian QR Code pada perangkat ini khusus untuk hari ini saja secara *real-time*.</p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-datatable table-responsive p-4 pt-3">
        <table class="table table-striped table-hover border-top" id="tableRiwayatHariIni">
            <thead>
                <tr>
                    <th style="width: 80px; text-align: center;">No</th>
                    <th style="width: 150px;">Jam Scan</th>
                    <th style="width: 150px;">NIS</th>
                    <th>Nama Lengkap Siswa</th>
                    <th style="width: 150px;">Kelas</th>
                    <th style="width: 150px;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($absensi)) : ?>
                    <?php $no = 1; foreach ($absensi as $a) : ?>
                        <tr>
                            <td style="text-align: center;"><strong><?= $no++; ?></strong></td>
                            <td>
                                <span class="badge bg-label-dark font-medium px-2.5 py-1 rounded-3">
                                    <i class="ti ti-clock me-1 ti-xs text-muted"></i> <?= date('H:i', strtotime($a['jam_masuk'])); ?> WIB
                                </span>
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
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="ti ti-scan-off display-6 d-block mb-2 text-secondary opacity-50"></i>
                            Belum ada aktivitas siswa yang melakukan absensi hari ini.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi DataTables untuk menyaring log data gate harian
        if ($.fn.DataTable) {
            $('#tableRiwayatHariIni').DataTable({
                "language": {
                    "search": "Cari data scan:",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "zeroRecords": "Tidak ada data pemindaian yang cocok hari ini",
                    "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Belum ada record aktivitas masuk",
                    "paginate": {
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10,
                "order": [[0, "desc"]], // Otomatis mengurutkan dari scan terbaru di baris atas
                "responsive": true
            });
        }
    });
</script>

<style>
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,.04); }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,.03); }
</style>