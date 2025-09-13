<?php
session_start();
require_once('../src/php/db.php');

// Check if admin is logged in
if (!isset($_SESSION['is_admin'])) {
    header("Location: index.php");
    exit();
}

// Handle CSV export
if (isset($_POST['export_csv'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=messages.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('ID', 'Name', 'Email', 'Message', 'Date'));

    $query = "SELECT id, name, email, message, created_at FROM messages ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit();
}

// Fetch messages
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Messages</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
  <h2 class="mb-4">User Messages</h2>

  <form method="post" class="mb-3">
    <button type="submit" name="export_csv" class="btn btn-success">Export CSV</button>
  </form>

  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td><?php echo htmlspecialchars($row['email']); ?></td>
          <td><?php echo htmlspecialchars($row['message']); ?></td>
          <td><?php echo $row['created_at']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>