<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

include 'config.php';

$user_id = $_SESSION['user_id'];

$queryCurrent = "SELECT * FROM queue WHERE user_id = $user_id AND status IN ('waiting', 'called') ORDER BY created_at DESC LIMIT 1";
$resultCurrent = mysqli_query($conn, $queryCurrent);
$queue = mysqli_fetch_assoc($resultCurrent);

if (!$queue && isset($_GET['take'])) {
    // Show form to select number of people
    if (!isset($_POST['party_size'])) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Take Queue - PinkBite</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
            <style>
                body {
                    background-color: #fff0f5;
                    font-family: 'Poppins', sans-serif;
                }

                .queue-container {
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .queue-card {
                    background-color: #ffe4ec;
                    border-radius: 25px;
                    padding: 40px;
                    box-shadow: 0 0 20px rgba(255, 192, 203, 0.5);
                    max-width: 500px;
                    width: 100%;
                }

                .queue-title {
                    color: #ff69b4;
                    font-weight: bold;
                    margin-bottom: 30px;
                    text-align: center;
                }

                .queue-subtitle {
                    color: #ff69b4;
                    text-align: center;
                    margin-bottom: 40px;
                }

                .form-select {
                    background-color: #fff;
                    border: 2px solid #ffb6c1;
                    border-radius: 15px;
                    padding: 12px 20px;
                    color: #ff69b4;
                    font-size: 1.1rem;
                    transition: all 0.3s ease;
                    margin-bottom: 20px;
                }

                .form-select:focus {
                    border-color: #ff69b4;
                    box-shadow: 0 0 0 0.25rem rgba(255, 105, 180, 0.25);
                }

                .form-select option {
                    padding: 10px;
                    color: #ff69b4;
                }

                .form-label {
                    color: #ff69b4;
                    font-weight: 500;
                    margin-bottom: 10px;
                    font-size: 1.1rem;
                }

                .btn-queue {
                    background-color: #ff69b4;
                    color: white;
                    border: none;
                    border-radius: 15px;
                    padding: 12px 30px;
                    font-size: 1.1rem;
                    width: 100%;
                    transition: all 0.3s ease;
                }

                .btn-queue:hover {
                    background-color: #ff1493;
                    transform: translateY(-2px);
                    box-shadow: 0 5px 15px rgba(255, 105, 180, 0.3);
                }

                .btn-queue i {
                    margin-right: 8px;
                }
            </style>
        </head>
        <body>
            <div class="queue-container">
                <div class="queue-card">
                    <h2 class="queue-title">🍰 Take Queue Number</h2>
                    <p class="queue-subtitle">How many people are in your party? 💕</p>
                    
                    <form method="POST" action="?take=true">
                        <div class="mb-4">
                            <label for="party_size" class="form-label">Number of People</label>
                            <select name="party_size" class="form-select" required>
                                <option value="">Select number of people</option>
                                <?php for($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?> person<?= $i > 1 ? 's' : '' ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-queue">
                            <i class="fas fa-ticket-alt"></i> Take Queue
                        </button>
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit;
    }

    // Process the queue number after party size is selected
    $party_size = $_POST['party_size'];
    $getLast = mysqli_query($conn, "SELECT MAX(queue_number) AS last FROM queue");
    $last = mysqli_fetch_assoc($getLast);
    $nextQueue = $last['last'] + 1;

    mysqli_query($conn, "INSERT INTO queue (user_id, queue_number, party_size) VALUES ($user_id, $nextQueue, $party_size)");
    header("Location: queueing.php");
    exit;
}

$calledResult = mysqli_query($conn, "SELECT MIN(queue_number) AS current FROM queue WHERE status = 'called'");
$called = mysqli_fetch_assoc($calledResult);
$currentCalled = $called['current'] ?? 0;

$estimatePerPerson = 3;

$queryHistory = "SELECT * FROM queue WHERE user_id = $user_id ORDER BY created_at DESC";
$resultHistory = mysqli_query($conn, $queryHistory);

include 'header.php';

?>

<style>
    body {
        background-color: #fff0f5;
        font-family: 'Poppins', sans-serif;
    }

    h2, h4 {
        color: #ff69b4;
        font-weight: bold;
    }

    .btn-pink {
        background-color: #ff69b4;
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-pink:hover {
        background-color: #ff1493;
    }

    .card-queue {
        background-color: #ffe4ec;
        border-radius: 25px;
        padding: 30px;
        margin-bottom: 40px;
        box-shadow: 0 0 10px #ffc0cb;
    }

    .table-pink {
        background-color: #ffb6c1;
        color: white;
    }

    .badge {
        padding: 0.5em 0.75em;
        border-radius: 20px;
        font-size: 0.9rem;
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .rounded {
        border-radius: 20px;
    }

    .back-btn {
        margin-top: 30px;
    }

    /* New styles for queue selection form */
    .form-select {
        background-color: #fff;
        border: 2px solid #ffb6c1;
        border-radius: 15px;
        padding: 12px 20px;
        color: #ff69b4;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        border-color: #ff69b4;
        box-shadow: 0 0 0 0.25rem rgba(255, 105, 180, 0.25);
    }

    .form-select option {
        padding: 10px;
        color: #ff69b4;
    }

    .form-label {
        color: #ff69b4;
        font-weight: 500;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .queue-form {
        max-width: 400px;
        margin: 0 auto;
    }

    .queue-form .btn-pink {
        width: 100%;
        padding: 12px;
        font-size: 1.1rem;
        border-radius: 15px;
        margin-top: 20px;
    }

    .queue-form .btn-pink:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 105, 180, 0.3);
    }
</style>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2>🍰 Your Current Queue</h2>
        <p class="text-muted">We are preparing sweetness just for you 💕</p>
    </div>

    <div class="card card-queue mx-auto" style="max-width: 600px;">
        <?php if ($queue): ?>
            <h4>Queue Number</h4>
            <div class="display-4 mb-3" style="font-weight:bold; color: #d63384;">
                #<?= str_pad($queue['queue_number'], 3, '0', STR_PAD_LEFT) ?>
            </div>

            <?php
                $waitingAhead = max(0, $queue['queue_number'] - $currentCalled - 1);
                $estimatedTime = $waitingAhead * $estimatePerPerson;
            ?>

            <ul class="list-group mb-4 text-start">
                <li class="list-group-item">📍 <strong>Restaurant:</strong> PinkBite Resto</li>
                <li class="list-group-item">🗓️ <strong>Date:</strong> <?= date('l, d M Y', strtotime($queue['created_at'])) ?></li>
                <li class="list-group-item">⌛ <strong>People ahead:</strong> <?= $waitingAhead ?></li>
                <li class="list-group-item">⏱️ <strong>Estimated wait:</strong> <?= $estimatedTime ?> minutes</li>
                <li class="list-group-item">📌 <strong>Location:</strong> President University Campus Area</li>
            </ul>

            <p class="text-muted">Please stay nearby. You'll be called soon 🥰</p>
        <?php else: ?>
            <p class="mb-4">You haven't taken a queue number yet 🍧</p>
            <a href="?take=true" class="btn btn-pink px-4 py-2">Take Queue</a>
        <?php endif; ?>
    </div>

    <div class="text-center mb-4">
        <h2>🎀 Your Queue History</h2>
        <p class="text-muted">Here's your sweetness journey with us 🍬</p>
    </div>

    <?php if (mysqli_num_rows($resultHistory) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center bg-white shadow-sm rounded">
                <thead class="table-pink">
                    <tr>
                        <th>Queue Number</th>
                        <th>Party Size</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($resultHistory)): ?>
                        <tr>
                            <td><strong>#<?= str_pad($row['queue_number'], 3, '0', STR_PAD_LEFT) ?></strong></td>
                            <td><?= $row['party_size'] ?> person<?= $row['party_size'] > 1 ? 's' : '' ?></td>
                            <td>
                                <?php
                                    $badgeClass = 'secondary';
                                    if ($row['status'] === 'waiting') $badgeClass = 'warning';
                                    elseif ($row['status'] === 'called') $badgeClass = 'success';
                                    elseif ($row['status'] === 'done') $badgeClass = 'info';
                                    elseif ($row['status'] === 'cancelled') $badgeClass = 'danger';
                                ?>
                                <span class="badge bg-<?= $badgeClass ?> text-uppercase"><?= $row['status'] ?></span>
                            </td>
                            <td><?= date('d M Y, H:i', strtotime($row['created_at'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="text-center">
            <p class="text-muted">You haven't joined any queue yet 💡</p>
            <a href="?take=true" class="btn btn-pink">Take Your First Queue 🍭</a>
        </div>
    <?php endif; ?>

    <div class="text-center back-btn">
        <a href="customer_dashboard.php" class="btn btn-outline-danger rounded-pill px-4 py-2">Back to Dashboard</a>
    </div>
</div>

<?php include 'footer.php'; ?>
