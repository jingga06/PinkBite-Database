<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $table_number = $_POST['table_number'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    $query = "UPDATE tables SET table_number='$table_number', capacity='$capacity', status='$status' WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        header("Location: admin_dashboard.php?msg=table_updated");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
