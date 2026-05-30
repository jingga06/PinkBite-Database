<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $reservation_time = $_POST['reservation_time'];
    $party_size = (int)$_POST['party_size'];

    $query = "INSERT INTO reservations (name, phone, reservation_time, party_size, status) 
                VALUES ('$name', '$phone', '$reservation_time', $party_size, 'pending')";

    if (mysqli_query($conn, $query)) {
        $reservation_id = mysqli_insert_id($conn);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Reservation Receipt</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <style>
                body {
                    background-color: #fff0f5;
                    font-family: 'Quicksand', sans-serif;
                }
                .receipt-card {
                    background: #ffe6f0;
                    border-radius: 25px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                    padding: 30px;
                    max-width: 600px;
                    margin: auto;
                }
                .receipt-title {
                    color: #ff4da6;
                    font-weight: 600;
                    font-size: 28px;
                }
                .list-group-item {
                    background-color: #fff5fa;
                    border: none;
                    border-radius: 12px;
                    margin-bottom: 10px;
                }
                .btn-pink {
                    background-color: #ff69b4;
                    color: white;
                    border-radius: 15px;
                    padding: 10px 20px;
                    font-weight: bold;
                    box-shadow: 0 2px 8px rgba(255,105,180,0.4);
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Reservation Confirmed! 🎉',
                text: 'You\'re all set, see you soon!',
                confirmButtonColor: '#ff69b4'
            });
        </script>

        <div class="container mt-5">
            <div class="receipt-card text-center">
                <h2 class="receipt-title mb-4">🎀 Reservation Receipt 🎀</h2>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Reservation ID:</strong> <?php echo $reservation_id; ?></li>
                    <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></li>
                    <li class="list-group-item"><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></li>
                    <li class="list-group-item"><strong>Time:</strong> <?php echo htmlspecialchars($reservation_time); ?></li>
                    <li class="list-group-item"><strong>Party Size:</strong> <?php echo $party_size; ?></li>
                    <li class="list-group-item"><strong>Status:</strong> Pending 🕒</li>
                </ul>
                <div class="mt-4">
                    <a href="customer_dashboard.php" class="btn btn-pink">Back to Dashboard</a>
                </div>
            </div>
        </div>

        </body>
        </html>
        <?php
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
