<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'bismillah';
$port = 3307;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
