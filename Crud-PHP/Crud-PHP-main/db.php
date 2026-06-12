<?php
// db.php
$host = 'localhost';
$dbname = 'crud_app';
$username = 'root'; // default XAMPP username
$password = ''; // default XAMPP password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // Uncomment for testing
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
