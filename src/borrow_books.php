<?php
session_start();
require 'database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])) {

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $book) {
            $bookId = $book['books_id'];

            
            $stmt = $conn->prepare("SELECT available_quantity FROM bookscollection WHERE books_id = ?");
            $stmt->bind_param("s", $bookId);
            $stmt->execute();
            $result = $stmt->get_result();
            $bookRow = $result->fetch_assoc();

            if ($bookRow) {
                $available = (int)$bookRow['available_quantity'];

                if ($available > 0) {
                    
                    $newQty = $available - 1;
                    $updateStmt = $conn->prepare("UPDATE bookscollection SET available_quantity = ? WHERE books_id = ?");
                    $updateStmt->bind_param("is", $newQty, $bookId);
                    $updateStmt->execute();
                    $updateStmt->close();

                   
                  $insertStmt = $conn->prepare("INSERT INTO user_store (id, books_id, title, author, rating, total_quantity, available_quantity, image_url, category, created_at, date_added, borrow_count, overdue_count) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, ?)");

                $insertStmt->bind_param(
                    "sssssiissii", 
                    $_SESSION['user_id'],               
                    $book['books_id'],                  
                    $book['title'],                     
                    $book['author'],                    
                    $book['rating'],                     
                    $book['total_quantity'],           
                    $newQty,                          
                    $book['image_url'],                 
                    $book['category'],                 
                    $book['borrow_count'],               
                    $book['overdue_count']               
                );

                    $insertStmt->execute();
                    $insertStmt->close();

                    
                    if ($newQty === 0) {
                        $deleteStmt = $conn->prepare("DELETE FROM bookscollection WHERE books_id = ?");
                        $deleteStmt->bind_param("s", $bookId);
                        $deleteStmt->execute();
                        $deleteStmt->close();
                    }

                } else {
                  
                    echo "<p>Book with ID $bookId is not available anymore.</p>";
                }
            }
        }

        
        unset($_SESSION['cart']);
        header("Location: success_popup.php"); 
        exit();
    }
} elseif (isset($_POST['cancel'])) {
    unset($_SESSION['cart']);
    header("Location: cancel.php"); 
    exit();
}
?>
