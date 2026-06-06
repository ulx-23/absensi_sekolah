<div class="py-4 mb-2">
    <h4 class="mb-1"><span class="text-muted fw-light">Konfigurasi /</span> Pengaturan Notifikasi</h4>
    <p class="text-muted small mb-0">Kelola gateway media distribusi informasi dan standardisasi draf laporan kehadiran wali murid.</p>
</div>

<?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-circle-check me-2 text-success"></i>
        <div><?= $this->session->flashdata('success'); ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?= form_open('admin/notifikasi/update'); ?>
<div class="row g-4">
    <div class="col-12 col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-label-primary p-4">
                <h5 class="mb-0 text-primary fw-bold"><i class="ti ti-toggle-left me-1"></i> Jalur Media Notifikasi</h5>
            </div>
            <div class="card-body pt-4">
                <p class="text-muted small mb-4">Aktifkan sakelar di bawah ini untuk menentukan melalui jalur mana laporan *real-time* gerbang sekolah akan didistribusikan:</p>
                
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-label-success rounded-3 me-3 p-2.5">
                            <i class="ti ti-brand-whatsapp text-success fs-3"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-heading">WhatsApp API Gateway</h6>
                            <small class="text-muted">Kirim pesan instan via Fonnte</small>
                        </div>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input custom-switch" type="checkbox" name="notif_whatsapp" value="aktif" <?= ($config['notif_whatsapp'] == 'aktif') ? 'checked' : ''; ?>>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center border-bottom py-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-label-info rounded-3 me-3 p-2.5">
                            <i class="ti ti-brand-telegram text-info fs-3"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-heading">Telegram Bot System</h6>
                            <small class="text-muted">Notifikasi telegram token chat</small>
                        </div>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input custom-switch" type="checkbox" name="notif_telegram" value="aktif" <?= ($config['notif_telegram'] == 'aktif') ? 'checked' : ''; ?>>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center py-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-label-danger rounded-3 me-3 p-2.5">
                            <i class="ti ti-mail text-danger fs-3"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-heading">Surat Elektronik (Email)</h6>
                            <small class="text-muted">Kirim via SSL/TLS SMTP Mailer</small>
                        </div>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input custom-switch" type="checkbox" name="notif_email" value="aktif" <?= ($config['notif_email'] == 'aktif') ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-label-success p-4">
                <h5 class="mb-0 text-success fw-bold"><i class="ti ti-file-text me-1"></i> Standar Draf Pesan</h5>
            </div>
            <div class="card-body pt-4">
                <div class="bg-label-secondary rounded-3 p-3 mb-4 border">
                    <h6 class="fw-bold mb-1.5 text-dark"><i class="ti ti-code me-1 text-primary"></i> Kode Glosarium Variabel:</h6>
                    <p class="small text-muted mb-3">Klik tombol variabel di bawah ini untuk menyisipkannya ke dalam text editor secara otomatis:</p>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-sm btn-white text-heading border shadow-2xs btn-tag" data-tag="{nama}"><code>{nama}</code></button>
                        <button type="button" class="btn btn-sm btn-white text-heading border shadow-2xs btn-tag" data-tag="{nis}"><code>{nis}</code></button>
                        <button type="button" class="btn btn-sm btn-white text-heading border shadow-2xs btn-tag" data-tag="{kelas}"><code>{kelas}</code></button>
                        <button type="button" class="btn btn-sm btn-white text-heading border shadow-2xs btn-tag" data-tag="{tanggal}"><code>{tanggal}</code></button>
                        <button type="button" class="btn btn-sm btn-white text-heading border shadow-2xs btn-tag" data-tag="{jam}"><code>{jam}</code></button>
                        <button type="button" class="btn btn-sm btn-white text-heading border shadow-2xs btn-tag" data-tag="{status}"><code>{status}</code></button>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="template" class="form-label fw-semibold text-heading">Konfigurasi Teks Konten</label>
                    <textarea id="template" name="template_notif" rows="5" class="form-control" placeholder="Tulis format notifikasi disini..." required><?= $config['template_notif']; ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-heading text-primary"><i class="ti ti-eye me-0.5"></i> Live Interaktif Preview Pesan</label>
                    <div class="p-3 bg-light rounded-3 border border-dashed text-secondary font-monospace small" id="livePreviewContainer" style="white-space: pre-wrap; word-break: break-all;"></div>
                </div>
                
                <div class="d-flex justify-content-end border-top pt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-4 shadow-xs">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Konfigurasi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const textarea = document.getElementById('template');
        const previewContainer = document.getElementById('livePreviewContainer');
        const tagButtons = document.querySelectorAll('.btn-tag');

        // Data dummy penunjang visualisasi translasi preview
        const dummyData = {
            '{nama}': 'Muhammad Ulul Azmi',
            '{nis}': '235520110',
            '{kelas}': 'XII TKJ 1',
            '{tanggal}': '<?= date('d-m-Y') ?>',
            '{jam}': '07:12',
            '{status}': 'Hadir (Tepat Waktu)'
        };

        // 1. Fungsi Penerjemah Teks Ke Format Dummy Real-time
        function updatePreview() {
            let currentText = textarea.value;
            
            // Lakukan perulangan replace kata kunci placeholder
            for (const [key, value] of Object.entries(dummyData)) {
                // Regex global untuk mengganti semua kata kunci yang sama
                const regex = new RegExp(key, 'g');
                currentText = currentText.replace(regex, `<strong>${value}</strong>`);
            }
            
            previewContainer.innerHTML = currentText || '<span class="text-muted italic">Belum ada draf pesan teks tertulis...</span>';
        }

        // Jalankan fungsi saat pertama kali halaman dimuat
        updatePreview();

        // Daftarkan listener pengetikan teks
        textarea.addEventListener('input', updatePreview);

        // 2. Fungsi Klik Tombol Variabel Langsung Masuk Ke Posisi Kursor Textarea
        tagButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tagValue = this.getAttribute('data-tag');
                const startPos = textarea.selectionStart;
                const endPos = textarea.selectionEnd;
                
                // Sisipkan tag tepat di tengah-tengah posisi kedipan kursor terakhir
                textarea.value = textarea.value.substring(0, startPos) + tagValue + textarea.value.substring(endPos, textarea.value.length);
                
                // Kembalikan fokus kursor dan posisinya setelah teks disisipkan
                textarea.focus();
                textarea.selectionStart = textarea.selectionEnd = startPos + tagValue.length;
                
                // Trigger pembaruan kotak preview
                updatePreview();
            });
        });
    });
</script>

<style>
    /* Kostumisasi Tombol Switch Toggle agar Lebih Proporsional dan Ergonomis */
    .custom-switch {
        width: 2.8em !important;
        height: 1.5em !important;
        cursor: pointer;
    }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,.04); }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,.03); }
    .border-dashed { border-style: dashed !important; }
</style>