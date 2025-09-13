<?php
include('db.php');
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) { echo json_encode([]); exit; }
$uid = intval($_SESSION['user_id']);
$res = $conn->query("SELECT * FROM orders WHERE user_id={$uid} ORDER BY created_at DESC");
$orders = [];
while($o = $res->fetch_assoc()) {
    $o['items'] = [];
    $ri = $conn->query("SELECT oi.quantity, p.name FROM order_items oi JOIN products p ON oi.product_id=p.id WHERE oi.order_id={$o['id']}") ;
    while($it = $ri->fetch_assoc()) $o['items'][] = $it;
    $orders[] = $o;
}
echo json_encode($orders);
?>