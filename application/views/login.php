<!doctype html>
<html lang="id" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url('assets/'); ?>" data-template="vertical-menu-template" data-style="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Login - Sistem Absensi QR Code</title>
    
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon/favicon.ico'); ?>" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/fontawesome.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/tabler-icons.css'); ?>" />
    
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/rtl/core.css'); ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/rtl/theme-default.css'); ?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css'); ?>" />
    
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-auth.css'); ?>" />

    <style>
        .auth-card-premium {
            box-shadow: 0 0.5rem 1.5rem rgba(47, 43, 61, 0.12) !important;
            border-radius: 12px;
            border: 1px solid rgba(47, 43, 61, 0.05);
        }
        .input-group-text {
            background-color: transparent;
        }
        /* Efek transisi saat input difokuskan */
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #7367f0;
        }
    </style>
</head>
<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-5">
                
                <div class="card auth-card-premium">
                    <div class="card-body p-4 p-sm-5">
                        
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="<?= base_url(); ?>" class="app-brand-link gap-2 d-flex align-items-center">
                                <span class="app-brand-logo demo">
                                    <div class="avatar bg-label-primary rounded p-2 d-flex align-items-center justify-content-center shadow-sm">
                                        <i class="ti ti-qrcode fs-3"></i>
                                    </div>
                                </span>
                                <span class="app-brand-text demo text-heading fw-bold fs-3">E-Absensi</span>
                            </a>
                        </div>
                        
                        <div class="text-center mb-4">
                            <h4 class="mb-1 fw-bold text-dark">Selamat Datang! 👋</h4>
                            <p class="mb-0 text-muted small">Sistem Absensi QR Code Terpadu</p>
                        </div>

                        <?php if ($this->session->flashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible d-flex align-items-center p-3 mb-4 rounded-3" role="alert">
                                <i class="ti ti-shield-x fs-4 me-2"></i>
                                <div class="small fw-medium"><?= $this->session->flashdata('error'); ?></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (validation_errors()) : ?>
                            <div class="alert alert-warning alert-dismissible d-flex align-items-center p-3 mb-4 rounded-3" role="alert">
                                <i class="ti ti-alert-triangle fs-4 me-2"></i>
                                <div class="small fw-medium"><?= validation_errors('<div class="mb-0">', '</div>'); ?></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?= form_open('auth/proses_login', ['class' => 'mb-3']); ?>
                            
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold text-heading">Alamat Email</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-mail text-muted"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email'); ?>" placeholder="nama@sekolah.com" autofocus required />
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-heading" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-lock text-muted"></i></span>
                                    <input type="password" id="password" class="form-control" name="password" placeholder="••••••••••••" aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer" id="togglePasswordBtn">
                                        <i class="ti ti-eye-off text-muted" id="eyeIcon"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                                    <label class="form-check-label text-muted small" for="remember-me"> Ingat Sesi Saya </label>
                                </div>
                            </div>

                            <button class="btn btn-primary d-grid w-100 mt-4 mb-2 btn-lg shadow-sm font-weight-bold" type="submit">
                                Masuk ke Sistem <i class="ti ti-login ms-2"></i>
                            </button>
                            
                        <?= form_close(); ?>
                    </div>
                </div>
                </div>
        </div>
    </div>

    <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/js/bootstrap.js'); ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePasswordBtn.addEventListener('click', function (e) {
                // Cegah aksi bawaan form jika ada
                e.preventDefault();
                
                // Cek tipe input saat ini
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Ubah ikon mata (silang / terbuka)
                if (type === 'password') {
                    eyeIcon.classList.remove('ti-eye');
                    eyeIcon.classList.add('ti-eye-off');
                } else {
                    eyeIcon.classList.remove('ti-eye-off');
                    eyeIcon.classList.add('ti-eye');
                    // Opsional: ganti warna ikon saat password terlihat
                    eyeIcon.style.color = '#7367f0'; 
                }
            });
        });
    </script>
</body>
</html>