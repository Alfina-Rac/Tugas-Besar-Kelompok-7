<?php
require_once 'db.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = $_POST['nama'];
    $email = $_POST['email'];
    $pesan = $_POST['pesan'];

    // Inisialisasi Database
    $database = new Database();
    $conn = $database->getConnection();

    $sql  = "INSERT INTO tanggapan (nama, email, pesan) VALUES (:nama, :email, :pesan)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':nama',  $nama);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pesan', $pesan);

    if ($stmt->execute()) {
        // Jika sukses, redirect ke index dengan pesan dan fragment identifier
        header("Location: index.php?msg=tanggapan_sukses#tanggapan");
        exit;
    } else {
        // Jika gagal, redirect dengan pesan error dan fragment identifier
        header("Location: index.php?msg=tanggapan_gagal#tanggapan");
        exit;
    }
} else {
    echo "Metode tidak diperbolehkan!";
}
?>
