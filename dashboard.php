<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM expenses WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$expenses = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Expense Dashboard</h2>
    <a href="add_expense.php">Add New Expense</a>
    <a href="logout.php">Logout</a>
    
    <table>
        <tr>
            <th>Amount</th>
            <th>Category</th>
            <th>Description</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($expenses as $expense): ?>
        <tr>
            <td><?php echo htmlspecialchars($expense['amount']); ?></td>
            <td><?php echo htmlspecialchars($expense['category']); ?></td>
            <td><?php echo htmlspecialchars($expense['description']); ?></td>
            <td><?php echo htmlspecialchars($expense['date']); ?></td>
            <td>
                <a href="edit_expense.php?id=<?php echo $expense['id']; ?>">Edit</a>
                <a href="delete_expense.php?id=<?php echo $expense['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
