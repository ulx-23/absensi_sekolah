<div class="d-flex justify-content-between align-items-center py-4 mb-2">
    <div>
        <h4 class="mb-1"><span class="text-muted fw-light">Konfigurasi /</span> Kelola Slider Homepage</h4>
        <p class="text-muted small mb-0">Atur visualisasi utama gerbang awal sistem informasi, draf teks, foto, dan link video YouTube.</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSlider">
        <i class="ti ti-plus me-1"></i> Tambah Banner Slider
    </button>
</div>

<?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-circle-check me-2 text-success"></i>
        <div><?= $this->session->flashdata('success'); ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-alert-triangle me-2 text-danger"></i>
        <div class="small fw-medium"><?= $this->session->flashdata('error'); ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-datatable table-responsive p-4">
        <table class="table table-striped table-hover border-top" id="tableSliderData">
            <thead>
                <tr>
                    <th style="width: 25%;">Pratinjau Media</th>
                    <th>Detail Teks Konten</th>
                    <th style="width: 15%;">Tipe Media</th>
                    <th style="width: 15%;">Status</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sliders as $s) : ?>
                    <tr>
                        <td>
                            <div class="rounded-3 overflow-hidden border bg-light d-flex align-items-center justify-content-center shadow-2xs" style="width: 130px; height: 80px; position: relative;">
                                <?php if ($s['tipe_media'] == 'video') : ?>
                                    <?php 
                                        $yt_id = '';
                                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $s['file_media'], $matches);
                                        $yt_id = isset($matches[1]) ? $matches[1] : '';
                                    ?>
                                    <span class="badge bg-danger p-1.5 rounded-circle shadow-sm" style="position: absolute; z-index: 2;"><i class="ti ti-brand-youtube text-white ti-xs"></i></span>
                                    <img src="https://img.youtube.com/vi/<?= $yt_id; ?>/mqdefault.jpg" style="width:100%; height:100%; object-fit: cover; opacity: 0.8;" alt="YouTube Thumbnail">
                                <?php else : ?>
                                    <img src="<?= base_url('uploads/sliders/' . $s['file_media']); ?>" style="width:100%; height:100%; object-fit: cover;" alt="Thumbnail Gambar">
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-heading fs-6 mb-1"><?= $s['judul']; ?></span>
                                <small class="text-muted text-truncate" style="max-width: 300px;"><?= $s['deskripsi']; ?></small>
                            </div>
                        </td>
                        <td>
                            <span class="badge <?= ($s['tipe_media'] == 'video') ? 'bg-label-danger' : 'bg-label-primary'; ?> px-2.5 py-1 fw-semibold">
                                <i class="ti <?= ($s['tipe_media'] == 'video') ? 'ti-brand-youtube' : 'ti-photo'; ?> ti-xs me-1"></i> <?= ucfirst($s['tipe_media']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge <?= ($s['status'] == 'aktif') ? 'bg-label-success' : 'bg-label-secondary'; ?> px-2.5 py-1 rounded-pill">
                                <span class="badge-dot <?= ($s['status'] == 'aktif') ? 'bg-success' : 'bg-secondary'; ?> me-1"></span> <?= ucfirst($s['status']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-icon btn-label-warning shadow-xs btn-edit-slider" 
                                        data-id="<?= $s['id_slider']; ?>" 
                                        data-judul="<?= $s['judul']; ?>" 
                                        data-deskripsi="<?= $s['deskripsi']; ?>" 
                                        data-tipe="<?= $s['tipe_media']; ?>" 
                                        data-file="<?= $s['file_media']; ?>" 
                                        data-tombol="<?= $s['teks_tombol']; ?>" 
                                        data-link="<?= $s['link_tombol']; ?>" 
                                        data-status="<?= $s['status']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#modalEditSlider">
                                    <i class="ti ti-edit"></i>
                                </button>
                                <a href="<?= base_url('admin/sliders/hapus/' . $s['id_slider']); ?>" class="btn btn-sm btn-icon btn-label-danger shadow-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus slider ini?')">
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

<div class="modal fade" id="modalTambahSlider" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-label-primary p-4">
                <h5 class="modal-title text-primary fw-bold"><i class="ti ti-photo-plus me-1"></i> Tambah Banner Slider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open_multipart('admin/sliders/tambah'); ?>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label for="judul_add" class="form-label fw-medium">Judul Utama Slider</label>
                    <input type="text" id="judul_add" name="judul" class="form-control" placeholder="Contoh: Selamat Datang di E-Absensi" required />
                </div>
                <div class="mb-3">
                    <label for="deskripsi_add" class="form-label fw-medium">Deskripsi Penjelas</label>
                    <textarea id="deskripsi_add" name="deskripsi" rows="3" class="form-control" placeholder="Tuliskan draf sub-kalimat promosi/pengumuman disini..." required></textarea>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label for="tipe_add" class="form-label fw-medium">Klasifikasi Media</label>
                        <select id="tipe_add" name="tipe_media" class="form-select">
                            <option value="image">Gambar (.PNG / .JPG)</option>
                            <option value="video">Video YouTube</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="status_add" class="form-label fw-medium">Status Tayang</label>
                        <select id="status_add" name="status" class="form-select">
                            <option value="aktif">Aktif (Tampilkan)</option>
                            <option value="tidak">Arsipkan (Sembunyikan)</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3" id="wrapper_file_add">
                    <label for="file_add" class="form-label fw-medium">Unggah Gambar Resolusi Tinggi <span class="text-danger">*</span></label>
                    <input type="file" id="file_add" name="file_media" accept="image/png, image/jpeg" class="form-control" required />
                    <small class="text-muted mt-1 d-block">Batas maksimal file adalah 5 Megabytes.</small>
                </div>
                
                <div class="mb-3 d-none" id="wrapper_youtube_add">
                    <label for="link_youtube_add" class="form-label fw-medium">Link URL YouTube <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-brand-youtube text-danger"></i></span>
                        <input type="url" id="link_youtube_add" name="link_youtube" class="form-control" placeholder="https://www.youtube.com/watch?v=xxxxx" />
                    </div>
                </div>

                <div class="row g-3 mb-1">
                    <div class="col-6">
                        <label for="btn_add" class="form-label fw-medium">Label Tombol (Opsional)</label>
                        <input type="text" id="btn_add" name="teks_tombol" class="form-control" placeholder="Contoh: Hubungi Kami" />
                    </div>
                    <div class="col-6">
                        <label for="link_add" class="form-label fw-medium">Tautan Arah Link</label>
                        <input type="text" id="link_add" name="link_tombol" class="form-control" placeholder="Contoh: auth atau url luar" />
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top pt-3">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Publikasikan</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditSlider" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-label-warning p-4">
                <h5 class="modal-title text-warning fw-bold"><i class="ti ti-edit me-1"></i> Ubah Parameter Slider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open_multipart('', ['id' => 'formEditSlider']); ?>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label for="edit_judul" class="form-label fw-medium">Judul Utama Slider</label>
                    <input type="text" id="edit_judul" name="judul" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label for="edit_deskripsi" class="form-label fw-medium">Deskripsi Penjelas</label>
                    <textarea id="edit_deskripsi" name="deskripsi" rows="3" class="form-control" required></textarea>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label for="edit_tipe" class="form-label fw-medium">Klasifikasi Media</label>
                        <select id="edit_tipe" name="tipe_media" class="form-select">
                            <option value="image">Gambar (.PNG / .JPG)</option>
                            <option value="video">Video YouTube</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="edit_status" class="form-label fw-medium">Status Tayang</label>
                        <select id="edit_status" name="status" class="form-select">
                            <option value="aktif">Aktif (Tampilkan)</option>
                            <option value="tidak">Arsipkan (Sembunyikan)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3" id="wrapper_file_edit">
                    <label for="file_edit" class="form-label fw-medium text-warning">Ganti Berkas Gambar (Kosongkan jika tidak diubah)</label>
                    <input type="file" id="file_edit" name="file_media" accept="image/png, image/jpeg" class="form-control" />
                </div>

                <div class="mb-3 d-none" id="wrapper_youtube_edit">
                    <label for="link_youtube_edit" class="form-label fw-medium text-warning">Ubah Link URL YouTube <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-brand-youtube text-danger"></i></span>
                        <input type="url" id="link_youtube_edit" name="link_youtube" class="form-control" />
                    </div>
                </div>

                <div class="row g-3 mb-1">
                    <div class="col-6">
                        <label for="edit_teks_tombol" class="form-label fw-medium">Label Tombol</label>
                        <input type="text" id="edit_teks_tombol" name="teks_tombol" class="form-control" />
                    </div>
                    <div class="col-6">
                        <label for="edit_link_tombol" class="form-label fw-medium">Tautan Arah Link</label>
                        <input type="text" id="edit_link_tombol" name="link_tombol" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top pt-3">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning"><i class="ti ti-refresh me-1"></i> Simpan Perubahan</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if ($.fn.DataTable) {
            $('#tableSliderData').DataTable({
                "language": {
                    "search": "Cari Banner:",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "zeroRecords": "Data banner kustom tidak ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    "paginate": { "next": "Berikutnya", "previous": "Sebelumnya" }
                },
                "pageLength": 5,
                "responsive": true
            });
        }

        // --- Logika Toggle Input Modal Tambah ---
        $('#tipe_add').on('change', function() {
            if($(this).val() === 'video') {
                $('#wrapper_file_add').addClass('d-none');
                $('#file_add').removeAttr('required');
                
                $('#wrapper_youtube_add').removeClass('d-none');
                $('#link_youtube_add').attr('required', 'required');
            } else {
                $('#wrapper_youtube_add').addClass('d-none');
                $('#link_youtube_add').removeAttr('required');
                
                $('#wrapper_file_add').removeClass('d-none');
                $('#file_add').attr('required', 'required');
            }
        });

        // --- Logika Toggle Input Modal Edit ---
        $('#edit_tipe').on('change', function() {
            if($(this).val() === 'video') {
                $('#wrapper_file_edit').addClass('d-none');
                $('#wrapper_youtube_edit').removeClass('d-none');
                $('#link_youtube_edit').attr('required', 'required');
            } else {
                $('#wrapper_youtube_edit').addClass('d-none');
                $('#link_youtube_edit').removeAttr('required');
                $('#wrapper_file_edit').removeClass('d-none');
            }
        });

        // --- Logika Lempar Data ke Modal Edit ---
        $('.btn-edit-slider').on('click', function() {
            const id        = $(this).data('id');
            const judul     = $(this).data('judul');
            const deskripsi = $(this).data('deskripsi');
            const tipe      = $(this).data('tipe');
            const tombol    = $(this).data('tombol');
            const link      = $(this).data('link');
            const status    = $(this).data('status');
            const file_val  = $(this).data('file'); // Bisa berupa nama file gambar / url youtube

            $('#edit_judul').val(judul);
            $('#edit_deskripsi').val(deskripsi);
            $('#edit_status').val(status);
            $('#edit_teks_tombol').val(tombol);
            $('#edit_link_tombol').val(link);
            $('#file_edit').val(''); 

            // Trigger perubahan select agar input menyesuaikan
            $('#edit_tipe').val(tipe).trigger('change');

            // Jika tipe yang diedit adalah video, masukkan link youtube lama ke dalam input text
            if(tipe === 'video') {
                $('#link_youtube_edit').val(file_val);
            } else {
                $('#link_youtube_edit').val('');
            }

            const base_url_action = "<?= base_url('admin/sliders/ubah/'); ?>";
            $('#formEditSlider').attr('action', base_url_action + id);
        });
    });
</script>

<style>
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,.04); }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,.04); }
    .badge-dot { width: 6px; height: 6px; display: inline-block; border-radius: 50%; }
</style>