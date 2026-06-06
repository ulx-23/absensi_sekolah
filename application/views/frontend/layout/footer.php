</main>
<footer class="footer-modern pt-5 pb-5 mt-auto">
        <div class="container position-relative">
            <div class="row gy-5">
                <div class="col-lg-4">
                    <div class="footer-card p-4 rounded-4 h-100">
                        <a class="d-flex align-items-center fw-bold fs-4 text-white text-decoration-none mb-3" href="#">
                            <span class="d-inline-flex align-items-center justify-content-center bg-white text-primary rounded-3 me-3" style="width:48px;height:48px;">
                                <i class="ti ti-books fs-4"></i>
                            </span>
                            E-Absensi
                        </a>
                        <p class="text-white-75 small lh-lg">Menyatukan kehadiran siswa dengan pengalaman antarmuka yang tenang, teratur, dan profesional — layaknya ruang perpustakaan digital untuk sekolah modern.</p>
                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a href="#" class="btn btn-sm btn-light btn-icon rounded-circle shadow-sm"><i class="ti ti-brand-facebook text-primary"></i></a>
                            <a href="#" class="btn btn-sm btn-light btn-icon rounded-circle shadow-sm"><i class="ti ti-brand-instagram text-primary"></i></a>
                            <a href="#" class="btn btn-sm btn-light btn-icon rounded-circle shadow-sm"><i class="ti ti-brand-youtube text-primary"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4">
                    <h6 class="footer-heading fw-semibold mb-3">Layanan</h6>
                    <ul class="list-unstyled footer-links small">
                        <li class="mb-2"><a href="#">Absensi QR</a></li>
                        <li class="mb-2"><a href="#">Jadwal Harian</a></li>
                        <li class="mb-2"><a href="#">Laporan Siswa</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-4">
                    <h6 class="footer-heading fw-semibold mb-3">Info Cepat</h6>
                    <ul class="list-unstyled footer-links small">
                        <li class="mb-2"><a href="#">Tentang Kami</a></li>
                        <li class="mb-2"><a href="#">Panduan Orang Tua</a></li>
                        <li class="mb-2"><a href="#">Pusat Bantuan</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h6 class="footer-heading fw-semibold mb-3">Hubungi Kami</h6>
                    <ul class="list-unstyled text-white-75 small">
                        <li class="mb-3 d-flex align-items-start"><i class="ti ti-map-pin me-2 text-info mt-1"></i>Jl. Pendidikan No. 1, Kota Pelajar</li>
                        <li class="mb-3 d-flex align-items-start"><i class="ti ti-mail me-2 text-info mt-1"></i>info@sekolah.sch.id</li>
                        <li class="d-flex align-items-start"><i class="ti ti-phone me-2 text-info mt-1"></i>(021) 1234-5678</li>
                    </ul>
                </div>
            </div>

            <div class="border-top border-white border-opacity-10 mt-5 pt-4 text-center">
                <p class="mb-0 footer-meta small">&copy; <?= date('Y'); ?> E-Absensi System. Seluruh Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        // Efek Navbar Shadow saat di-scroll
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNav');
            if (window.scrollY > 30) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // HANYA jalankan script Swiper JIKA elemen swiper ada di halaman ini
        if (document.querySelector('.heroSwiper')) {
            const swiper = new Swiper('.heroSwiper', {
                autoplay: { delay: 6000, disableOnInteraction: false },
                loop: true,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                pagination: { el: '.swiper-pagination', clickable: true, dynamicBullets: true },
                on: {
                    slideChangeTransitionStart: function () {
                        const videos = document.querySelectorAll('video');
                        videos.forEach(vid => vid.pause());
                        const activeSlide = this.slides[this.activeIndex];
                        const activeVideo = activeSlide.querySelector('video');
                        if(activeVideo) activeVideo.play();
                    }
                }
            });
        }
    </script>
</body>
</html>