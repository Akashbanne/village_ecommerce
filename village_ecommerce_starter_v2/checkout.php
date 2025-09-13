<?php
session_start();
include('src/php/db.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;
    $total = 0;
    if (empty($_SESSION['cart'])) { die('Cart empty'); }
    foreach ($_SESSION['cart'] as $id => $qty) {
        $r = $conn->query("SELECT price FROM products WHERE id=".intval($id));
        $row = $r->fetch_assoc();
        $total += $row['price'] * $qty;
    }
    $user_id_sql = $user_id ? $user_id : 'NULL';
    $conn->query("INSERT INTO orders (user_id, user_name, user_phone, user_address, total_amount, status, created_at) VALUES ({$user_id_sql},'{$name}','{$phone}','{$address}',{$total},'placed',NOW())");
    $order_id = $conn->insert_id;
    foreach ($_SESSION['cart'] as $id => $qty) {
        $conn->query("INSERT INTO order_items (order_id, product_id, quantity) VALUES ({$order_id},".intval($id).",".intval($qty).")");
    }
    $_SESSION['cart'] = [];
    header("Location: success.php?order_id={$order_id}");
    exit;
}
?>
<?php
include('src/php/db.php');
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Order Success</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <div class="alert alert-success">
    <h4>Thank you!</h4>
    <p>Your order #<?php echo $order_id; ?> has been placed. We'll deliver soon.</p>
  </div>
  <a href="products.php" class="btn btn-primary">Continue Shopping</a>
</body>
</html>