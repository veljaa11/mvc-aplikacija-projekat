<?php
session_start();
header('Content-Type: application/json');

// Omogući CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

// Debug
file_put_contents('debug_api.log', print_r([
    'timestamp' => date('Y-m-d H:i:s'),
    'post_data' => $_POST,
    'session' => $_SESSION
], true), FILE_APPEND);

// Provera AJAX zahteva
if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    http_response_code(403);
    die(json_encode(['error' => 'Samo AJAX zahtevi su dozvoljeni']));
}

// Provera sesije
if (!isset($_SESSION['korisnik']['uloga']) || $_SESSION['korisnik']['uloga'] !== 'admin') {
    http_response_code(403);
    die(json_encode(['error' => 'Nedozvoljen pristup']));
}

// Provera metode
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Samo POST metoda je dozvoljena']));
}

// Validacija
if (empty($_POST['id']) || empty($_POST['status'])) {
    http_response_code(400);
    die(json_encode(['error' => 'Nedostaju parametri']));
}

require_once __DIR__.'/../config/db.php';

try {
    // Dozvoljeni statusi
    $allowed = ['cekanje', 'prihvaceno', 'zavrseno'];
    if (!in_array($_POST['status'], $allowed)) {
        http_response_code(400);
        die(json_encode(['error' => 'Nevazeći status']));
    }

    $stmt = $conn->prepare("UPDATE prijave_vk SET status = ?, datum_izmena = NOW() WHERE id = ?");
    $stmt->bind_param("si", $_POST['status'], $_POST['id']);
    
    if (!$stmt->execute()) {
        throw new Exception("Greška pri izvršavanju upita");
    }

    // Provera da li je redosled ažuriran
    if ($stmt->affected_rows === 0) {
        echo json_encode(['warning' => 'Nema promena (ID možda ne postoji)']);
    } else {
        echo json_encode([
            'success' => true,
            'id' => $_POST['id'],
            'new_status' => $_POST['status']
        ]);
    }
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Greška u bazi',
        'details' => $e->getMessage()
    ]);
    
    file_put_contents('debug_error.log', date('[Y-m-d H:i:s] ') . $e->getMessage() . "\n", FILE_APPEND);
} finally {
    if (isset($stmt)) $stmt->close();
    $conn->close();
}
?>