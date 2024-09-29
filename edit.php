<?php
session_start();
include('db.php'); // Include database connection file

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if user is not logged in
    exit();
}

if (isset($_GET['id'])) {
    $expense_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    
    // Retrieve expense data
    $query = "SELECT * FROM expenses WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $expense_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $expense = $result->fetch_assoc();
    } else {
        echo "Expense not found!";
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Edit Expense</h2>
    <form action="update_expense.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $expense['id']; ?>">
        <label for="amount">Amount:</label>
        <input type="text" name="amount" value="<?php echo $expense['amount']; ?>" required>

        <label for="category">Category:</label>
        <input type="text" name="category" value="<?php echo $expense['category']; ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" required><?php echo $expense['description']; ?></textarea>

        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo $expense['date']; ?>" required>

        <button type="submit">Update Expense</button>
    </form>
</body>
</html>
