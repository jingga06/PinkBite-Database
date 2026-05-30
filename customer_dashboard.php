<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

include 'config.php';
include 'header.php';

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = $user_id");
$customer = mysqli_fetch_assoc($query);

if (!$customer) {
    $getUser = mysqli_query($conn, "SELECT username, email FROM users WHERE id = $user_id");
    $userData = mysqli_fetch_assoc($getUser);
    $username = $userData['username'] ?? 'Customer';
    $email = $userData['email'] ?? '';

    mysqli_query($conn, "INSERT INTO customers (name, email, user_id) VALUES ('$username', '$email', $user_id)");

    $query = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = $user_id");
    $customer = mysqli_fetch_assoc($query);
}

$cust_name = htmlspecialchars($customer['name'] ?? 'Customer');
$cust_email = htmlspecialchars($customer['email'] ?? 'Not set');
?>

<div class="container mt-3">
    <h3 class="text-pink fw-semibold">
        Welcome, <?= $cust_name ?>!
    </h3>
</div>

<div class="container py-5" style="background-color: #fff0f5;">
    <div class="text-center mb-4">
        <h2 style="color: #ff69b4;">🎀 Hello, <?= $cust_name ?>!</h2>
        <p class="text-muted">Welcome back to your sweet space 🍓</p>
    </div>

    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; background-color: #ffe4ec;">
                <div class="card-body">
                    <h5 class="card-title text-pink fw-bold">👩‍🍳 Your Profile</h5>
                    <p><strong>Name:</strong> <?= $cust_name ?></p>
                    <p><strong>Email:</strong> <?= $cust_email ?></p>
                </div>
            </div>
        </div>

        <!-- Last Reservation Card -->
        <div class="col-md-6">
            <?php
            $res = mysqli_query($conn, "SELECT * FROM reservations WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 1");
            $lastRes = mysqli_fetch_assoc($res);
            ?>
            <div class="card border-0 shadow-sm" style="border-radius: 20px; background-color: #ffe4ec;">
                <div class="card-body">
                    <h5 class="card-title text-pink fw-bold">📅 Last Reservation</h5>
                    <?php if ($lastRes): ?>
                        <p><strong>Date:</strong> <?= date('d M Y, H:i', strtotime($lastRes['reservation_time'])) ?></p>
                        <p><strong>For:</strong> <?= $lastRes['party_size'] ?> people</p>
                        <p><strong>Status:</strong> <?= htmlspecialchars($lastRes['status']) ?></p>
                    <?php else: ?>
                        <p>You haven't made any reservation yet 😔</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sweet Message Card -->
        <div class="col-md-12">
            <?php
            $quotes = [
                "You're the sprinkle to our cupcake! 🧁",
                "May your day be as sweet as our desserts 🍩",
                "Keep glowing, sugar! ✨",
                "Life is short, eat more cake 🎂",
                "Your smile is our favorite flavor 🍓"
            ];
            $message = $quotes[array_rand($quotes)];
            ?>
            <div class="card text-center border-0 shadow-sm" style="border-radius: 20px; background-color: #fffafc;">
                <div class="card-body">
                    <h5 class="card-title text-pink fw-bold">💌 A Sweet Message for You</h5>
                    <p class="fs-5"><?= $message ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
