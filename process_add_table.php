<?php
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_number = $_POST['table_number'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    $query = "INSERT INTO tables (table_number, capacity, status, is_available)
            VALUES ('$table_number', '$capacity', '$status', 1)";


    if (mysqli_query($conn, $query)) {
        header("Location: admin_dashboard.php?msg=table_added");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
