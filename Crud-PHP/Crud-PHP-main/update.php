<?php
// update.php
require_once 'db.php';

// Check if ID is provided in the URL
if (!isset($_GET['id']) || empty(trim($_GET['id']))) {
    header("Location: index.php");
    exit();
}

$id = trim($_GET['id']);
$name = $email = $phone = "";
$error = "";

// Fetch existing user data
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
    } else {
        header("Location: index.php");
        exit();
    }
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (!empty($name) && !empty($email) && !empty($phone)) {
        try {
            $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                header("Location: index.php?msg=User updated successfully");
                exit();
            } else {
                $error = "Something went wrong. Please try again.";
            }
        } catch(PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>
        
        <?php if(!empty($error)): ?>
            <div class="alert" style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required value="<?= htmlspecialchars($name) ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required value="<?= htmlspecialchars($email) ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" required value="<?= htmlspecialchars($phone) ?>">
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Update User</button>
                <a href="index.php" class="btn" style="background-color: #95a5a6;">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
