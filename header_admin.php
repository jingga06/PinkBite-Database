
<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= isset($pageTitle) ? $pageTitle : 'Admin - PinkBite' ?></title>

    <!-- Bootstrap, AOS, Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

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
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-link {
            color: white !important;
        }
        .nav-link:hover {
            background-color: #ffb6c1;
            border-radius: 20px;
            padding: 5px 15px;
            transition: 0.3s ease;
        }
        .btn-pink {
            background-color: hotpink;
            color: white;
            border-radius: 20px;
            padding: 6px 16px;
            border: none;
            font-weight: 500;
        }
        .btn-pink:hover {
            background-color: deeppink;
            color: white;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="admin_dashboard.php">
            <i class="bi bi-cake2-fill"></i> PinkBite
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_menu.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_customers.php">Customers</a></li>
            </ul>
            <span class="navbar-text me-3 text-white">
                Welcome, <?= htmlspecialchars($_SESSION['name'] ?? 'Admin') ?> 💕
            </span>
            <a href="logout.php" class="btn btn-pink btn-sm">Logout</a>
        </div>
    </div>
</nav>
