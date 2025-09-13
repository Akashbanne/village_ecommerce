<?php
include('src/php/db.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $_POST['password'];
    $res = $conn->query("SELECT * FROM users WHERE email='{$email}'");
    if ($res && $res->num_rows) {
        $u = $res->fetch_assoc();
        if (password_verify($pass, $u['password'])) {
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['user_name'] = $u['name'];
            header('Location: products.php'); exit;
        } else { $err='Invalid credentials'; }
    } else { $err='No user found'; }
}
?>
<!doctype html><html><head><meta charset='utf-8'><title>Login</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'></head>
<body class='container py-4'>
<h2>Login</h2>
<?php if(isset($err)) echo "<div class='alert alert-danger'>{$err}</div>"; ?>
<form method='post' class='row g-3'>
<div class='col-md-6'><input name='email' type='email' class='form-control' placeholder='Email' required></div>
<div class='col-md-6'><input name='password' type='password' class='form-control' placeholder='Password' required></div>
<div class='col-12'><button class='btn btn-primary'>Login</button></div>
</form>
<p>No account? <a href='register.php'>Register</a></p>
</body></html>