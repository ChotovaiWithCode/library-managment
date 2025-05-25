<?php
session_start();
include 'database.php'; // your DB connection

if (isset($_POST['email']) && isset($_POST['books_id'])) {
    $email = $_POST['email'];
    $books_id = $_POST['books_id'];

    // Check if email exists in admin_info
    $query = "SELECT * FROM member_info WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If member, redirect to add_to_cart.php with book ID
        header("Location: add_to_cart.php?books_id=" . urlencode($books_id));
        exit();
    } else {
        // Not a member
        echo "<script>alert('You have not membership.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>
