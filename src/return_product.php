<?php
session_start();
include('database.php');

// Step 1: Get form data safely
$name = mysqli_real_escape_string($conn, $_POST['name']);
$borrow_id = mysqli_real_escape_string($conn, $_POST['borrow_id']);
$rating = (int) $_POST['rating'];

// Step 2: Check for match in both transactions and admin tables
$checkTrans = "SELECT * FROM transactions WHERE product_name = '$name' AND borrow_id = '$borrow_id'";
$checkAdmin = "SELECT * FROM admin WHERE name = '$name' AND borrow_id = '$borrow_id'";

$transResult = $conn->query($checkTrans);
$adminResult = $conn->query($checkAdmin);

if ($transResult->num_rows > 0 && $adminResult->num_rows > 0) {
    // Get data
    $data = $transResult->fetch_assoc();
    $product_name = $data['product_name'];
    $image = $data['image'];
    $description = $data['description'];
    $quantity = $data['quantity'];

    // Step 3: Add back to products table
    $checkProduct = $conn->query("SELECT * FROM products WHERE name = '$product_name'");

    if ($checkProduct->num_rows > 0) {
        $conn->query("UPDATE products SET quantity = quantity + $quantity WHERE name = '$product_name'");
    } else {
        $conn->query("INSERT INTO products (image, name, description, quantity) 
                      VALUES ('$image', '$product_name', '$description', $quantity)");
    }

    // Step 4: Delete from both admin and transactions
    $conn->query("DELETE FROM admin WHERE name = '$name' AND borrow_id = '$borrow_id'");
    $conn->query("DELETE FROM transactions WHERE product_name = '$name' AND borrow_id = '$borrow_id'");

    // Step 5: Thank user
    echo "<script>alert('✅ Product returned successfully! Thank you for rating $rating stars.');
          window.location.href = 'librarypage.php';</script>";
} else {
    echo "<script>alert('❌ Invalid name or borrow ID. Please try again.');
          window.location.href = 'librarypage.php';</script>";
}

$conn->close();
?>
