<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM tables WHERE id = $id");
}

header("Location: admin_dashboard.php?msg=table_deleted");
exit;
?>
