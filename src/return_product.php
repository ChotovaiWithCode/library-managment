<?php
session_start();
include('database.php');

// Get and sanitize input
$email = mysqli_real_escape_string($conn, $_POST['email']);
$borrow_id = mysqli_real_escape_string($conn, $_POST['borrow_id']);
$books_name = mysqli_real_escape_string($conn, $_POST['books_name']);
$quantity = (int) $_POST['quantity'];
$rating = (int) $_POST['rating'];

// Step 1: Check in admin table for a valid match
$checkAdmin = mysqli_query($conn, "
    SELECT * FROM admin 
    WHERE TRIM(email) = TRIM('$email') 
    AND TRIM(books_name) = TRIM('$books_name') 
    AND borrow_id = '$borrow_id'
");

if (mysqli_num_rows($checkAdmin) > 0) {
    $data = mysqli_fetch_assoc($checkAdmin);
    $image = $data['image'];
    $description = $data['description'];

    // Step 2: Return to products table
    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE books_name = '$books_name'");

    if (mysqli_num_rows($checkProduct) > 0) {
        // Update quantity and update rating
        mysqli_query($conn, "
            UPDATE products 
            SET quantity = quantity + $quantity, rating = $rating 
            WHERE books_name = '$books_name'
        ");
    } else {
        // Insert new product
        mysqli_query($conn, "
            INSERT INTO products (image, books_name, description, quantity, rating)
            VALUES ('$image', '$books_name', '$description', $quantity, $rating)
        ");
    }

    // Step 3: Delete the record from admin table
    mysqli_query($conn, "
        DELETE FROM admin 
        WHERE books_name = '$books_name' 
        AND borrow_id = '$borrow_id' 
        AND email = '$email'
    ");

    include('successReturn.php');
    exit;
} else {
    echo "<script>alert('❌ No matching record found in admin table.');
          window.location.href = 'librarypage.php';</script>";
}

mysqli_close($conn);
?>
