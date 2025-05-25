<?php
session_start();
include 'database.php'; 

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['books_id'])) {
    $book_id = $_GET['books_id'];

    $query = "SELECT * FROM bookscollection WHERE books_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();

    if ($book) {
        $_SESSION['cart'][] = $book;
    }

    header("Location: borrow list.php");
    exit();
} else {
    echo "<script>alert('Book ID is missing.'); window.history.back();</script>";
}
?>
