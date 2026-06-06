<div class="d-flex justify-content-between align-items-center py-4 mb-2">
    <div>
        <h4 class="mb-1"><span class="text-muted fw-light">Aktivitas /</span> Terminal Scanner Gate</h4>
        <p class="text-muted small mb-0">Pos pemeriksaan pemindaian kartu identitas QR Code siswa secara *real-time*.</p>
    </div>
    <div id="clockDisplay" class="badge bg-label-primary p-2.5 fs-6 fw-bold rounded-3 shadow-2xs">
        <i class="ti ti-clock me-1.5 animate-pulse"></i> 00:00:00 WIB
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-md-6">
        <div class="card h-100 shadow-sm border-0 overflow-hidden">
            <div class="card-header bg-label-primary p-4 d-flex align-items-center">
                <h5 class="mb-0 text-primary fw-bold"><i class="ti ti-camera me-2 fs-4"></i> Area Kamera Pemindai</h5>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div id="reader" class="bg-dark rounded-3 overflow-hidden border custom-reader shadow-inner" style="width: 100%;"></div>
                
                <div class="mt-4 p-3 bg-light rounded-3 text-center border border-dashed">
                    <span class="text-secondary small fw-medium d-inline-flex align-items-center">
                        <i class="ti ti-scan text-primary me-2 fs-5 animate-spin-slow"></i> 
                        Hadapkan komponen QR Code pada kartu pelajar siswa ke arah lensa kamera.
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card h-100 shadow-sm border-0 transition-all duration-300" id="cardHasil">
            <div class="card-header bg-label-secondary p-4" id="headerHasil">
                <h5 class="mb-0 text-secondary fw-bold" id="statusTitle">
                    <i class="ti ti-device-watch me-2 fs-4"></i> Menunggu Pemindaian...
                </h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center py-5 px-4 text-center">
                
                <div id="boxIcon" class="rounded-circle p-4 bg-label-secondary mb-4 shadow-2xs transition-all duration-300 animate-hover">
                    <i id="statusIcon" class="ti ti-qrcode text-secondary display-3"></i>
                </div>

                <div id="detailSiswa" class="d-none w-100">
                    <small class="text-muted text-uppercase tracking-widest fw-semibold mb-1 d-block">Identitas Siswa Terpindai</small>
                    <h1 class="fw-extrabold mb-1 text-heading display-6" id="resNama">-</h1>
                    <h4 class="text-secondary mb-4 fw-medium" id="resKelas">-</h4>
                    
                    <div class="d-flex justify-content-center align-items-center gap-3 mt-2">
                        <span class="badge badge-lg fs-5 px-4 py-2.5 shadow-2xs" id="resKondisi">-</span>
                        <span class="badge bg-label-dark badge-lg fs-5 px-3 py-2.5 shadow-2xs fw-bold" id="resJam">
                            <i class="ti ti-alarm me-1"></i> <span id="resJamText">--:--</span>
                        </span>
                    </div>
                </div>

                <div id="placeholderText" class="text-muted py-4">
                    <i class="ti ti-id-badge-off display-4 text-secondary opacity-25 mb-3 d-block"></i>
                    <h5 class="fw-bold text-secondary mb-1">Papan Informasi Kosong</h5>
                    <p class="mb-0 small px-4">Belum ada aktivitas perekaman scan terdeteksi pagi ini. Silakan arahkan kode identitas murid untuk memulai penjejakan absensi otomatis.</p>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    let lastQrResult = null;
    let isProcessing = false;

    // Sediakan Audio Efek Suara (Gunakan Suara Pendek & Nyaring)
    const audioSukses = new Audio('https://assets.mixkit.co/active_storage/sfx/2568/2568-84.wav');
    const audioGagal  = new Audio('https://assets.mixkit.co/active_storage/sfx/911/911-84.wav');

    // Engine Jam Digital Pojok Atas (UX Sync Helper)
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB';
        document.getElementById('clockDisplay').innerHTML = `<i class="ti ti-clock me-1.5 animate-pulse text-primary"></i> ${timeString}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    function onScanSuccess(decodedText, decodedResult) {
        if (isProcessing || decodedText === lastQrResult) {
            return; 
        }

        isProcessing = true;
        lastQrResult = decodedText;

        $.ajax({
            url: "<?= base_url('petugas/dashboard/proses_scan') ?>",
            type: "POST",
            data: { qr_code: decodedText },
            dataType: "JSON",
            success: function(response) {
                let card = document.getElementById('cardHasil');
                let header = document.getElementById('headerHasil');
                let iconBox = document.getElementById('boxIcon');
                let icon = document.getElementById('statusIcon');
                
                document.getElementById('placeholderText').classList.add('d-none');
                document.getElementById('detailSiswa').classList.remove('d-none');

                if (response.status === 'success') {
                    audioSukses.play();
                    
                    header.className = "card-header bg-success p-4";
                    document.getElementById('statusTitle').innerHTML = "<i class='ti ti-circle-check-toggle me-2 fs-4 text-white'></i>" + response.message;
                    iconBox.className = "rounded-circle p-4 bg-label-success mb-4";
                    icon.className = "ti ti-user-check text-success display-3";
                    
                    document.getElementById('resNama').innerText = response.nama;
                    document.getElementById('resKelas').innerText = response.kelas;
                    document.getElementById('resJamText').innerText = response.jam + ' WIB';
                    
                    let cond = document.getElementById('resKondisi');
                    cond.innerText = response.kondisi;
                    cond.className = response.kondisi === 'Hadir' ? 'badge bg-success text-white px-4' : 'badge bg-warning text-white px-4';

                } else if (response.status === 'warning') {
                    audioGagal.play();

                    header.className = "card-header bg-warning p-4";
                    document.getElementById('statusTitle').innerHTML = "<i class='ti ti-alert-triangle me-2 fs-4 text-white'></i> Pemberitahuan Duplikasi";
                    iconBox.className = "rounded-circle p-4 bg-label-warning mb-4";
                    icon.className = "ti ti-refresh-alert text-warning display-3";

                    document.getElementById('resNama').innerText = response.nama;
                    document.getElementById('resKelas').innerText = response.kelas;
                    document.getElementById('resKondisi').className = 'badge bg-warning text-white px-4';
                    document.getElementById('resKondisi').innerText = "Sudah Absen";
                    document.getElementById('resJamText').innerText = "-- : --";
                } else {
                    audioGagal.play();

                    header.className = "card-header bg-danger p-4";
                    document.getElementById('statusTitle').innerHTML = "<i class='ti ti-shield-lock me-2 fs-4 text-white'></i> Akses Ditolak";
                    iconBox.className = "rounded-circle p-4 bg-label-danger mb-4";
                    icon.className = "ti ti-shield-x text-danger display-3";

                    document.getElementById('resNama').innerText = "KARTU TIDAK VALID";
                    document.getElementById('resKelas').innerText = response.message;
                    document.getElementById('resKondisi').className = 'badge bg-danger text-white px-4';
                    document.getElementById('resKondisi').innerText = "Ilegal/Banned";
                    document.getElementById('resJamText').innerText = "-- : --";
                }

                // Kunci scanner selama 2,5 detik demi kestabilan antrean siswa
                setTimeout(() => {
                    isProcessing = false;
                    lastQrResult = null; 
                }, 2500);
            },
            error: function() {
                isProcessing = false;
                lastQrResult = null;
            }
        });
    }

    // Render Scanner Instance
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 20, qrbox: { width: 260, height: 260 }, rememberLastUsedCamera: true }
    );
    html5QrcodeScanner.render(onScanSuccess);
</script>

<style>
    .custom-reader {
        min-height: 340px;
    }
    /* Mengubah Gaya Tombol Bawaan Library html5-qrcode */
    #reader button {
        background-color: #7367f0 !important;
        color: #fff !important;
        border: none !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
        border-radius: 6px !important;
        cursor: pointer !important;
        margin: 15px auto !important;
        display: block !important;
        box-shadow: 0 2px 4px rgba(115, 103, 240, 0.24) !important;
        transition: all 0.2s ease;
    }
    #reader button:hover {
        background-color: #645bbd !important;
        box-shadow: 0 4px 8px rgba(115, 103, 240, 0.35) !important;
    }
    #reader select {
        padding: 8px 12px !important;
        border-radius: 6px !important;
        border: 1px solid #dbdade !important;
        color: #4b4b4b !important;
        outline: none !important;
        margin-bottom: 10px !important;
    }
    .animate-spin-slow {
        animation: spin 3s infinite linear;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .shadow-2xs { box-shadow: 0 1px 3px rgba(0,0,0,.05); }
    .shadow-inner { box-shadow: inset 0 2px 4px rgba(0,0,0,0.2); }
</style>