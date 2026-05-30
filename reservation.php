<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

include 'config.php';
include 'header.php';

$user_id = $_SESSION['user_id'];
$success = false;
$reservation = null;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $people = (int) $_POST['people'];

    $insert = "INSERT INTO reservations (user_id, name, reservation_time, party_size, status, created_at)
                VALUES ('$user_id', '$name', '$date $time', '$people', 'pending', NOW())";

    if (mysqli_query($conn, $insert)) {
        $success = true;
    }
}

// Fetch latest reservation
$resQuery = "SELECT * FROM reservations WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 1";
$resResult = mysqli_query($conn, $resQuery);
if ($resResult && mysqli_num_rows($resResult) > 0) {
    $reservation = mysqli_fetch_assoc($resResult);
}
?>

<style>
    body {
        background-color: #fff0f5;
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        color: #ff69b4;
        font-weight: bold;
    }

    .reservation-container {
        max-width: 650px;
        margin: 0 auto;
        background: #ffe4ec;
        padding: 40px;
        border-radius: 30px;
        box-shadow: 0 0 25px rgba(255, 105, 180, 0.25);
    }

    label {
        font-weight: 500;
        color: #d63384;
    }

    .form-control {
        border-radius: 15px;
        padding: 10px 15px;
    }

    .btn-pink {
        background-color: #ff69b4;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        transition: 0.3s ease;
    }

    .btn-pink:hover {
        background-color: #ff1493;
    }

    .success-message {
        background-color: #fff0fa;
        border: 2px solid #ff69b4;
        color: #d63384;
        padding: 15px;
        border-radius: 20px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
    }

    .reservation-card {
        background-color: #ffe8f0;
        border: 2px dashed #ff69b4;
        border-radius: 20px;
        padding: 25px;
        margin-top: 30px;
        box-shadow: 0 0 15px rgba(255, 182, 193, 0.4);
    }

    .reservation-card h4 {
        color: #d63384;
        font-weight: bold;
    }

    .reservation-card ul {
        list-style: none;
        padding-left: 0;
        margin-top: 15px;
    }

    .reservation-card li {
        padding: 10px;
        background-color: #fff;
        margin-bottom: 10px;
        border-radius: 15px;
        font-size: 15px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.05);
    }

    .back-btn {
        margin-top: 30px;
    }
</style>

<div class="container py-5">
    <div class="text-center mb-4">
        <h2>🎀 Make a Reservation</h2>
        <p class="text-muted">Book your sweet moment with us 💗</p>
    </div>

    <?php if ($success): ?>
        <div class="success-message">
            🎉 Your reservation has been made successfully! See you at PinkBite 💖
        </div>
    <?php endif; ?>

    <div class="reservation-container">
        <form method="POST" action="reservation.php">
            <div class="mb-3">
                <label for="name" class="form-label">Your Name 🌸</label>
                <input type="text" class="form-control" id="name" name="name" required placeholder="">
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date 📅</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>

            <div class="mb-3">
                <label for="time" class="form-label">Time ⏰</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>

            <div class="mb-3">
                <label for="people" class="form-label">Number of People 👯‍♀️</label>
                <input type="number" class="form-control" id="people" name="people" min="1" max="10" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-pink">Reserve Now 🍓</button>
            </div>
        </form>
    </div>

    
    <?php if ($reservation): ?>
        <div class="reservation-card mt-5">
            <h4>🍰 Your Latest Reservation</h4>
            <ul>
                <li><strong>👤 Name:</strong> <?= htmlspecialchars($reservation['name']) ?></li>
                <li><strong>📅 Date:</strong> <?= date('l, d M Y', strtotime($reservation['reservation_time'])) ?></li>
                <li><strong>⏰ Time:</strong> <?= date('H:i', strtotime($reservation['reservation_time'])) ?> WIB</li>
                <li><strong>👥 Party Size:</strong> <?= $reservation['party_size'] ?></li>
                <li><strong>📌 Status:</strong> <?= ucfirst($reservation['status']) ?></li>
            </ul>
            <div class="text-muted small">Show this to staff on your reservation day 💕</div>
        </div>
    <?php endif; ?>

    <div class="text-center back-btn">
        <a href="customer_dashboard.php" class="btn btn-outline-danger rounded-pill px-4 py-2">Back to Dashboard</a>
    </div>
</div>

<?php include 'footer.php'; ?>
