<?php

include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit;
}

$id = $_GET['id'];
mysqli_query($conn, "UPDATE queue SET status = 'called' WHERE id = $id");

header("Location: admin_dashboard.php?msg=called");
?>
