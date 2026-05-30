<?php
include 'config.php';
session_start();

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST["fullname"] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';
    $confirm = $_POST["confirm"] ?? '';

    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } elseif (strlen($password) < 4) {
        $error = "Password must be at least 4 characters!";
    } else {
        $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($checkEmail) > 0) {
            $error = "Email already registered!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertUser = mysqli_query($conn, "INSERT INTO users (username, email, password, role) VALUES ('$fullname', '$email', '$hashedPassword', 'customer')");

            if ($insertUser) {
                $user_id = mysqli_insert_id($conn);

                $insertCustomer = mysqli_query($conn, "INSERT INTO customers (name, email, user_id) VALUES ('$fullname', '$email', $user_id)");

                if ($insertCustomer) {
                    $_SESSION["success_message"] = "Registration successful! Please login.";
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "Failed to create customer profile. Please try again.";
                }
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Register | PinkBite</title>
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
            margin: 50px auto;
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
        <h3 class="text-center" style="color: #ff69b4;">Register to PinkBite 🍰</h3>
        <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="fullname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email address</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3 position-relative">
                <label>Password</label>
                <input type="password" name="password" class="form-control password-field" minlength="4" required>
                <i class="bi bi-eye-fill toggle-eye" onclick="togglePassword(this)"></i>
            </div>
            <div class="mb-3 position-relative">
                <label>Confirm Password</label>
                <input type="password" name="confirm" class="form-control password-field" required>
                <i class="bi bi-eye-fill toggle-eye" onclick="togglePassword(this)"></i>
            </div>
            <button type="submit" class="btn w-100" style="background-color: #ff69b4; color: white;">Register</button>
            <p class="text-center mt-3">Already have an account? <a href="login.php" style="color: #d63384;">Login here</a></p>
            <div class="text-center mt-2">
                <a href="index.php" class="btn btn-light" style="color: #ff69b4;">← Back to Home</a>
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