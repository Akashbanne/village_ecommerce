<?php
include("db.php");
session_start();
$sql = "SELECT id, name, price, image, stock, category, description FROM products";
$result = $conn->query($sql);
$products = [];
while($row = $result->fetch_assoc()) {
    $products[] = $row;
}
header('Content-Type: application/json');
echo json_encode($products);
?>