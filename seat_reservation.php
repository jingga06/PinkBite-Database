<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit;
}

$reservation_id = $_GET['id'];

$reservation = mysqli_query($conn, "SELECT * FROM reservations WHERE id = $reservation_id");
$res = mysqli_fetch_assoc($reservation);

$party_size = $res['party_size'];
$table = mysqli_query($conn, "
    SELECT * FROM tables 
    WHERE is_available = 1 AND capacity >= $party_size 
    ORDER BY capacity ASC LIMIT 1
");

if (mysqli_num_rows($table) > 0) {
    $tableData = mysqli_fetch_assoc($table);
    $table_id = $tableData['id'];

    mysqli_query($conn, "UPDATE reservations SET status = 'seated' WHERE id = $reservation_id");
    mysqli_query($conn, "INSERT INTO table_assignments (reservation_id, table_id, assigned_at, status) VALUES ($reservation_id, $table_id, NOW(), 'active')");
    mysqli_query($conn, "UPDATE tables SET is_available = 0 WHERE id = $table_id");

    header("Location: admin_dashboard.php?msg=assigned&user=" . urlencode($res['name']));
} else {
    header("Location: admin_dashboard.php?msg=full");
}
?>
