<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM expenses WHERE id = ? AND user_id = ?");
if ($stmt->execute([$id, $_SESSION['user_id']])) {
    header("Location: dashboard.php");
} else {
    echo "Error deleting expense.";
}
?>
