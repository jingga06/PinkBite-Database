<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'config.php';
include 'header_admin.php';

if (!isset($_GET['id'])) {
    header("Location: admin_menu.php");
    exit;
}

$id = $_GET['id'];
$menu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM menu WHERE id = $id"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Handle image upload
    if ($_FILES['image']['name']) {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = 'uploads/';
        $target_file = $upload_dir . basename($image_name);

        if (move_uploaded_file($tmp_name, $target_file)) {
            $image = $target_file;
        } else {
            echo "<script>alert('Image upload failed. Using previous image.');</script>";
            $image = $menu['image'];
        }
    } else {
        $image = $menu['image'];
    }

    mysqli_query($conn, "UPDATE menu SET name='$name', price='$price', image='$image' WHERE id=$id");
    header("Location: admin_menu.php?msg=updated");
    exit;
}
?>

<div class="container py-5" style="background-color: #fff0f5;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-white text-center">
                    <h3 class="fw-bold text-pink">୨🎀 Edit Menu 🎀୧</h3>
                </div>
                <div class="card-body p-4">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label text-pink">Name</label>
                            <input type="text" name="name" class="form-control rounded-3" value="<?= htmlspecialchars($menu['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-pink">Price</label>
                            <input type="number" name="price" class="form-control rounded-3" value="<?= $menu['price'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-pink">Current Image</label><br>
                            <img src="<?= $menu['image'] ?>" alt="Current Image" style="height:100px; border-radius:12px; object-fit:cover;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-pink">Upload New Image (optional)</label>
                            <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-pink px-4">💾 Save Changes</button>
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
