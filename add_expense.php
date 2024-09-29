<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    $stmt = $pdo->prepare("INSERT INTO expenses (user_id, amount, category, description, date) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $amount, $category, $description, $date]);
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Expense</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Add New Expense</h2>
    <form method="post">
        <input type="number" name="amount" placeholder="Amount" required>
        <input type="text" name="category" placeholder="Category" required>
        <input type="text" name="description" placeholder="Description" required>
        <input type="date" name="date" required>
        <button type="submit">Add Expense</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
