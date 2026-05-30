<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'config.php';
include 'header_admin.php';

// Handle Delete Menu
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM menu WHERE id = $id");
    header("Location: admin_menu.php?msg=deleted");
    exit;
}
?>

<div class="container py-5" style="background-color:#fff0f5;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-pink fw-bold">୨୧ Admin Menu List 🍓</h3>
        <a href="add_menu.php" class="btn btn-pink">+ Add Menu</a>
    </div>

    <div class="table-responsive bg-white p-3 rounded-4 shadow">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-pink text-pink">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $menuQuery = mysqli_query($conn, "SELECT * FROM menu");
                while ($row = mysqli_fetch_assoc($menuQuery)) {
                ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><img src="<?= $row['image'] ?>" alt="img" style="width:60px; height:60px; object-fit:cover; border-radius:12px;"></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                        <td>
                            <a href="edit_menu.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-pink">Edit</a>
                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
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
.btn-outline-pink {
    color: #ff69b4;
    border: 1px solid #ff69b4;
    border-radius: 12px;
}
.btn-outline-pink:hover {
    background-color: #ff69b4;
    color: white;
}
.table-pink {
    background-color: #ffe4ec;
}
</style>

<?php include 'footer.php'; ?>
