<?php
session_start();

// Jika user sudah login, redirect ke index
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit;
}

// Import file class database
require_once 'db.class.php';

// Inisialisasi pesan error/sukses
$error = "";
$success = "";

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm']);

    // Validasi sederhana
    if ($username === "" || $password === "" || $confirm === "") {
        $error = "Semua field wajib diisi.";
    } elseif ($password !== $confirm) {
        $error = "Password dan konfirmasi password tidak sama!";
    } else {
        // Koneksi ke DB
        $database = new Database();
        $conn = $database->getConnection();

        // 1. Cek apakah username sudah ada
        try {
            $sql_check = "SELECT COUNT(*) FROM users WHERE username = :username";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bindParam(':username', $username);
            $stmt_check->execute();
            $count = $stmt_check->fetchColumn();

            if ($count > 0) {
                // Username sudah dipakai
                $error = "Username sudah terdaftar, silakan gunakan username lain.";
            } else {
                // 2. Insert user baru dengan password hash
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql_insert = "INSERT INTO users (username, password) VALUES (:username, :password)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bindParam(':username', $username);
                $stmt_insert->bindParam(':password', $hashed_password);

                if ($stmt_insert->execute()) {
                    $success = "Pendaftaran berhasil! Silakan <a href='login.php'>login di sini</a>.";
                } else {
                    $error = "Terjadi kesalahan saat menyimpan data user.";
                }
            }
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Aurora - Register</title>
    <!-- Link ke CSS yang sama agar nuansa selaras -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">

    <style>
      body {
        background-color: #f8f9fa;
        font-family: 'Roboto', sans-serif;
        margin: 0; 
        padding: 0;
      }
      .register-container {
        max-width: 400px;
        margin: 60px auto;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      }
      .register-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #FFB6C1;
      }
      .form-group {
        margin-bottom: 15px;
      }
      label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
      }
      input[type="text"],
      input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
      }
      .btn-register {
        width: 100%;
        background-color: #FFB6C1;
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
      }
      .btn-register:hover {
        background-color: #FFE4E1;
        color: #333;
      }
      .error {
        color: red;
        margin-bottom: 15px;
        text-align: center;
      }
      .success {
        color: green;
        margin-bottom: 15px;
        text-align: center;
      }
    </style>
</head>
<body>
<div class="register-container">
    <h2>Register Klinik Aurora</h2>
    <?php if(!empty($error)): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <?php if(!empty($success)): ?>
      <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="username">Username:</label>
        <input 
          type="text" 
          name="username" 
          id="username" 
          placeholder="Masukkan username" 
          required
        >
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input 
          type="password" 
          name="password" 
          id="password" 
          placeholder="Masukkan password" 
          required
        >
      </div>
      <div class="form-group">
        <label for="confirm">Konfirmasi Password:</label>
        <input 
          type="password" 
          name="confirm" 
          id="confirm" 
          placeholder="Ulangi password" 
          required
        >
      </div>
      <button type="submit" class="btn-register">Daftar</button>
    </form>
    <p style="margin-top: 10px; text-align: center;">
      Sudah punya akun? <a href="login.php">Login di sini</a>.
    </p>
</div>
</body>
</html>
