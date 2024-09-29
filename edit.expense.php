<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM expenses WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$expense = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    $stmt = $pdo->prepare("UPDATE expenses SET amount = ?, category = ?, description = ?, date = ? WHERE id = ?");
    $stmt->execute([$amount, $category, $description, $date, $id]);
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Expense</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Edit Expense</h2>
    <form method="post">
        <input type="number" name="amount" value="<?php echo htmlspecialchars($expense['amount']); ?>" required>
        <input type="text" name="category" value="<?php echo htmlspecialchars($expense['category']); ?>" required>
        <input type="text" name="description" value="<?php echo htmlspecialchars($expense['description']); ?>" required>
        <input type="date" name="date" value="<?php echo htmlspecialchars($expense['date']); ?>" required>
        <button type="submit">Update Expense</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
