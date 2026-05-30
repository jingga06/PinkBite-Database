<?php
include 'config.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if ($query && mysqli_num_rows($query) == 1) {
        $user = mysqli_fetch_assoc($query);

        
        if (password_verify($password, $user['password'])) {
            if (isset($user['role'])) {
                if ($user['role'] == 'admin') {
                    $_SESSION["admin_logged_in"] = true;
                    $_SESSION["user_id"] = $user["id"]; 
                    $_SESSION["role"] = "admin";         
                    header("Location: admin_dashboard.php");
                    exit();
                } else if ($user['role'] == 'customer') {
                    $_SESSION["customer_logged_in"] = true;
                    $_SESSION["customer_id"] = $user["id"];
                    $_SESSION["customer_name"] = $user["username"];
                    $_SESSION["user_id"] = $user["id"]; 
                    $_SESSION["role"] = "customer";     
                    header("Location: customer_dashboard.php");
                    exit();
                } else {
                    $error = "Role tidak dikenali.";
                }
            } else {
                $error = "Role tidak ditemukan.";
            }
        }
    }

    $error = "Invalid email or password.";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login | PinkBite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #ffe4ec;
        }

        .form-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 500px;
            margin: 80px auto;
            box-shadow: 0 0 20px #ffc0cb;
        }

        .position-relative {
            position: relative;
        }

        .toggle-eye {
            position: absolute;
            top: 72%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #ff69b4;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h3 class="text-center" style="color: #ff69b4;">Login to PinkBite 🍰</h3>

        <?php if (isset($_SESSION["success_message"])): ?>
            <div class="alert alert-success"><?= $_SESSION["success_message"];
                                                unset($_SESSION["success_message"]); ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Email address</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3 position-relative">
                <label>Password</label>
                <input type="password" name="password" class="form-control password-field" required>
                <i class="bi bi-eye-fill toggle-eye" onclick="togglePassword(this)"></i>
            </div>
            <button type="submit" class="btn w-100" style="background-color: #ff69b4; color: white;">Login</button>
            <p class="text-center mt-3">Don't have an account? <a href="register.php" style="color: #d63384;">Register here</a></p>
            <div class="text-center mt-2">
                <a href="index.php" class="btn btn-light" style="color: #ff69b4;">← Back to Dashboard</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(icon) {
            const input = icon.previousElementSibling;
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                input.type = "password";
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            }
        }
    </script>

</body>

</html>