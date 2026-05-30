<?php
include 'config.php';

if (!isset($_GET['queue_id'])) {
    header("Location: admin_dashboard.php");
    exit;
}

$queue_id = $_GET['queue_id'];

// Get the party size from the queue
$queue_query = mysqli_query($conn, "SELECT party_size FROM queue WHERE id = $queue_id");
$queue_data = mysqli_fetch_assoc($queue_query);
$party_size = $queue_data['party_size'];


$table_query = mysqli_query($conn, "
    SELECT * FROM tables 
    WHERE is_available = 1 
    AND capacity >= $party_size 
    ORDER BY capacity ASC 
    LIMIT 1
");

if (mysqli_num_rows($table_query) > 0) {
    $tableData = mysqli_fetch_assoc($table_query);
    $table_id = $tableData['id'];

    mysqli_query($conn, "INSERT INTO table_assignments (queue_id, table_id, assigned_at, status) VALUES ($queue_id, $table_id, NOW(), 'active')");
    mysqli_query($conn, "UPDATE tables SET is_available = 0, status = 'occupied' WHERE id = $table_id");
    mysqli_query($conn, "UPDATE queue SET status = 'seated' WHERE id = $queue_id");

    header("Location: admin_dashboard.php?msg=assigned&table=" . $tableData['table_number']);
} else {
    header("Location: admin_dashboard.php?msg=full");
}
?>
