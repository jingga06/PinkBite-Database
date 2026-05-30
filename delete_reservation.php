<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header('Location: admin_dashboard.php');
    exit;
}

$id = $_GET['id'];

// Delete reservation
mysqli_query($conn, "DELETE FROM reservations WHERE id = $id");

header('Location: admin_dashboard.php?msg=reservation_deleted');
