<?php
session_start();
require_once('connexion.php');

if (!isset($_SESSION['profil_id'])) {
    http_response_code(401);
    exit();
}

$sql = "SELECT message.id, message.message, message.datehour,
               profil.pseudo, profil.photoDeProfil
        FROM message
        INNER JOIN profil ON message.profil_id = profil.id
        ORDER BY message.datehour ASC, message.id ASC";

$stmt = $db->query($sql);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json; charset=utf-8');

echo json_encode($messages);