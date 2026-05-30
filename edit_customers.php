<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'config.php';
include 'header_admin.php';

if (!isset($_GET['id'])) {
    header("Location: admin_customers.php");
    exit;
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM customers WHERE id = $id");
$customer = mysqli_fetch_assoc($result);

if (!$customer) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Customer not found.</div></div>";
    include 'footer.php';
    exit;
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    mysqli_query($conn, "UPDATE customers SET name='$name', email='$email' WHERE id=$id");
    header("Location: admin_customers.php?msg=updated");
    exit;
}
?>

<div class="container py-5">
    <h3 class="text-center mb-4" style="color:#ff69b4;">💌 Edit Customer</h3>
    <div class="card shadow mx-auto" style="max-width: 600px; border-radius: 20px; background-color: #fff0f5;">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Customer Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($customer['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($customer['email']) ?>" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="admin_customers.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-pink">Save Changes 💾</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.btn-pink {
    background-color: #ff69b4;
    color: white;
}
.btn-pink:hover {
    background-color: #ff1493;
}
</style>

<?php include 'footer.php'; ?>
