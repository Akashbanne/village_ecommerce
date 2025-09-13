<?php
session_start();

// If user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Village E-Commerce - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php">Village E-Commerce</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">New Registration</a>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Log in </a>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Admin </a>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
  <div class="text-center">
    <h1 class="mb-4">Welcome to Village E-Commerce</h1>
    <p class="lead">Your one-stop solution for online shopping in rural areas.</p>
    <hr>
    <h3>What would you like to do today?</h3>
    <div class="d-flex justify-content-center gap-3 mt-4">
      <a href="products.php" class="btn btn-primary btn-lg">Browse Products</a>
      <a href="cart.php" class="btn btn-success btn-lg">View Cart</a>
      <a href="orders.php" class="btn btn-warning btn-lg">My Orders</a>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>