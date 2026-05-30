<?php
$pageTitle = "Add Table | PinkBite";
include 'header.php';
?>

<section class="py-5" style="background-color: #fff0f5;">
    <div class="container" style="max-width: 600px;">
    <h3 class="text-center mb-4" style="color: #ff69b4;">➕ Add New Table</h3>
    <form action="process_add_table.php" method="POST" class="p-4 rounded-4 shadow" style="background-color: #ffffff;">

        <div class="mb-3">
        <label for="table_number" class="form-label">Table Number</label>
        <input type="text" name="table_number" class="form-control" required>
        </div>

        <div class="mb-3">
        <label for="capacity" class="form-label">Capacity</label>
        <input type="number" name="capacity" class="form-control" required>
        </div>

        <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="available">Available</option>
            <option value="occupied">Occupied</option>
            <option value="reserved">Reserved</option>
        </select>
        </div>

        <div class="text-center">
        <button type="submit" class="btn btn-success px-4">Save Table</button>
        <a href="admin_dashboard.php" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </form>
    </div>
</section>

<?php include 'footer.php'; ?>
