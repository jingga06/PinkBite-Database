<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$totalQueue = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM queue WHERE status = 'waiting'"));
$totalTables = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tables"));
$tablesAvailable = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tables WHERE is_available = 1"));
$reservationToday = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM reservations WHERE DATE(reservation_time) = CURDATE()"));


include 'header_admin.php';
?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'table_added'): ?>
    <div class="alert alert-success text-center" role="alert">
        🎉 New table has been added successfully!
    </div>
<?php endif; ?>


<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success text-center">
        <?php
        if ($_GET['msg'] == 'table_added') echo "✅ Table added successfully!";
        if ($_GET['msg'] == 'table_updated') echo "✏️ Table updated successfully!";
        if ($_GET['msg'] == 'table_deleted') echo "🗑️ Table deleted successfully!";
        ?>
    </div>
<?php endif; ?>


<div class="container py-5">
    <h2 class="text-center mb-4 text-pink">Admin Dashboard 🍴</h2>

    <!-- Card Summary -->
    <div class="row text-white mb-4">
        <div class="col-md-3">
            <div class="card shadow rounded p-3" style="background-color: #A7D3F2;">
                <h5>Total Queue</h5>
                <h2><?= $totalQueue ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow rounded p-3" style="background-color: #C4F1C5;">
                <h5>Tables Ready</h5>
                <h2><?= $tablesAvailable ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow rounded p-3" style="background-color: #FEC6C6;">
                <h5>Tables in Use</h5>
                <h2><?= $totalTables - $tablesAvailable ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow rounded p-3" style="background-color: #FFF4C2;">
                <h5>Reservations Today</h5>
                <h2><?= $reservationToday ?></h2>
            </div>
        </div>
    </div>

    <!-- Section Queue -->
    <div class="bg-white p-4 rounded shadow-sm mb-4">
        <h4 class="mb-3 text-pink">🧍 Queue List</h4>
        <table class="table table-bordered">
            <thead class="table-pink text-white">
                <tr>
                    <th>No</th>
                    <th>Queue Number</th>
                    <th>User</th>
                    <th>Party Size</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $queue = mysqli_query($conn, "SELECT q.*, u.username FROM queue q 
                                            JOIN users u ON q.user_id = u.id 
                                            WHERE q.status != 'done' 
                                            ORDER BY q.created_at ASC");
                $no = 1;
                while ($row = mysqli_fetch_assoc($queue)):
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>#<?= str_pad($row['queue_number'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['party_size'] ?> person<?= $row['party_size'] > 1 ? 's' : '' ?></td>
                        <td><?= ucfirst($row['status']) ?></td>
                        <td>
                            <?php if ($row['status'] == 'waiting'): ?>
                                <a href="call_queue.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Call</a>
                            <?php elseif ($row['status'] == 'called'): ?>
                                <a href="assign_table.php?queue_id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Assign Table</a>
                            <?php else: ?>
                                <!-- Tidak ada action untuk status seated -->
                                <span class="text-muted">No action</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>


    <!-- Add Table Button -->
    <div class="mb-3 text-end">
        <a href="add_table.php" class="btn btn-pink" style="background-color: #ff69b4; color: white;">
            ➕ Add Table
        </a>
    </div>

    <!-- Hidden Add Table Form -->
    <div id="addTableForm" style="display:none;" class="p-3 rounded shadow-sm">
        <form action="add_table.php" method="POST" class="text-start">
            <div class="mb-2">
                <label>Table Number</label>
                <input type="text" name="table_number" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Capacity</label>
                <input type="number" name="capacity" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="reserved">Reserved</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Save Table</button>
        </form>
    </div>

    <!-- Section Tables -->
    <div class="bg-white p-4 rounded shadow-sm mb-4">
        <h4 class="mb-3 text-pink">🪑 Table Status</h4>
        <table class="table table-bordered">
            <thead class="table-pink text-white">
                <tr>
                    <th>Table</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tables = mysqli_query($conn, "SELECT * FROM tables ORDER BY table_number ASC");
                while ($row = mysqli_fetch_assoc($tables)):
                ?>
                    <tr>
                        <td><?= $row['table_number'] ?></td>
                        <td><?= $row['capacity'] ?> people</td>
                        <td><?= $row['is_available'] ? 'Available' : 'Occupied' ?></td>
                        <td>
                            <?php if (!$row['is_available']): ?>
                                <a href="free_table.php?table_id=<?= $row['id'] ?>" class="btn btn-sm btn-danger mb-1">Free Table</a>
                            <?php else: ?>
                                <span class="text-muted d-block mb-1">Ready</span>
                            <?php endif; ?>
                            <a href="#" class="btn btn-sm btn-outline-danger ms-1" onclick="confirmDelete(<?= $row['id'] ?>, '<?= $row['table_number'] ?>')">Delete</a>
                            <a href="edit_table.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <br>
    <br>

    
    <!-- Section Reservations -->
    <div class="bg-white p-4 rounded shadow mb-4">
        <h4 class="mb-3 text-pink"><i class="bi bi-calendar-event-fill"></i> Reservations</h4>
        <table class="table table-bordered align-middle text-center">
            <thead class="table-pink text-white">
                <tr>
                    <th>📅 Date</th>
                    <th>⏰ Time</th>
                    <th>👤 User</th>
                    <th>👥 People</th>
                    <th>📌 Status</th>
                    <th>🔧 Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $reservations = mysqli_query($conn, "
                SELECT * FROM reservations
                WHERE reservation_time >= NOW()
                ORDER BY reservation_time ASC
            ");
                while ($r = mysqli_fetch_assoc($reservations)):
                ?>
                    <tr class="<?= $r['status'] == 'pending' ? 'table-warning' : ($r['status'] == 'seated' ? 'table-success' : 'table-light') ?>">
                        <td><?= date("d M Y", strtotime($r['reservation_time'])) ?></td>
                        <td><strong><?= date("H:i", strtotime($r['reservation_time'])) ?></strong></td>
                        <td><?= htmlspecialchars($r['name']) ?><br><small class="text-muted"><?= $r['phone'] ?></small></td>
                        <td><?= $r['party_size'] ?> people</td>
                        <td><span class="badge
        <?= $r['status'] == 'pending' ? 'bg-warning' : ($r['status'] == 'seated' ? 'bg-success' : 'bg-secondary') ?>">
                                <?= ucfirst($r['status']) ?></span></td>
                        <td>
                            <?php if ($r['status'] == 'pending'): ?>
                                <a href="seat_reservation.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-success">Seat Now</a>
                                <a href="edit_reservation.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_reservation.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this reservation?');">Delete</a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>


    <?php include 'footer.php'; ?>
    <?php if (isset($_GET['msg'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php if ($_GET['msg'] == 'table_added'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Table Added!',
                        text: 'New table added successfully 🍽️',
                        confirmButtonColor: '#ff69b4'
                    });
                <?php elseif ($_GET['msg'] == 'table_updated'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Table Updated!',
                        text: 'Table information updated successfully ✏️',
                        confirmButtonColor: '#ff69b4'
                    });
                <?php elseif ($_GET['msg'] == 'table_deleted'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Table Deleted!',
                        text: 'Table successfully deleted 🗑️',
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
                text: `Do you really wanna remove table #${tableNumber}? Once gone, it's gone for good 💔`,
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

    <?php if (isset($_GET['user'])): ?>
        <div class="alert alert-<?= $_GET['user'] === 'full' ? 'danger' : 'success' ?>">
            <?= $_GET['user'] === 'assigned' ?
                "Table has been assigned to <strong>{$_GET['user']}</strong> 💺" :
                "" ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'assigned' && isset($_GET['user'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Table has been successfully assigned to <strong><?= htmlspecialchars($_GET['user']) ?></strong> 💺🎉
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'full'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            No available tables found for this reservation 😢
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>


    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success text-center">
            <?php
            if ($_GET['msg'] == 'reservation_deleted') echo "Reservation has been successfully deleted. 🗑️";
            if ($_GET['msg'] == 'reservation_updated') echo "Reservation has been updated successfully. ✏️";
            ?>
        </div>
    <?php endif; ?>