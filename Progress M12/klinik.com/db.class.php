<?php
class Database {
    private $host = 'localhost';
    private $db   = 'klinik_aurora';
    private $user = 'root';
    private $pass = 'Dfaaoam17022005.';
    public $conn;

    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->db", 
                $this->user, 
                $this->pass
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Koneksi gagal: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
