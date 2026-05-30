<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header('Location: admin_dashboard.php');
    exit;
}

$id = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM reservations WHERE id = $id");
$data = mysqli_fetch_assoc($res);

if (!$data) {
    echo "Reservation not found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $reservation_time = $_POST['reservation_time'];
    $party_size = $_POST['party_size'];
    $status = $_POST['status'];

    $update = mysqli_query($conn, "
        UPDATE reservations 
        SET name='$name', phone='$phone', reservation_time='$reservation_time', 
            party_size='$party_size', status='$status'
        WHERE id=$id
    ");

    if ($update) {
        header('Location: admin_dashboard.php?msg=reservation_updated');
    } else {
        echo "Update failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #fff0f5;">
<div class="container py-5">
    <div class="card shadow p-4">
        <h3 class="text-center text-pink mb-4">✏️ Edit Reservation</h3>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($data['phone']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Reservation Time</label>
                <input type="datetime-local" name="reservation_time" value="<?= date('Y-m-d\TH:i', strtotime($data['reservation_time'])) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Party Size</label>
                <input type="number" name="party_size" value="<?= $data['party_size'] ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="pending" <?= $data['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="seated" <?= $data['status'] == 'seated' ? 'selected' : '' ?>>Seated</option>
                    <option value="cancelled" <?= $data['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
            <div class="text-end">
                <a href="admin_dashboard.php" class="btn btn-outline-secondary">← Cancel</a>
                <button type="submit" class="btn btn-pink" style="background-color: #ff66a3; color: white;">💾 Save Changes</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
