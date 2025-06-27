<?php
// api/delete_product.php
require_once 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'ID de producto no proporcionado.']);
    die();
}

$stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Producto eliminado correctamente.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el producto: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>