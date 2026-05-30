<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'config.php';
include 'header.php';

$tables = mysqli_query($conn, "SELECT * FROM tables WHERE status = 'available'");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $reservation_time = $_POST['reservation_time'];
    $guest_count = $_POST['guest_count'];
    $table_id = $_POST['table_id'];

    $stmt = mysqli_prepare($conn, "INSERT INTO reservations (customer_name, reservation_time, guest_count, table_id, status) VALUES (?, ?, ?, ?, 'pending')");
    mysqli_stmt_bind_param($stmt, "ssii", $customer_name, $reservation_time, $guest_count, $table_id);
    mysqli_stmt_execute($stmt);

    echo "<script>alert('Reservation added!'); window.location='reservations_view.php';</script>";
    exit;
}
?>

<div class="container py-5">
    <h2 class="mb-4 text-center text-pink">Add New Reservation</h2>

    <form method="POST" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Customer Name</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Reservation Time</label>
            <input type="datetime-local" name="reservation_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Guest Count</label>
            <input type="number" name="guest_count" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Choose Table</label>
            <select name="table_id" class="form-select" required>
                <option value="">-- Select Available Table --</option>
                <?php while ($table = mysqli_fetch_assoc($tables)): ?>
                    <option value="<?= $table['id'] ?>">Table #<?= $table['table_number'] ?> (<?= $table['capacity'] ?> seats)</option>
                <?php endwhile; ?>
            </select>
        </div>

        <button class="btn btn-pink w-100" type="submit">Add Reservation</button>
    </form>

    <div class="text-center mt-4">
        <a href="reservations_view.php" class="btn btn-outline-secondary rounded-pill">← Back to Reservations</a>
    </div>
</div>

<?php include 'footer.php'; ?>
