<?php
// reservasi.php

// Mulai sesi jika diperlukan (untuk notifikasi atau fitur lainnya)
session_start();

// Sertakan kelas Database
require_once 'db.class.php';

// Inisialisasi objek Database
$db = new Database();
$conn = $db->getConnection();

// Inisialisasi variabel pesan
$msg = '';

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil dan sanitasi input
    $nama    = trim($_POST['nama']);
    $telepon = trim($_POST['telepon']);
    $email   = trim($_POST['email']);
    $alamat  = trim($_POST['alamat']);

    // Validasi sederhana (pastikan semua field terisi)
    if (empty($nama) || empty($telepon) || empty($email) || empty($alamat)) {
        // Redirect dengan pesan gagal
        header("Location: reservasi.php?msg=reservasi_gagal");
        exit();
    }

    try {
        // Siapkan statement SQL dengan prepared statements
        $stmt = $conn->prepare("INSERT INTO reservasi (nama, no_telepon, email, alamat) VALUES (:nama, :telepon, :email, :alamat)");

        // Bind parameter dan eksekusi
        $stmt->execute([
            ':nama'    => $nama,
            ':telepon' => $telepon,
            ':email'   => $email,
            ':alamat'  => $alamat,
        ]);

        // Redirect dengan pesan sukses
        header("Location: reservasi.php?msg=reservasi_sukses");
        exit();
    } catch (PDOException $e) {
        // Log error jika diperlukan
        error_log($e->getMessage());

        // Redirect dengan pesan gagal
        header("Location: reservasi.php?msg=reservasi_gagal");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Form Reservasi - Klinik Aurora</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link ke CSS yang sama agar konsisten tampilan -->
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* Agar tinggi halaman 100% untuk flexbox */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        /* Jadikan body sebagai flex container */
        body {
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
            /* warna latar */
            font-family: 'Roboto', sans-serif;
        }

        /* Wrapper untuk konten utama (agar footer tetap di bawah) */
        main {
            flex: 1;
        }

        /* Header styling */
        header {
            background-color: #FFB6C1;
            /* Pink */
            padding: 10px 0;
        }

        .header-container {
            display: flex;
            align-items: center;
            /* Ubah "space-between" menjadi "center" */
            justify-content: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .header-container .logo img {
            height: 50px;
            width: auto;
        }

        /* Form Container */
        .form-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            position: relative; /* Untuk notifikasi absolute positioning */
        }

        .title {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #FFB6C1;
            font-weight: bold;
        }

        .btn-pink {
            background-color: #FFB6C1;
            border-color: #FFB6C1;
        }

        .btn-pink:hover {
            background-color: #FFE4E1;
            border-color: #FFE4E1;
        }

        /* Footer selalu di bawah */
        footer {
            background-color: #FFB6C1;
            text-align: center;
            color: #fff;
            padding: 15px 0;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Notifikasi */
        .notification {
            position: absolute;
            top: 600px;
            right: 150px;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            z-index: 999;
            width: 300px;
            max-width: 400px;
            text-align: center;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        /* Notifikasi Sukses */
        .notification-success {
            background-color: #C8E6C9;
            /* Hijau muda */
            color: #256029;
        }

        /* Notifikasi Gagal */
        .notification-error {
            background-color: #F8D7DA;
            /* Merah muda */
            color: #721C24;
        }

        /* Animasi Masuk */
        .notification-show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Animasi Keluar */
        .notification-hide {
            opacity: 0;
            transform: translateY(-20px);
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .notification {
                width: 90%;
                left: 50%;
                right: auto;
                transform: translateX(-50%);
            }
        }

        /* Styling Form */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid #ced4da;
        }

        .btn {
            padding: 0.75rem;
            font-size: 1rem;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- WRAPPER KONTEN UTAMA -->
    <main>
        <div class="form-container">
            <h2 class="title">Form Reservasi</h2>

            <!-- Notifikasi -->
            <div class="notification-box">
                <?php
                if (isset($_GET['msg'])) {
                    switch ($_GET['msg']) {
                        case 'reservasi_sukses':
                            echo '<div class="notification notification-success">
                                  Reservasi berhasil dikirim!
                                  <span class="close-btn" style="cursor:pointer; float:right;">&times;</span>
                                </div>';
                            break;
                        case 'reservasi_gagal':
                            echo '<div class="notification notification-error">
                                  Reservasi gagal dikirim! Silakan coba lagi.
                                  <span class="close-btn" style="cursor:pointer; float:right;">&times;</span>
                                </div>';
                            break;
                        default:
                            // Tidak melakukan apa-apa
                            break;
                    }
                }
                ?>
            </div>

            <form action="reservasi.php" method="POST">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Anda" required />
                </div>
                <div class="form-group">
                    <label for="telepon">No Telepon</label>
                    <input type="tel" id="telepon" name="telepon" placeholder="Masukkan No Telepon Anda" required />
                </div>
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan Email Anda" required />
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat Anda" required></textarea>
                </div>
                <button type="submit" class="btn btn-pink w-100">
                    Kirim
                </button>
            </form>
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="footer-container">
            <p>&copy; <?php echo date("Y"); ?> PT. Beauty Gemilang Indonesia</p>
        </div>
    </footer>

    <!-- JavaScript untuk Menghilangkan Notifikasi secara Otomatis dengan Animasi dan Tombol Tutup -->
    <script>
        window.addEventListener('load', () => {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                // Tambahkan kelas show untuk animasi masuk
                setTimeout(() => {
                    notification.classList.add('notification-show');
                }, 100); // Delay kecil untuk memastikan transition berjalan

                // Atur waktu sebelum notifikasi mulai menghilang
                setTimeout(() => {
                    notification.classList.add('notification-hide');
                    // Setelah animasi keluar selesai, sembunyikan elemen
                    notification.addEventListener('transitionend', () => {
                        notification.style.display = 'none';
                    });
                }, 5000); // 5 detik

                // Tambahkan event listener untuk tombol tutup
                const closeBtn = notification.querySelector('.close-btn');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        notification.classList.add('notification-hide');
                        notification.addEventListener('transitionend', () => {
                            notification.style.display = 'none';
                        });
                    });
                }
            });
        });
    </script>

</body>

</html>

