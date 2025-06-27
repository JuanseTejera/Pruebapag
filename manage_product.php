<?php
// api/manage_product.php
require_once 'db.php';

// Obtener los datos JSON enviados desde el formulario de admin
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'] ?? null;
$name = $data['name'];
$category = $data['category'];
$status = $data['status'];
$price = $data['price'];
$currency = $data['currency'];
$stock = $data['stock'];
$img = $data['img'];
$details = $data['details'];
// Por simplicidad, asumimos que la imagen principal es la única. Podrías expandir esto.
$images_json = json_encode([$img]); 

if ($id) { // Si hay ID, es una ACTUALIZACIÓN
    $stmt = $conn->prepare("UPDATE productos SET name=?, category=?, price=?, currency=?, stock=?, status=?, img=?, details=?, images_json=? WHERE id=?");
    $stmt->bind_param("ssdisssssi", $name, $category, $price, $currency, $stock, $status, $img, $details, $images_json, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Producto actualizado correctamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar: ' . $stmt->error]);
    }
    $stmt->close();
} else { // Si no hay ID, es una CREACIÓN
    $stmt = $conn->prepare("INSERT INTO productos (name, category, price, currency, stock, status, img, details, images_json) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdisssss", $name, $category, $price, $currency, $stock, $status, $img, $details, $images_json);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Producto añadido correctamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al añadir: ' . $stmt->error]);
    }
    $stmt->close();
}

$conn->close();
?>