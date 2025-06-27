<?php
// api/db.php
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username = "root"; // Usuario por defecto en XAMPP
$password = "";     // Contraseña por defecto en XAMPP
$dbname = "tatophones_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Chequear conexión
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    die();
}

// Establecer el charset para evitar problemas con tildes y caracteres especiales
$conn->set_charset("utf8mb4");
?>