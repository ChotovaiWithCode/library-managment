<?php
session_start();
require 'database.php'; // include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])) {

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $book) {
            $bookId = $book['books_id'];

            // 1. Fetch current available_quantity
            $stmt = $conn->prepare("SELECT available_quantity FROM bookscollection WHERE books_id = ?");
            $stmt->bind_param("s", $bookId);
            $stmt->execute();
            $result = $stmt->get_result();
            $bookRow = $result->fetch_assoc();

            if ($bookRow) {
                $available = (int)$bookRow['available_quantity'];

                if ($available > 0) {
                    // 2. Decrease available_quantity
                    $newQty = $available - 1;
                    $updateStmt = $conn->prepare("UPDATE bookscollection SET available_quantity = ? WHERE books_id = ?");
                    $updateStmt->bind_param("is", $newQty, $bookId);
                    $updateStmt->execute();
                    $updateStmt->close();

                    // 4. Insert into user_store
                  $insertStmt = $conn->prepare("INSERT INTO user_store (id, books_id, title, author, rating, total_quantity, available_quantity, image_url, category, created_at, date_added, borrow_count, overdue_count) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, ?)");

                $insertStmt->bind_param(
                    "sssssiissii", // Now 11 type specifiers: 3 strings, 3 integers, 2 strings, 1 string, 2 integers
                    $_SESSION['user_id'],                // s
                    $book['books_id'],                   // s
                    $book['title'],                      // s
                    $book['author'],                     // s
                    $book['rating'],                     // i
                    $book['total_quantity'],            // i
                    $newQty,                             // i
                    $book['image_url'],                  // s
                    $book['category'],                   // s
                    $book['borrow_count'],               // i
                    $book['overdue_count']               // i
                );

                    $insertStmt->execute();
                    $insertStmt->close();

                    // 3. Optionally delete if now zero
                    if ($newQty === 0) {
                        $deleteStmt = $conn->prepare("DELETE FROM bookscollection WHERE books_id = ?");
                        $deleteStmt->bind_param("s", $bookId);
                        $deleteStmt->execute();
                        $deleteStmt->close();
                    }

                } else {
                    // Optional: Add error for unavailable book
                    echo "<p>Book with ID $bookId is not available anymore.</p>";
                }
            }
        }

        // Clear the cart after borrowing
        unset($_SESSION['cart']);
        header("Location: success_popup.php"); // redirect to success page
        exit();
    }
} elseif (isset($_POST['cancel'])) {
    unset($_SESSION['cart']);
    header("Location: cancel.php"); // redirect to cancel page
    exit();
}
?>
