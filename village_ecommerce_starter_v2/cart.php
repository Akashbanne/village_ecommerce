<?php
session_start();
include('src/php/db.php');
if (isset($_GET['add'])) {
    $id = intval($_GET['add']);
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header('Location: cart.php'); exit;
}
function fetch_product($conn, $id) {
    $id = intval($id);
    $res = $conn->query("SELECT * FROM products WHERE id=$id");
    return $res->fetch_assoc();
}
?>
<!doctype html><html><head><meta charset='utf-8'><title>Cart</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'></head>
<body class='container py-4'><h2>Your Cart</h2>
<?php $total=0; if(!empty($_SESSION['cart'])){ echo '<table class="table"><thead><tr><th>Product</th><th>Qty</th><th>Price</th></tr></thead><tbody>'; foreach($_SESSION['cart'] as $id=>$qty){ $p=fetch_product($conn,$id); if(!$p) continue; $subtotal=$p['price']*$qty; $total+=$subtotal; echo '<tr><td>'.htmlspecialchars($p['name']).'</td><td>'.intval($qty).'</td><td>₹'.$subtotal.'</td></tr>'; } echo '</tbody></table>'; echo '<h4>Total: ₹'.$total.'</h4>'; echo "<a href=\"checkout.php\" class=\"btn btn-success\">Proceed to Checkout</a>"; } else{ echo "<div class='alert alert-warning'>Your cart is empty. <a href='products.php'>Shop now</a></div>"; } ?></body></html>