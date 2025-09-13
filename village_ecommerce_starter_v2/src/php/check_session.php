<?php
session_start();
echo json_encode(['logged' => isset($_SESSION['user_id']), 'name' => $_SESSION['user_name'] ?? '']);
?>