<?php
session_start();

// Jika sudah login, redirect ke index
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit;
}

// Import file database
require_once 'db.class.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Koneksi ke DB
    $database = new Database();
    $conn = $database->getConnection();

    try {
        // Ambil data user dari tabel 'users'
        $sql  = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verifikasi password
            // Kita bandingkan input password dengan hash di database
            if (password_verify($password, $user['password'])) {
                // Berhasil login
                $_SESSION['logged_in'] = true;
                $_SESSION['username']  = $user['username'];
                header("Location: index.php");
                exit;
            } else {
                // Password salah
                $error = "Username atau password salah!";
            }
        } else {
            // user tidak ditemukan
            $error = "Username atau password salah!";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Aurora - Login</title>
    <!-- Link ke CSS yang sama -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
      body {
        background-color: #f8f9fa;
        font-family: 'Roboto', sans-serif;
        margin: 0; 
        padding: 0;
      }
      .login-container {
        max-width: 400px;
        margin: 80px auto;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      }
      .login-container h2 {
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
      .btn-login {
        width: 100%;
        background-color: #FFB6C1;
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
      }
      .btn-login:hover {
        background-color: #FFE4E1;
        color: #333;
      }
      .error {
        color: red;
        margin-bottom: 15px;
        text-align: center;
      }
      p.register-link {
        margin-top: 10px;
        text-align: center;
      }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login Klinik Aurora</h2>
    <?php if(!empty($error)): ?>
      <div class="error"><?= $error ?></div>
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
      <button type="submit" class="btn-login">Login</button>
    </form>
    <p class="register-link">
      Belum punya akun? <a href="register.php">Daftar di sini</a>.
    </p>
</div>

</body>
</html>
