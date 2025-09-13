<?php

require_once "src/php/db.php"; // ✅ use your existing DB connection

$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $success = "✅ Thank you for contacting us, we will get back to you soon!";
    } else {
        $success = "❌ Error: " . $conn->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - Village E-Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include("home.php"); // reuse navbar ?>
  <div class="container my-5">
    <h2 class="text-center mb-4">📞 Contact Us</h2>
    <?php if (!empty($success)): ?>
      <div class="alert alert-info"><?php echo $success; ?></div>
    <?php endif; ?>
    <form method="POST" class="p-4 border rounded bg-light">
      <div class="mb-3">
        <label class="form-label">Your Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Your Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Message</label>
        <textarea name="message" class="form-control" rows="4" required></textarea>
      </div>
      <button type="submit" class="btn btn-success">Send Message</button>
    </form>
  </div>
</body>
</html>