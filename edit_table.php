<?php
include 'config.php';
$pageTitle = "Edit Table | PinkBite";

if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit;
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM tables WHERE id = $id");
$table = mysqli_fetch_assoc($result);

include 'header.php';
?>

<section class="py-5" style="background-color: #fff0f5;">
<div class="container" style="max-width: 600px;">
    <h3 class="text-center mb-4" style="color: #ff69b4;">✏️ Edit Table</h3>
    <form action="process_edit_table.php" method="POST" class="p-4 rounded-4 shadow" style="background-color: #ffffff;">
        <input type="hidden" name="id" value="<?= $table['id'] ?>">

    <div class="mb-3">
        <label class="form-label">Table Number</label>
        <input type="text" name="table_number" class="form-control" value="<?= $table['table_number'] ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Capacity</label>
        <input type="number" name="capacity" class="form-control" value="<?= $table['capacity'] ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="available" <?= $table['status'] === 'available' ? 'selected' : '' ?>>Available</option>
            <option value="occupied" <?= $table['status'] === 'occupied' ? 'selected' : '' ?>>Occupied</option>
            <option value="reserved" <?= $table['status'] === 'reserved' ? 'selected' : '' ?>>Reserved</option>
        </select>
        </div>

    <div class="text-center">
        <button type="submit" class="btn btn-success px-4">Update</button>
        <a href="admin_dashboard.php" class="btn btn-secondary px-4">Cancel</a>
    </div>
    </form>
</div>
</section>

<?php include 'footer.php'; ?>
