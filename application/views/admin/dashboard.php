<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 bg-label-primary shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between p-4 py-5">
                <div class="card-title mb-0">
                    <h4 class="text-primary mb-1 fw-bold">Selamat Datang di Panel Utama, <?= $this->session->userdata('nama'); ?>! 👋</h4>
                    <p class="mb-0 text-muted small d-none d-sm-block">Sistem monitoring absensi real-time berjalan dengan lancar. Berikut adalah rangkuman aktivitas hari ini.</p>
                </div>
                <div class="badge bg-primary p-2.5 rounded-pill shadow-sm fs-7">
                    <i class="ti ti-calendar-event me-1"></i> <?= date('d F Y'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    
    <div class="col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100 card-analytics">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="avatar bg-label-success rounded-3 p-3">
                        <i class="ti ti-user-check fs-2"></i>
                    </div>
                    <div class="text-end">
                        <p class="mb-0 text-muted small fw-medium">Hadir Hari Ini</p>
                        <h2 class="mb-0 mt-1 fw-bold text-success"><?= $total_hadir; ?></h2>
                    </div>
                </div>
                <div class="mt-4 pt-2 border-top d-flex justify-content-between align-items-center">
                    <small class="text-muted">Siswa tepat waktu</small>
                    <span class="badge bg-label-success rounded-pill px-2 py-0.5 small font-medium">Sesuai Jadwal</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100 card-analytics">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="avatar bg-label-warning rounded-3 p-3">
                        <i class="ti ti-clock-bolt fs-2"></i>
                    </div>
                    <div class="text-end">
                        <p class="mb-0 text-muted small fw-medium">Total Terlambat</p>
                        <h2 class="mb-0 mt-1 fw-bold text-warning"><?= $total_terlambat; ?></h2>
                    </div>
                </div>
                <div class="mt-4 pt-2 border-top d-flex justify-content-between align-items-center">
                    <small class="text-muted">Butuh pembinaan</small>
                    <span class="badge bg-label-warning rounded-pill px-2 py-0.5 small font-medium">Melewati Batas</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100 card-analytics">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="avatar bg-label-danger rounded-3 p-3">
                        <i class="ti ti-user-x fs-2"></i>
                    </div>
                    <div class="text-end">
                        <p class="mb-0 text-muted small fw-medium">Belum Absen</p>
                        <h2 class="mb-0 mt-1 fw-bold text-danger"><?= $total_alfa < 0 ? 0 : $total_alfa; ?></h2>
                    </div>
                </div>
                <div class="mt-4 pt-2 border-top d-flex justify-content-between align-items-center">
                    <small class="text-muted">Tanpa keterangan</small>
                    <span class="badge bg-label-danger rounded-pill px-2 py-0.5 small font-medium">Absen</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100 card-analytics">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="avatar bg-label-info rounded-3 p-3">
                        <i class="ti ti-building-community fs-2"></i>
                    </div>
                    <div class="text-end">
                        <p class="mb-0 text-muted small fw-medium">Total Kelas</p>
                        <h2 class="mb-0 mt-1 fw-bold text-info"><?= $total_kelas; ?></h2>
                    </div>
                </div>
                <div class="mt-4 pt-2 border-top d-flex justify-content-between align-items-center">
                    <small class="text-muted">Seluruh jenjang aktif</small>
                    <span class="badge bg-label-info rounded-pill px-2 py-0.5 small font-medium">Terdata</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header header-elements border-bottom-0 pt-4">
                <h5 class="card-title mb-0 fw-bold">Tren Kehadiran 7 Hari Terakhir</h5>
                <small class="text-muted">Monitoring grafik total akumulasi siswa melakukan tapping scanner harian</small>
            </div>
            <div class="card-body pt-2">
                <div style="position: relative; height:320px; width:100%;">
                    <canvas id="grafikAbsensi"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header pt-4">
                <h5 class="card-title mb-0 fw-bold">Komposisi Hari Ini</h5>
                <small class="text-muted">Rasio status kehadiran siswa</small>
            </div>
            <div class="card-body d-flex flex-column justify-content-between pt-2">
                <div style="position: relative; height:230px; width:100%;" class="mb-4">
                    <canvas id="grafikDonatHariIni"></canvas>
                </div>
                <div class="row text-center g-2 pt-2 border-top">
                    <div class="col-4">
                        <small class="text-muted d-block">Hadir</small>
                        <strong class="text-success"><?= $total_hadir; ?></strong>
                    </div>
                    <div class="col-4">
                        <small class="text-muted d-block">Terlambat</small>
                        <strong class="text-warning"><?= $total_terlambat; ?></strong>
                    </div>
                    <div class="col-4">
                        <small class="text-muted d-block">Absen</small>
                        <strong class="text-danger"><?= $total_alfa < 0 ? 0 : $total_alfa; ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 1. Ambil data JSON dari backend CodeIgniter 3
    const labelGrafikHarian = <?= $label_grafik; ?>;
    const dataGrafikHarian  = <?= $data_grafik; ?>;

    const totalHadir      = <?= $total_hadir; ?>;
    const totalTerlambat  = <?= $total_terlambat; ?>;
    const totalAlfa       = <?= $total_alfa < 0 ? 0 : $total_alfa; ?>;

    // 2. Render Grafik Batang & Garis Gabungan (Tren Kehadiran)
    const ctxLine = document.getElementById('grafikAbsensi').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: labelGrafikHarian.length ? labelGrafikHarian : ['Belum Ada Data'],
            datasets: [{
                label: 'Total Tapping Siswa',
                data: dataGrafikHarian.length ? dataGrafikHarian : [0],
                borderColor: '#7367f0',
                backgroundColor: 'rgba(115, 103, 240, 0.08)',
                tension: 0.4,
                fill: true,
                borderWidth: 3,
                pointBackgroundColor: '#7367f0',
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { drawBorder: false } },
                x: { grid: { display: false } }
            }
        }
    });

    // 3. Render Grafik Donat (Komposisi Kehadiran Hari Ini)
    const ctxDonut = document.getElementById('grafikDonatHariIni').getContext('2d');
    new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Terlambat', 'Belum Absen'],
            datasets: [{
                data: [totalHadir, totalTerlambat, totalAlfa],
                backgroundColor: ['#28c76f', '#ff9f43', '#ea5455'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, padding: 15 } }
            },
            cutout: '75%'
        }
    });
</script>

<style>
    .card-analytics {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-analytics:hover {
        transform: translateY(-4px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.08) !important;
    }
</style>