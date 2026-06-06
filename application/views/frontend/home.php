<style>
    /* Konfigurasi Hero Slider */
    .hero-section { 
        height: 100vh; 
        min-height: 600px; 
        position: relative; 
        background-color: #1a1a2e; /* Fallback color */
    }
    .swiper { width: 100%; height: 100%; }
    .swiper-slide { 
        position: relative; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        overflow: hidden; 
    }
    
    /* Overlay Kaca Gelap (Agar Teks Terbaca Jelas) */
    .slide-overlay { 
        position: absolute; 
        inset: 0; 
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.4) 100%); 
        z-index: 1; 
    }
    
    /* Gambar Background */
    .slide-bg-img { 
        position: absolute; 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        z-index: 0; 
        animation: zoomEffect 15s infinite alternate; /* Animasi Zoom Halus */
    }

    @keyframes zoomEffect {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }

    /* Trik CSS Canggih Untuk YouTube Background Fullscreen */
    .video-background-wrapper {
        position: absolute;
        inset: 0;
        overflow: hidden;
        z-index: 0;
        background: #000;
    }
    .video-background-wrapper iframe {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        border: 0;
        opacity: 0.92;
    }

    .video-fallback {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.55);
        z-index: 0;
        color: #fff;
        font-size: 1rem;
        padding: 1.5rem;
        text-align: center;
    }

    /* Konten Teks di Dalam Slider */
    .slide-content { 
        position: relative; 
        z-index: 2; 
        color: #fff; 
        padding: 0 20px; 
        opacity: 0; /* Mulai dari hilang untuk animasi masuk */
        transform: translateY(30px);
        transition: all 1s ease-out;
    }
    
    /* Animasi saat slide aktif */
    .swiper-slide-active .slide-content {
        opacity: 1;
        transform: translateY(0);
    }

    /* Tombol Navigasi Slider Custom */
    .swiper-button-next, .swiper-button-prev { 
        color: #fff !important; 
        background: rgba(255,255,255,0.15); 
        padding: 30px; 
        border-radius: 50%; 
        backdrop-filter: blur(8px); 
        transform: scale(0.6); 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
    }
    .swiper-button-next:hover, .swiper-button-prev:hover { 
        background: #7367f0; 
        transform: scale(0.8); 
    }
    .swiper-pagination-bullet-active { background: #7367f0; width: 30px; border-radius: 8px; transition: width 0.3s; }
</style>

<section class="hero-section">
    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">
            
            <?php if (!empty($sliders)) : ?>
                <?php foreach ($sliders as $slide) : ?>
                    <div class="swiper-slide">
                        
                        <?php if ($slide['tipe_media'] == 'video') : ?>
                            <?php 
                                // Ekstrak ID YouTube dari berbagai format URL
                                $yt_id = '';
                                $link = trim($slide['file_media']);
                                if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $link)) {
                                    $yt_id = $link;
                                } elseif (strpos($link, 'youtube.com') !== false || strpos($link, 'youtu.be') !== false) {
                                    // Parse query string untuk format watch?v=...
                                    $query = parse_url($link, PHP_URL_QUERY);
                                    if ($query) {
                                        parse_str($query, $params);
                                        if (!empty($params['v']) && preg_match('/^[a-zA-Z0-9_-]{11}$/', $params['v'])) {
                                            $yt_id = $params['v'];
                                        }
                                    }
                                    // Cek format embed atau shorts
                                    if (empty($yt_id) && preg_match('/youtube\.com\/embed\/([^"&?\/\s]{11})/i', $link, $matches)) {
                                        $yt_id = $matches[1];
                                    }
                                    if (empty($yt_id) && preg_match('/youtube\.com\/shorts\/([^"&?\/\s]{11})/i', $link, $matches)) {
                                        $yt_id = $matches[1];
                                    }
                                    if (empty($yt_id) && preg_match('/youtu\.be\/([^"&?\/\s]{11})/i', $link, $matches)) {
                                        $yt_id = $matches[1];
                                    }
                                }
                            ?>
                            <?php if (!empty($yt_id)) : ?>
                                <div class="video-background-wrapper">
                                    <iframe src="https://www.youtube-nocookie.com/embed/<?= $yt_id; ?>?autoplay=1&mute=1&controls=1&modestbranding=1&rel=0&playsinline=1" allow="autoplay; encrypted-media; fullscreen; picture-in-picture; web-share" allowfullscreen title="Video YouTube <?= htmlspecialchars($slide['judul']); ?>"></iframe>
                                </div>
                            <?php else : ?>
                                <div class="video-fallback">
                                    <div>
                                        Video YouTube tidak dapat ditampilkan. Pastikan link video YouTube valid (watch?v=, youtu.be/, shorts/, embed/).
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php else : ?>
                            
                            <?php 
                                $url_img = (strpos($slide['file_media'], 'http') !== false) 
                                           ? $slide['file_media'] 
                                           : base_url('uploads/sliders/' . $slide['file_media']); 
                            ?>
                            <img src="<?= $url_img; ?>" class="slide-bg-img" alt="<?= $slide['judul']; ?>">
                            
                        <?php endif; ?>

                        <div class="slide-overlay"></div>
                        <div class="container slide-content text-center">
                            
                            <span class="badge bg-primary bg-opacity-25 text-white border border-primary px-3 py-2 rounded-pill mb-3 fw-medium tracking-wide">
                                <i class="ti ti-sparkles me-1"></i> Selamat Datang
                            </span>
                            
                            <h1 class="display-2 fw-extrabold mb-3 text-white lh-sm" style="text-shadow: 0 4px 20px rgba(0,0,0,0.5);">
                                <?= $slide['judul']; ?>
                            </h1>
                            
                            <p class="lead text-light mb-5 fw-light mx-auto" style="max-width: 700px; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">
                                <?= $slide['deskripsi']; ?>
                            </p>
                            
                            <?php if (!empty($slide['teks_tombol'])) : ?>
                                <a href="<?= (strpos($slide['link_tombol'], 'http') !== false) ? $slide['link_tombol'] : base_url($slide['link_tombol']); ?>" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-lg fw-semibold d-inline-flex align-items-center transition-all hover-translate-y">
                                    <?= $slide['teks_tombol']; ?> <i class="ti ti-arrow-right ms-2"></i>
                                </a>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="swiper-slide bg-dark">
                    <div class="container text-center text-white z-2 position-relative">
                        <i class="ti ti-photo-off display-1 mb-4 text-muted"></i>
                        <h2>Data Slider Kosong</h2>
                        <p>Silakan login ke panel Admin untuk mengatur foto atau video beranda.</p>
                        <a href="<?= base_url('auth'); ?>" class="btn btn-light rounded-pill px-4 mt-3">Ke Halaman Login</a>
                    </div>
                </div>
            <?php endif; ?>

        </div>
        
        <div class="swiper-button-next d-none d-md-flex"></div>
        <div class="swiper-button-prev d-none d-md-flex"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<section id="tentang" class="py-5">
    <div class="container py-5">
        <div class="row align-items-center gy-4">
            <div class="col-lg-6">
                <div class="p-5 rounded-4 shadow-sm" style="background: rgba(255,255,255,0.92);">
                    <span class="text-primary fw-semibold small text-uppercase letter-spacing mb-3 d-inline-block">Tentang E-Absensi</span>
                    <h2 class="fw-bold display-6 mb-3 text-dark"><?= $home_about_title; ?></h2>
                    <p class="text-muted fs-5 mb-4"><?= $home_about_subtitle; ?></p>
                    <p class="text-secondary mb-4 lh-lg"><?= $home_about_description; ?></p>
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="#fitur" class="btn btn-primary btn-lg rounded-pill px-5 py-3">Lihat Fitur</a>
                        <a href="<?= base_url('auth'); ?>" class="btn btn-outline-primary btn-lg rounded-pill px-5 py-3">Masuk Portal</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-4 rounded-4 bg-primary bg-opacity-10 h-100">
                            <h3 class="fw-bold text-primary">100%</h3>
                            <p class="mb-0 text-muted">Kesiapan Absensi Digital</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 rounded-4 bg-success bg-opacity-10 h-100">
                            <h3 class="fw-bold text-success">24/7</h3>
                            <p class="mb-0 text-muted">Pemantauan Gerbang Sekolah</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 rounded-4 bg-warning bg-opacity-10 h-100">
                            <h3 class="fw-bold text-warning">Real-time</h3>
                            <p class="mb-0 text-muted">Laporan Kehadiran Instan</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 rounded-4 bg-info bg-opacity-10 h-100">
                            <h3 class="fw-bold text-info">Aman</h3>
                            <p class="mb-0 text-muted">Kontrol Akses Siswa Terstruktur</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .feature-card { 
        border: 1px solid rgba(0,0,0,0.05); 
        border-radius: 20px; 
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
        background: #fff; 
        overflow: hidden;
    }
    .feature-card:hover { 
        transform: translateY(-12px); 
        box-shadow: 0 20px 40px rgba(115, 103, 240, 0.1); 
        border-color: rgba(115, 103, 240, 0.3); 
    }
    .icon-box-lg { 
        width: 75px; 
        height: 75px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border-radius: 18px; 
        font-size: 36px; 
        margin-bottom: 24px; 
    }
</style>

<section id="fitur" class="py-5" style="background-color: #f8f9fa;">
    <div class="container py-5">
        <div class="text-center mb-5 pb-3">
            <span class="text-primary fw-bold text-uppercase small tracking-widest">Sistem Pintar</span>
            <h2 class="fw-bolder mt-2 display-6 text-dark">Layanan Unggulan E-Absensi</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 600px;">Kami menghadirkan inovasi teknologi untuk memastikan kedisiplinan dan keamanan lingkungan pendidikan secara *real-time*.</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card h-100 p-5 position-relative">
                    <div class="icon-box-lg bg-primary bg-opacity-10 text-primary"><i class="ti ti-qrcode"></i></div>
                    <h4 class="fw-bold mb-3">Tapping Ultra Cepat</h4>
                    <p class="text-muted mb-0 lh-lg">Pemindaian identitas siswa dalam hitungan milidetik. Bebas macet dan antrean panjang di gerbang sekolah.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card h-100 p-5">
                    <div class="icon-box-lg bg-success bg-opacity-10 text-success"><i class="ti ti-brand-whatsapp"></i></div>
                    <h4 class="fw-bold mb-3">Notifikasi WhatsApp</h4>
                    <p class="text-muted mb-0 lh-lg">Wali murid menerima laporan jam masuk dan status kehadiran secara otomatis langsung ke *smartphone* mereka.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card h-100 p-5">
                    <div class="icon-box-lg bg-warning bg-opacity-10 text-warning"><i class="ti ti-file-analytics"></i></div>
                    <h4 class="fw-bold mb-3">Rekapitulasi Instan</h4>
                    <p class="text-muted mb-0 lh-lg">Laporan data kehadiran harian hingga bulanan tersusun otomatis, siap dicetak kapan saja tanpa rekap manual.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="kontak" class="py-5" style="background-color: #ffffff;">
    <div class="container py-5">
        <div class="row align-items-center gy-4">
            <div class="col-lg-6">
                <div class="p-5 rounded-4 shadow-sm" style="background: rgba(248,249,250,0.95);">
                    <span class="text-primary fw-semibold small text-uppercase letter-spacing mb-3 d-inline-block">Kontak</span>
                    <h2 class="fw-bold display-6 mb-3 text-dark"><?= $home_contact_title; ?></h2>
                    <p class="text-muted fs-5 mb-4"><?= $home_contact_subtitle; ?></p>
                    <div class="mb-3">
                        <h6 class="fw-semibold mb-2">Telepon</h6>
                        <p class="mb-0 text-secondary"><a href="tel:<?= preg_replace('/[^0-9\+]/', '', $home_contact_phone); ?>" class="text-decoration-none text-dark"><?= $home_contact_phone; ?></a></p>
                    </div>
                    <div class="mb-3">
                        <h6 class="fw-semibold mb-2">Email</h6>
                        <p class="mb-0 text-secondary"><a href="mailto:<?= $home_contact_email; ?>" class="text-decoration-none text-dark"><?= $home_contact_email; ?></a></p>
                    </div>
                    <div class="mb-0">
                        <h6 class="fw-semibold mb-2">Alamat</h6>
                        <p class="mb-0 text-secondary"><?= nl2br(htmlspecialchars($home_contact_address)); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-5 rounded-4 shadow-sm h-100" style="background: rgba(115,103,240,0.05); border: 1px solid rgba(115,103,240,0.12);">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <span class="text-primary d-block fw-semibold">Punya pertanyaan?</span>
                            <p class="mb-0 text-muted">Tim support kami siap menjawab kebutuhan sekolah dan wali murid kapan saja.</p>
                        </div>
                        <i class="ti ti-phone-call text-primary fs-1"></i>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-white shadow-sm">
                                <h6 class="fw-semibold mb-2">Hubungi lewat telepon</h6>
                                <p class="mb-0 text-muted"><a href="tel:<?= preg_replace('/[^0-9\+]/', '', $home_contact_phone); ?>" class="text-decoration-none"><?= $home_contact_phone; ?></a></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-white shadow-sm">
                                <h6 class="fw-semibold mb-2">Kirim email</h6>
                                <p class="mb-0 text-muted"><a href="mailto:<?= $home_contact_email; ?>" class="text-decoration-none"><?= $home_contact_email; ?></a></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-white shadow-sm">
                                <h6 class="fw-semibold mb-2">Kantor</h6>
                                <p class="mb-0 text-muted"><?= nl2br(htmlspecialchars($home_contact_address)); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>