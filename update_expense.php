<?php
session_start();
include('db.php'); // Include database connection file

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if user is not logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $expense_id = $_POST['id'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $user_id = $_SESSION['user_id'];

    // Update expense data
    $query = "UPDATE expenses SET amount = ?, category = ?, description = ?, date = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $amount, $category, $description, $date, $expense_id, $user_id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php?message=Expense updated successfully!");
    } else {
        echo "Error updating expense: " . $stmt->error;
    }
}
?>
