<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Absensi Sekolah - <?= date('dYmdHis'); ?></title>
    <style>
        /* Reset & Base Styling untuk Cetak Kertas Pemutus */
        body { 
            font-family: 'Helvetica Neue', 'Arial', sans-serif; 
            color: #222; 
            padding: 10px; 
            line-height: 1.5; 
            background: #fff;
        }
        
        /* Perbaikan Kop Surat Kedinasan */
        .kop-surat { 
            text-align: center; 
            border-bottom: 3px double #000; 
            padding-bottom: 12px; 
            margin-bottom: 25px; /* Perbaikan dari mb-20px */
        }
        .kop-surat h2 { 
            margin: 0; 
            text-transform: uppercase; /* Perbaikan dari text-uppercase */
            letter-spacing: 1.5px; 
            font-size: 22px;
            font-weight: bold;
        }
        .kop-surat p { 
            margin: 6px 0 0 0; 
            font-size: 13px; 
            color: #555; 
            font-style: italic;
        }
        
        /* Judul Dokumen */
        .title-laporan { 
            text-align: center; 
            margin-top: 15px; 
            margin-bottom: 25px; 
            font-size: 16px; 
            font-weight: bold; 
            line-height: 1.6;
            text-transform: uppercase;
        }
        .title-laporan span {
            display: inline-block;
            margin-top: 4px;
        }

        /* Perbaikan Struktur Tabel Data Standar ISO Print */
        .table-data { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
        }
        .table-data th, .table-data td { 
            border: 1px solid #444; 
            padding: 8px 12px; 
            font-size: 13px; 
        }
        .table-data th { 
            background-color: #f5f5f5; /* Perbaikan dari bg-color */
            font-weight: bold; 
            text-transform: uppercase; 
            text-align: left;
            font-size: 12px;
            color: #000;
        }
        .table-data tr:nth-child(even) {
            background-color: #fafafa; /* Baris belang halus agar mudah dibaca */
        }
        
        /* Pewarnaan Teks Status Format Laporan Formal (Tanpa Background Blok) */
        .status-text { 
            font-weight: bold; 
        }
        .status-hadir {
            color: #1e7e34; /* Hijau Tua Formal */
        }
        .status-terlambat {
            color: #bd2130; /* Merah Tua Formal */
        }

        /* Pengaturan Media Cetak */
        @media print {
            @page { 
                margin: 1.5cm; 
                size: portrait;
            }
            body { 
                padding: 0; 
            }
            .btn-print-action { 
                display: none; 
            }
            /* Memaksa browser mencetak warna latar belakang tabel */
            .table-data th {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>SISTEM ABSENSI MODERN QR CODE</h2>
        <p>Laporan Kehadiran Murid Real-time Berbasis Token Terenkripsi</p>
    </div>

    <div class="title-laporan">
        LAPORAN REKAPITULASI KEHADIRAN SISWA
        <?php if (!empty($tgl_mulai)) : ?>
            <br><span style="font-size: 13px; font-weight: normal;">Periode: <strong><?= date('d/m/Y', strtotime($tgl_mulai)) ?></strong> s/d <strong><?= date('d/m/Y', strtotime($tgl_selesai)) ?></strong></span>
        <?php endif; ?>
        <?php if (!empty($kelas_pilih)) : ?>
            <br><span style="font-size: 13px; font-weight: normal;">Kelas: <strong><?= $kelas_pilih ?></strong></span>
        <?php endif; ?>
    </div>

    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 15%;">NIS</th>
                <th>Nama Siswa</th>
                <th style="width: 12%;">Kelas</th>
                <th style="width: 15%;">Jam Masuk</th>
                <th style="width: 13%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($absensi)) : ?>
                <?php $no = 1; foreach ($absensi as $a) : ?>
                    <?php 
                        // Cek klasifikasi status untuk menentukan warna teks formal
                        $class_status = ($a['status'] == 'hadir') ? 'status-hadir' : 'status-terlambat';
                    ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++; ?></td>
                        <td><?= date('d-m-Y', strtotime($a['tanggal'])); ?></td>
                        <td><?= $a['nis']; ?></td>
                        <td><strong><?= $a['nama_siswa']; ?></strong></td>
                        <td><?= $a['kelas']; ?></td>
                        <td><?= date('H:i', strtotime($a['jam_masuk'])); ?> WIB</td>
                        <td>
                            <span class="status-text <?= $class_status; ?>">
                                <?= ucfirst($a['status']); ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #666; font-style: italic;">Tidak ada data rekapitulasi kehadiran pada periode ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Memberikan sedikit jeda render grafik/tabel sebelum dialog print browser muncul
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>