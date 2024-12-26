-- 1. Buat database 'klinik_aurora'
CREATE DATABASE IF NOT EXISTS klinik_aurora;
USE klinik_aurora;

-- 2. Buat tabel 'users' untuk menyimpan data user yang register
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 3. Buat tabel 'reservasi' untuk menyimpan data form reservasi
CREATE TABLE IF NOT EXISTS reservasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    no_telepon VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 4. Buat tabel 'tanggapan' untuk menyimpan data feedback / komentar
CREATE TABLE IF NOT EXISTS tanggapan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    pesan TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- (Opsional) Lihat semua tabel
SHOW TABLES;

-- (Opsional) Cek struktur masing-masing tabel
DESC users;
SELECT * FROM users;
DESC reservasi;
SELECT * FROM reservasi;
DESC tanggapan;
DELETE FROM tanggapan;
SELECT * FROM tanggapan;

SET SQL_SAFE_UPDATES = 0;
SET SQL_SAFE_UPDATES = 1;
