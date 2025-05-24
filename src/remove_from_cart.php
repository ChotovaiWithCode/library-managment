<?php
session_start();

if (isset($_POST['books_id'])) {
    $book_id = $_POST['books_id'];
    foreach ($_SESSION['cart'] as $index => $book) {
        if ($book['books_id'] == $book_id) {
            unset($_SESSION['cart'][$index]);
            break;
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex
}

header("Location: borrow list.php");
exit();
?>
