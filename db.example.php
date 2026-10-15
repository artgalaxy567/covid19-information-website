
<?php
// Sample database configuration for the project.
// Update these values for your local XAMPP setup.

$host = "localhost";
$username = "root";
$password = "";
$database = "covid19_db";

$conn = new mysqli(
    $host,
    $username,
    $password,
    $database
);

if ($conn->connect_error) {
    die("Database connection failed.");
}

$conn->set_charset("utf8mb4");
?>
