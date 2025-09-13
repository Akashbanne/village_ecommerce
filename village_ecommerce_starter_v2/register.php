<?php
include('src/php/db.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $q = $conn->query("INSERT INTO users (name, email, password, phone) VALUES ('{$name}','{$email}','{$password}','{$phone}')");
    if ($q) { header('Location: login.php'); exit; } else { echo 'Error: '. $conn->error; }
}
?>
<!doctype html><html><head><meta charset='utf-8'><title>Register</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'></head>
<body class='container py-4'>
<h2>Register</h2>
<form method='post' class='row g-3'>
<div class='col-md-6'><input name='name' class='form-control' placeholder='Full name' required></div>
<div class='col-md-6'><input name='email' type='email' class='form-control' placeholder='Email'></div>
<div class='col-md-6'><input name='phone' class='form-control' placeholder='Phone'></div>
<div class='col-md-6'><input name='password' type='password' class='form-control' placeholder='Password' required></div>
<div class='col-12'><button class='btn btn-primary'>Register</button></div>
</form>
<p>Already have account? <a href='login.php'>Login</a></p>
</body></html>