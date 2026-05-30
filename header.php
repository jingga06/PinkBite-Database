<!-- header.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= isset($pageTitle) ? $pageTitle : 'PinkBite Restaurant' ?></title>

    <!-- Link Bootstrap, AOS, Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #fff0f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #ffc0cb;
        }

        .navbar-brand {
            color: white;
            font-weight: bold;
            font-size: 24px;
        }

        .bg-pink {
            background-color: #ff69b4;
            transition: background-color 0.3s ease;
        }

        .bg-pink:hover {
            background-color: #ff1493;
            text-decoration: none;
        }

        .nav-link {
            color: white !important;
        }

        .login-btn,
        .register-btn {
            font-size: 16px;
            padding: 8px 20px;
            border-radius: 50px;
        }

        .navbar-nav .nav-link:hover {
            background-color: #ffb6c1;
            border-radius: 20px;
            padding: 5px 15px;
            transition: 0.3s ease;
        }

        .food-img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .food-name {
            font-family: 'Pacifico', cursive;
            font-size: 22px;
            color: #ff69b4;
            margin-top: 15px;
        }

        .food-price {
            font-size: 16px;
            color: #555;
            margin-top: 5px;
        }

        .text-pink {
            color: #ff69b4;
        }

        .card-title {
            font-size: 1.2rem;
        }

        .btn-pink {
            background-color: #ff69b4;
            color: white;
            border: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-pink:hover {
            background-color: #ff1493;
            color: white;
        }

        .btn-outline-pink {
            background-color: transparent;
            border: 2px solid #ff69b4;
            color: #ff69b4;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-outline-pink:hover {
            background-color: #ff69b4;
            color: white;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: #ffc0cb;">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="#">🍰 PinkBite</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white"
                            href="<?php
                                    if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'customer') {
                                        echo 'customer_dashboard.php';
                                    } else {
                                        echo 'index.php';
                                    }
                                    ?>">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="menu.php">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="queueing.php">Queueing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="reservation.php">Reservation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="contact.php">Contact</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <?php if (isset($_SESSION['customer_id']) || isset($_SESSION['admin_logged_in'])): ?>
                        <a href="logout.php" class="btn btn-pink btn-sm rounded-pill px-4">
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-pink btn-sm rounded-pill px-4">
                            Login
                        </a>
                        <a href="register.php" class="btn btn-outline-pink btn-sm rounded-pill px-4">
                            Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>