<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'config.php';
include 'header_admin.php';

// Handle Add Menu
if (isset($_POST['add_menu'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Upload Image
    $image_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $upload_dir = 'uploads/';
    $target_file = $upload_dir . basename($image_name);

    if (move_uploaded_file($tmp_name, $target_file)) {
        mysqli_query($conn, "INSERT INTO menu (name, price, image) VALUES ('$name', '$price', '$target_file')");
        header("Location: admin_menu.php?msg=added");
        exit;
    } else {
        echo "<script>alert('Image upload failed!');</script>";
    }
}
?>

<div class="container py-5" style="background-color: #fff0f5;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-white text-center">
                    <h3 class="fw-bold text-pink">୨🎀 Add New Menu Item 🎀୧</h3>
                </div>
                <div class="card-body p-4">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label text-pink">Name</label>
                            <input type="text" name="name" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-pink">Price</label>
                            <input type="number" name="price" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-pink">Image Upload</label>
                            <input type="file" name="image" class="form-control rounded-3" accept="image/*" required>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" name="add_menu" class="btn btn-pink px-4">💗 Add Menu 💗</button>
                            <a href="admin_menu.php" class="btn btn-outline-secondary ms-2 rounded-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.text-pink {
    color: #ff69b4 !important;
}
.btn-pink {
    background-color: #ff69b4;
    color: white;
    border-radius: 12px;
}
.btn-pink:hover {
    background-color: #ff85c1;
    color: white;
}
</style>

<?php include 'footer.php'; ?>
