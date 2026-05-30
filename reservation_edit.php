<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'config.php';
include 'header.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Invalid reservation ID.";
    exit;
}

$res = mysqli_query($conn, "SELECT * FROM reservations WHERE id = $id");
$reservation = mysqli_fetch_assoc($res);

if (!$reservation) {
    echo "Reservation not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = $_POST['status'];

    $stmt = mysqli_prepare($conn, "UPDATE reservations SET status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $new_status, $id);
    mysqli_stmt_execute($stmt);

    if ($new_status === 'seated') {
        mysqli_query($conn, "UPDATE tables SET status = 'occupied' WHERE id = {$reservation['table_id']}");
    }

    echo "<script>alert('Reservation updated.'); window.location='reservations_view.php';</script>";
    exit;
}
?>

<div class="container py-5">
    <h2 class="mb-4 text-center text-pink">Update Reservation Status</h2>

    <form method="POST" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Customer Name</label>
            <input type="text" class="form-control" value="<?= $reservation['customer_name'] ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Reservation Time</label>
            <input type="text" class="form-control" value="<?= $reservation['reservation_time'] ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Update Status</label>
            <select name="status" class="form-select" required>
                <option value="">-- Select New Status --</option>
                <option value="seated" <?= $reservation['status'] === 'seated' ? 'selected' : '' ?>>Seated</option>
                <option value="cancelled" <?= $reservation['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>

        <button class="btn btn-pink w-100" type="submit">Update</button>
    </form>

    <div class="text-center mt-4">
        <a href="reservations_view.php" class="btn btn-outline-secondary rounded-pill">← Back to Reservations</a>
    </div>
</div>

<?php include 'footer.php'; ?>
