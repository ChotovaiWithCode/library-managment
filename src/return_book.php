<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['books_id'], $_POST['rating']) &&
    isset($_SESSION['email'])) {

    $books_id = (int)$_POST['books_id'];
    $rating = (int)$_POST['rating'];
    $email = $_SESSION['email'];

    // Increase available_quantity
    $stmt1 = $conn->prepare("UPDATE bookscollection SET available_quantity = available_quantity + 1 WHERE books_id = ?");
    $stmt1->bind_param("i", $books_id);
    $stmt1->execute();
    $stmt1->close();

    // Remove from user_store
    $user_id = $_SESSION['user_id'];

    $stmt2 = $conn->prepare("DELETE FROM user_store WHERE books_id = ? AND email = ? LIMIT 1");
    $stmt2->bind_param("is", $books_id, $email);
    $stmt2->execute();
    $stmt2->close();

    // Update rating
    $stmt3 = $conn->prepare("UPDATE bookscollection 
                             SET rating_total = rating_total + ?, 
                                 rating_count = rating_count + 1 
                             WHERE books_id = ?");
    $stmt3->bind_param("ii", $rating, $books_id);
    $stmt3->execute();
    $stmt3->close();

    echo "<script>alert('Thanks for your rating! Book returned successfully.'); window.location.href='bookscollection.php';</script>";
    exit();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>
