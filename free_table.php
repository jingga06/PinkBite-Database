<?php
include 'config.php';

if (!isset($_GET['table_id']) && !isset($_GET['reservation_id'])) {
    header("Location: admin_dashboard.php");
    exit;
}

if (isset($_GET['table_id']) && !empty($_GET['table_id'])) {
    $table_id = $_GET['table_id'];

    mysqli_query($conn, "UPDATE tables SET is_available = 1 WHERE id = $table_id");

    mysqli_query($conn, "UPDATE table_assignments SET status = 'completed' WHERE table_id = $table_id AND status = 'active'");

    mysqli_query($conn, "
        UPDATE queue
        SET status = 'done'
        WHERE id IN (
            SELECT queue_id FROM table_assignments
            WHERE table_id = $table_id AND status = 'completed'
        )
    ");

    mysqli_query($conn, "
        UPDATE reservations
        SET status = 'completed'
        WHERE id IN (
            SELECT reservation_id FROM table_assignments
            WHERE table_id = $table_id AND status = 'completed' AND reservation_id IS NOT NULL
        )
    ");
} elseif (isset($_GET['reservation_id']) && !empty($_GET['reservation_id'])) {
    $reservation_id = $_GET['reservation_id'];

    mysqli_query($conn, "UPDATE table_assignments SET status = 'completed' WHERE reservation_id = $reservation_id AND status = 'active'");

    mysqli_query($conn, "
        UPDATE queue
        SET status = 'done'
        WHERE id IN (
            SELECT queue_id FROM table_assignments
            WHERE reservation_id = $reservation_id AND status = 'completed'
        )
    ");

    mysqli_query($conn, "
        UPDATE reservations
        SET status = 'completed'
        WHERE id = $reservation_id
    ");
}

header("Location: admin_dashboard.php?msg=freed");
