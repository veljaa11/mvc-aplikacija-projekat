<?php
require_once __DIR__ . '/../../core/Database.php';

class PrijavaModel {
    public function dohvatiSvePrijave() {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT * FROM prijave_vk ORDER BY datum_prijave DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
?>
