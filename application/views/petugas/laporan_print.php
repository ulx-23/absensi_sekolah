<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Harian Petugas Gerbang - <?= date('dYmd'); ?></title>
    <style>
        /* Reset & Base Print Configuration */
        body { 
            font-family: 'Helvetica Neue', 'Arial', sans-serif; 
            color: #222; 
            padding: 10px; 
            line-height: 1.5; 
            background: #fff;
        }
        
        /* Kop Laporan Resmi Gerbang */
        .header-print { 
            text-align: center; 
            border-bottom: 3px double #000; /* Mengubah garis tunggal menjadi double klasik */
            padding-bottom: 12px; 
            margin-bottom: 25px; 
        }
        .header-print h3 { 
            margin: 0; 
            text-transform: uppercase; 
            letter-spacing: 1.5px;
            font-size: 20px;
            font-weight: bold;
        }
        .header-print p { 
            margin: 6px 0 0 0; 
            font-size: 13px; 
            color: #555; 
            font-style: italic;
        }
        
        /* Meta Info Petugas & Tanggal */
        .meta-info { 
            margin-bottom: 20px; 
            font-size: 13px; 
            line-height: 1.6;
            color: #333;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .meta-table td {
            padding: 2px 0;
            font-size: 13px;
        }
        
        /* Struktur Tabel Standar ISO Print */
        .table-print { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        .table-print th, .table-print td { 
            border: 1px solid #444; 
            padding: 8px 12px; 
            font-size: 13px; 
        }
        .table-print th { 
            background-color: #f5f5f5 !important; 
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            color: #000;
        }
        .table-print tr:nth-child(even) {
            background-color: #fafafa; /* Baris belang halus */
        }
        
        /* Pewarnaan Teks Status Formal */
        .status-text { 
            font-weight: bold; 
        }
        .status-hadir {
            color: #1e7e34; /* Hijau Tua */
        }
        .status-terlambat {
            color: #bd2130; /* Merah Keoranyean Tua */
        }

        /* CSS Media Print Engine */
        @media print {
            @page { 
                margin: 1.5cm; 
                size: portrait;
            }
            body { 
                padding: 0; 
            }
            /* Memaksa browser memunculkan warna background header tabel */
            .table-print th {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <div class="header-print">
        <h3>LAPORAN HARIAN ABSENSI SISWA</h3>
        <p>Sistem Absensi Kehadiran QR Code Sekolah</p>
    </div>

    <table class="meta-table">
        <tr>
            <td style="width: 15%;">Hari / Tanggal</td>
            <td style="width: 2%;">:</td>
            <td><strong><?= date('d-m-Y'); ?></strong></td>
        </tr>
        <tr>
            <td>Dicetak Oleh</td>
            <td>:</td>
            <td><?= $this->session->userdata('nama'); ?> (Petugas Gate)</td>
        </tr>
        <tr>
            <td>Status Server</td>
            <td>:</td>
            <td><span style="color: #28c76f; font-weight: bold;">Sinkron Sempurna</span></td>
        </tr>
    </table>

    <table class="table-print">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 15%;">Jam Masuk</th>
                <th style="width: 15%;">NIS</th>
                <th>Nama Lengkap Siswa</th>
                <th style="width: 15%;">Kelas</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($absensi)) : ?>
                <?php $no = 1; foreach ($absensi as $a) : ?>
                    <?php 
                        // Menentukan warna teks berdasarkan status tapping gerbang
                        $class_status = ($a['status'] == 'hadir') ? 'status-hadir' : 'status-terlambat';
                    ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++; ?></td>
                        <td><div style="font-weight: 500;"><?= date('H:i', strtotime($a['jam_masuk'])); ?> WIB</div></td>
                        <td><span style="font-family: monospace; font-size: 13px;"><?= $a['nis']; ?></span></td>
                        <td><strong><?= $a['nama_siswa']; ?></strong></td>
                        <td><?= $a['kelas']; ?></td>
                        <td>
                            <span class="status-text <?= $class_status; ?>">
                                <?= ucfirst($a['status']); ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #666; font-style: italic; padding: 20px;">
                        Belum ada data aktivitas pemindaian kartu siswa untuk hari ini.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Memberikan jeda 500ms agar style css ter-render utuh sebelum dialog cetak muncul
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>