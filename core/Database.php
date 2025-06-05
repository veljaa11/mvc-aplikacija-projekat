<?php
class Database {
    private $host = "sql200.epizy.com";
    private $dbname = "epiz_31121671_vk";
    private $username = "epiz_31121671";
    private $password = "7XhEahxb5zgcPgN";
    public $conn;

    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Greška u konekciji: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
