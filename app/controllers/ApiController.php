<?php
class ApiController {
    public function prijave() {
        session_start();

        if (!isset($_SESSION['korisnik']['uloga']) || $_SESSION['korisnik']['uloga'] !== 'admin') {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        require_once __DIR__ . '/../models/PrijavaModel.php';
        $model = new PrijavaModel();
        $prijave = $model->dohvatiSvePrijave();

        header('Content-Type: application/json');
        echo json_encode($prijave);
    }

    public function promeniStatus() {
        session_start();
        header('Content-Type: application/json');

        if (!isset($_SESSION['korisnik']) || $_SESSION['korisnik']['uloga'] !== 'admin') {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        if (!isset($_POST['id']) || !isset($_POST['status'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing parameters']);
            return;
        }

        $id = $_POST['id'];
        $status = $_POST['status'];

        require_once __DIR__ . '/../core/Database.php';
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("UPDATE prijave_vk SET status = ? WHERE id = ?");
        if ($stmt->execute([$status, $id])) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
    }
}
?>