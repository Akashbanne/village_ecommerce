<?php
include('../src/php/db.php');
session_start();
// simple admin auth
$ADMIN_PASS = 'admin123'; // change after deploy
if (isset($_POST['admin_login'])) {
    if ($_POST['password'] === $ADMIN_PASS) { $_SESSION['is_admin']=true; }
    else $err='Wrong password';
}
if (isset($_GET['logout'])) { session_unset(); header('Location: index.php'); exit; }
if (!isset($_SESSION['is_admin'])) {
?>
<!doctype html><html><head><meta charset='utf-8'><title>Admin Login</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'></head>
<body class='container py-4'>
<h2>Admin Login</h2>
<?php if(isset($err)) echo "<div class='alert alert-danger'>{$err}</div>"; ?>
<form method='post' class='row g-3'><div class='col-md-4'><input type='password' name='password' class='form-control' placeholder='Password'></div>
<div class='col-12'><button class='btn btn-primary' name='admin_login'>Login</button></div></form></body></html><?php exit; } 

// handle add/edit/delete
if (isset($_POST['add_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category = $conn->real_escape_string($_POST['category']);
    $desc = $conn->real_escape_string($_POST['description']);
    $image = 'placeholder.png';
    if (!empty($_FILES['image']['name'])) {
        $target = __DIR__ . '/../public/images/';
        $fname = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target . $fname);
        $image = $fname;
    }
    $conn->query("INSERT INTO products (name, price, image, stock, category, description) VALUES ('{$name}',{$price},'{$image}',{$stock},'{$category}','{$desc}')");
    header('Location: index.php'); exit;
}
if (isset($_POST['edit_product'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category = $conn->real_escape_string($_POST['category']);
    $desc = $conn->real_escape_string($_POST['description']);
    $image_sql = '';
    if (!empty($_FILES['image']['name'])) {
        $target = __DIR__ . '/../public/images/';
        $fname = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target . $fname);
        $image_sql = ", image='{$fname}'";
    }
    $conn->query("UPDATE products SET name='{$name}', price={$price}, stock={$stock}, category='{$category}', description='{$desc}' {$image_sql} WHERE id={$id}");
    header('Location: index.php'); exit;
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id={$id}");
    header('Location: index.php'); exit;
}
$products = $conn->query('SELECT * FROM products');
?>
<!doctype html><html><head><meta charset='utf-8'><title>Admin - GrameenKart</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'></head><body class='container py-4'>
<h2>Admin Dashboard <a href='?logout=1' class='btn btn-sm btn-outline-secondary'>Logout</a></h2>
  <a href='message.php' class='btn btn-sm btn-success ms-2'>Messages</a>    
<h4>Add Product</h4>
<form method='post' enctype='multipart/form-data' class='row g-3 mb-4'>
<input type='hidden' name='add_product' value='1' />
<div class='col-md-4'><input name='name' class='form-control' placeholder='Product name' required></div>
<div class='col-md-2'><input name='price' class='form-control' placeholder='Price' required></div>
<div class='col-md-2'><input name='stock' class='form-control' placeholder='Stock' required></div>
<div class='col-md-2'><input name='category' class='form-control' placeholder='Category'></div>
<div class='col-12'><input name='description' class='form-control' placeholder='Description'></div>
<div class='col-md-4'><input type='file' name='image' class='form-control'></div>
<div class='col-12'><button class='btn btn-primary'>Add</button></div>
</form>
<h4>Existing Products</h4>
<table class='table'>
<thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead><tbody>
<?php while($p = $products->fetch_assoc()): ?>
<tr>
<td><?php echo $p['id']; ?></td>
<td><?php echo htmlspecialchars($p['name']); ?></td>
<td>₹<?php echo $p['price']; ?></td>
<td><?php echo $p['stock']; ?></td>
<td>
<button class='btn btn-sm btn-info' data-bs-toggle='modal' data-bs-target='#editModal<?php echo $p['id']; ?>'>Edit</button>
<a href='?delete=<?php echo $p['id']; ?>' class='btn btn-sm btn-danger' onclick='return confirm("Delete?")'>Delete</a>
</td>
</tr>
<!-- Edit Modal -->
<div class='modal fade' id='editModal<?php echo $p['id']; ?>' tabindex='-1'>
<div class='modal-dialog'><div class='modal-content'><form method='post' enctype='multipart/form-data'>
<div class='modal-header'><h5 class='modal-title'>Edit</h5><button type='button' class='btn-close' data-bs-dismiss='modal'></button></div>
<div class='modal-body'>
<input type='hidden' name='id' value='<?php echo $p['id']; ?>' />
<div class='mb-2'><input name='name' value='<?php echo htmlspecialchars($p['name']); ?>' class='form-control'></div>
<div class='mb-2'><input name='price' value='<?php echo $p['price']; ?>' class='form-control'></div>
<div class='mb-2'><input name='stock' value='<?php echo $p['stock']; ?>' class='form-control'></div>
<div class='mb-2'><input name='category' value='<?php echo htmlspecialchars($p['category']); ?>' class='form-control'></div>
<div class='mb-2'><input name='description' value='<?php echo htmlspecialchars($p['description']); ?>' class='form-control'></div>
<div class='mb-2'><input type='file' name='image' class='form-control'></div>
</div>
<div class='modal-footer'><button class='btn btn-primary' name='edit_product'>Save</button></div>
</form></div></div></div>
<?php endwhile; ?>
</tbody></table>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body></html>