<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Aurora</title>
    <!-- Link ke Google Fonts -->
    <link href= "https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Pastikan file styles.css Anda sudah benar path-nya -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<style>
/* Logo */
.logo {
    max-width: none; /* Izinkan logo memiliki ukuran lebih besar */
    margin-left: 80px; /* Tambahkan jarak dari kiri */
    display: flex;
    align-items: center;
}

.logo img {
    height: 130px; /* Tinggi logo lebih besar */
    width: auto; /* Pastikan proporsi logo tetap */
    display: block;
}


        @media (max-width: 768px) {
            .logo img {
                height: 60px; /* Kecilkan logo di layar lebih kecil */
            }
        }
    </style>

<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">
                <img src="images/logo.png" alt="Logo Website">
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#tentang">Tentang</a></li>
                    <li><a href="#layanan">Layanan</a></li>
                    <li><a href="#tanggapan">Tanggapan</a></li>
                    <!-- Menu Logout di kanan -->
                    <li><a href="logout.php" style="margin-left: 20px;">Logout</a></li>
                </ul>
            </nav>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="container hero-container">
            <div class="hero-text">
                <h1>Because Your Beauty Deserves to Be Ineffable</h1>
                <h2>One Stop Beauty</h2>
                <p>Instant Glowing Kulit Bebas Jerawat</p>
                <a href="reservasi.php" class="btn">RESERVASI DISINI!</a>
            </div>
            <div class="hero-image">
                <img src="images/orang.png" alt="Hero Image">
            </div>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section class="about" id="tentang">
        <div class="container about-container">
            <h2>Tentang Kami</h2>
            <div class="about-content">
                <img src="images/ruangan.jpg" alt="Tentang Kami" class="about-image">
                <p>
                    Aurora Klinik merupakan pionir klinik estetika terbaik di Indonesia yang berfokus pada contouring
                    wajah. Tidak hanya perawatan contouring, Aurora Klinik juga menawarkan perawatan mulai dari rambut,
                    kulit, dan wajah.
                </p>
            </div>
        </div>
    </section>

    <!-- Layanan -->
    <section class="services" id="layanan">
        <div class="container services-container">
            <h2>Layanan Kami</h2>
            <div class="services-grid">
                <div class="service-item">
                    <img src="images/facial.jpg" alt="Layanan 1" class="service-image">
                    <h3>Aurora Facial</h3>
                    <p>
                        Aurora Facial adalah suatu metode perawatan kulit wajah yang membersihkan pori-pori kulit wajah
                        secara menyeluruh. Dengan membersihkan kulit, facial dapat membuat kulit wajah bebas dari
                        kotoran sehingga dapat mengurangi adanya jerawat.
                    </p>
                </div>
                <div class="service-item">
                    <img src="images/dermaloler.jpg" alt="Layanan 2" class="service-image">
                    <h3>Dermaroller</h3>
                    <p>
                        Dermaroller adalah suatu alat perawatan yang memiliki roller kecil dan ampuh untuk atasi bekas
                        jerawat. Roller pada alat tersebut terdapat jarum-jarum yang sangat kecil. Penerapan alat ini
                        bisa dilakukan pada permukaan wajah yang diinginkan agar kembali mulus.
                    </p>
                </div>
                <div class="service-item">
                    <img src="images/face_massage.jpg" alt="Layanan 3" class="service-image">
                    <h3>Face Massage</h3>
                    <p>
                        Face massage adalah cara untuk mengurangi garis-garis halus, pori-pori, kerutan & mengencangkan
                        kulit wajah. Gerakan pijat wajah merangsang drainase limfatik, yang meningkatkan sirkulasi darah
                        dan mengeluarkan racun, serta mengurangi pembengkakan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tanggapan -->
    <section class="contact" id="tanggapan">
        <div class="container contact-container">
            <!-- Kotak Kosong untuk Notifikasi -->
            <div class="notification-box">
                <!-- Notifikasi -->
                <?php if (isset($_GET['msg'])): ?>
                    <?php if ($_GET['msg'] === 'tanggapan_sukses'): ?>
                        <div class="notification notification-success">
                            Tanggapan berhasil dikirim!
                            <span class="close-btn">&times;</span>
                        </div>
                    <?php elseif ($_GET['msg'] === 'tanggapan_gagal'): ?>
                        <div class="notification notification-error">
                            Tanggapan gagal dikirim!
                            <span class="close-btn">&times;</span>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <form action="tanggapan.php" method="POST">
                <!-- Field Nama -->
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <!-- Field Email -->
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <!-- Field Pesan -->
                <div class="form-group">
                    <label for="pesan">Pesan:</label>
                    <textarea id="pesan" name="pesan" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn">Kirim</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container footer-container">
            <p>&copy; 2020 PT. Beauty Gemilang Indonesia</p>
        </div>
    </footer>

    <!-- JavaScript untuk Menghilangkan Notifikasi secara Otomatis dan Hapus Parameter msg -->
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

            // Hapus parameter msg dari URL
            const url = new URL(window.location.href);
            if (url.searchParams.has('msg')) {
                url.searchParams.delete('msg'); // Hapus parameter msg
                window.history.replaceState(null, '', url.toString()); // Update URL tanpa refresh
            }
        });
    </script>
</body>
</html>
