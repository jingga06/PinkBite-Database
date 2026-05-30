<?php
include 'config.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM queue WHERE id = $id");
header("Location: queue.php");
