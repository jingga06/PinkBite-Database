<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'config.php';
include 'header_admin.php';

// Handle Insert
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    mysqli_query($conn, "INSERT INTO customers (name, email) VALUES ('$name', '$email')");
    header("Location: admin_customers.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM customers WHERE id=$id");
    header("Location: admin_customers.php");
    exit;
}

// Fetch customers
$customers = mysqli_query($conn, "SELECT * FROM customers ORDER BY id DESC");
?>

<div class="container py-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold" style="color: #d63384;">👩‍🍳 Customer Management</h2>
        <p class="text-muted">Manage your beloved PinkBite customers 💕</p>
    </div>

    <!-- Add Customer Form -->
    <div class="card p-4 mb-4" style="background-color: #ffe4ec; border-radius: 20px;">
        <h5 style="color: #ff69b4;">➕ Add New Customer</h5>
        <form method="POST" action="admin_customers.php">
            <div class="row g-3">
                <div class="col-md-5">
                    <input type="text" name="name" class="form-control" placeholder="Customer Name" required>
                </div>
                <div class="col-md-5">
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="add" class="btn w-100" style="background-color: #ff69b4; color: white;">Add 💖</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Customer Table -->
    <div class="card p-4 shadow" style="background-color: #fff0f5; border-radius: 20px;">
        <h5 class="mb-3" style="color: #ff69b4;">📋 Customer List</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle" style="background-color: #fff;">
                <thead class="table-pink text-center">
                    <tr style="background-color: #ffc0cb;">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($customers)): ?>
                    <tr>
                        <td class="text-center"><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td class="text-center">
                            <a href="edit_customers.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-pink">Edit</a>
                            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this customer?')" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-pink {
        background-color: #ff69b4;
        color: white;
    }
    .btn-outline-pink {
        border: 1px solid #ff69b4;
        color: #ff69b4;
    }
    .btn-outline-pink:hover {
        background-color: #ff69b4;
        color: white;
    }
    .table-pink th {
        color: #fff;
        background-color: #ff69b4;
    }
</style>

<?php if (isset($_GET['msg'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php if ($_GET['msg'] == 'customer_added'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Customer Added!',
                        text: 'New customer added successfully 🍽️',
                        confirmButtonColor: '#ff69b4'
                    });
                <?php elseif ($_GET['msg'] == 'customer_updated'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Customer Updated!',
                        text: 'Customer information updated successfully ✏️',
                        confirmButtonColor: '#ff69b4'
                    });
                <?php elseif ($_GET['msg'] == 'customer_deleted'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Customer Deleted!',
                        text: 'Customer successfully deleted 🗑️',
                        confirmButtonColor: '#ff69b4'
                    });
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(tableId, tableNumber) {
            Swal.fire({
                title: 'Oh no! 🍽️',
                text: `Do you really wanna remove customer #${tableNumber}? Once gone, it's gone for good 💔`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff69b4',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it 💥',
                cancelButtonText: 'Nope, keep it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `delete_table.php?id=${tableId}`;
                }
            });
        }
    </script>


<?php include 'footer.php'; ?>
