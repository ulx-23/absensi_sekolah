<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'E-Absensi - Sistem Kehadiran Modern'; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #edf4f8;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #1f2937;
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            transition: all 0.25s ease;
            box-shadow: none;
        }
        .navbar-custom.scrolled {
            box-shadow: 0 18px 60px rgba(15, 23, 42, 0.08);
            background: rgba(255, 255, 255, 0.98);
        }

        .navbar-custom .navbar-brand {
            letter-spacing: 0.02em;
        }

        .navbar-custom .navbar-brand .brand-badge {
            width: 44px;
            height: 44px;
            border-radius: 14px;
        }

        .navbar-custom .navbar-brand small {
            display: block;
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.1rem;
        }

        .navbar-custom .nav-link {
            color: #334155;
            font-weight: 500;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: #0f172a;
            transform: translateY(-1px);
        }

        .navbar-custom .btn-primary {
            background: #0b5ed7;
            border-color: #0b5ed7;
            box-shadow: 0 12px 24px rgba(11, 94, 215, 0.16);
        }

        .navbar-custom .form-control {
            border: none;
            box-shadow: none;
            min-width: 240px;
            font-size: 0.94rem;
            color: #334155;
        }

        .navbar-custom .input-group-text {
            background: #ffffff;
            border: none;
            color: #64748b;
        }

        .footer-modern {
            background: linear-gradient(180deg, #0d4d6d 0%, #0d3f5b 100%);
            color: #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .footer-modern::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(255,255,255,0.12), transparent 28%),
                        radial-gradient(circle at bottom right, rgba(255,255,255,0.08), transparent 25%);
            pointer-events: none;
        }

        .footer-modern .footer-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .footer-modern .footer-heading {
            color: #f8fafc;
            letter-spacing: 0.04em;
        }

        .footer-modern .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .footer-modern .footer-links a:hover {
            color: #ffffff;
            transform: translateX(3px);
        }

        .footer-modern .footer-meta {
            color: #cbd5e1;
        }

        main {
            flex: 1;
        }

        @media (max-width: 991.98px) {
            .navbar-custom .form-control {
                min-width: 180px;
            }
        }

        @media (max-width: 767.98px) {
            .navbar-custom {
                padding-top: 0.9rem;
                padding-bottom: 0.9rem;
            }
            .navbar-custom .navbar-brand small {
                display: none;
            }
            .navbar-custom .input-group {
                min-width: 0;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-custom py-3" id="mainNav">
        <div class="container">
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-flex align-items-center fw-bold fs-4 text-primary me-3" href="<?= base_url(); ?>">
                    <div class="brand-badge bg-primary text-white d-flex align-items-center justify-content-center me-2">
                        <i class="ti ti-books fs-5"></i>
                    </div>
                    <div>
                        E-Absensi
                        <small>Portal Kehadiran Sekolah</small>
                    </div>
                </a>
            </div>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="ti ti-menu-2 fs-2 text-dark"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3"><a class="nav-link fw-medium active" href="<?= base_url(); ?>">Beranda</a></li>
                    <li class="nav-item me-3"><a class="nav-link fw-medium" href="#fitur">Fitur Unggulan</a></li>
                    <li class="nav-item me-3"><a class="nav-link fw-medium" href="#tentang">Tentang</a></li>
                    <li class="nav-item me-3"><a class="nav-link fw-medium" href="#kontak">Kontak</a></li>
                </ul>
                <form class="d-none d-lg-flex align-items-center ms-lg-4" role="search">
                    <div class="input-group shadow-sm rounded-pill overflow-hidden border border-1 border-secondary">
                        <span class="input-group-text"><i class="ti ti-search"></i></span>
                        <input type="search" class="form-control" placeholder="Cari informasi..." aria-label="Search" />
                    </div>
                </form>
                <a href="<?= base_url('auth'); ?>" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm fw-semibold ms-lg-4 mt-3 mt-lg-0 d-flex align-items-center">
                    <i class="ti ti-login me-2"></i> Masuk Portal
                </a>
            </div>
        </div>
    </nav>

    <main>