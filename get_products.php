<?php
// api/get_products.php
require_once 'db.php';

// Si se pide desde la tienda (index.html), solo mostrar productos activos y con stock > 0
$sql = "SELECT * FROM productos";
if (isset($_GET['context']) && $_GET['context'] == 'store') {
    $sql .= " WHERE status = 'activo' AND stock > 0";
}
$sql .= " ORDER BY category, id DESC";

$result = $conn->query($sql);
$products = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // El action-type depende de la moneda para el ejemplo
        $row['action_type'] = ($row['currency'] == 'USD') ? 'paypal' : 'whatsapp';
        $products[] = $row;
    }
}

echo json_encode($products);
$conn->close();
?>