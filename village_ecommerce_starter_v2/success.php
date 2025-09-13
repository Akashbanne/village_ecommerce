<?php include('src/php/db.php'); $order_id = isset($_GET['order_id'])?intval($_GET['order_id']):0; ?>
<!doctype html><html><head><meta charset='utf-8'><title>Success</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'></head>
<body class='container py-4'><div class='alert alert-success'><h4>Thank you!</h4><p>Your order #<?php echo $order_id;?> has been placed.</p></div><a href='products.php' class='btn btn-primary'>Continue Shopping</a></body></html>