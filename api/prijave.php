<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['korisnik']['uloga']) || $_SESSION['korisnik']['uloga'] !== 'admin') {
    echo json_encode(['error' => 'Unauthorized']);
    http_response_code(401);
    exit;
}

require_once '../config/db.php';

$query = "SELECT * FROM prijave_vk ORDER BY datum DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    http_response_code(500);
    exit;
}

$prijave = [];
while ($row = mysqli_fetch_assoc($result)) {
    $prijave[] = $row;
}

echo json_encode($prijave);
?>