<?php
// delete.php
require_once 'db.php';

if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $id = trim($_GET['id']);
    
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            header("Location: index.php?msg=User deleted successfully");
        } else {
            header("Location: index.php?msg=Error deleting user");
        }
        exit();
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    // If ID is not set, redirect to index
    header("Location: index.php");
    exit();
}
?>
