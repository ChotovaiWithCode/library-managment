<?php
session_start();
include('database.php');

// Step 1: Get POST data
$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$product_name = $_POST['books_name'];
$quantity = (int) $_POST['quantity'];
$return_date = $_POST['return_date'];
$borrow_date = date("Y-m-d");
$borrow_id = 'BRW-' . strtoupper(substr(md5(uniqid()), 0, 8));

// Step 2: Fetch product info
$getProduct = "SELECT * FROM products WHERE books_name = '$product_name'";
$productResult = mysqli_query($conn, $getProduct);

if (mysqli_num_rows($productResult) > 0) {
    $product = mysqli_fetch_assoc($productResult);

    $available_qty = (int)$product['quantity'];
    $product_id = $product['Products_ID'];
    $image = $product['image'];
    $description = $product['description'];

    if ($available_qty >= $quantity) {
        $new_qty = $available_qty - $quantity;

        // Update quantity or delete if none left
        if ($new_qty > 0) {
            mysqli_query($conn, "UPDATE products SET quantity = $new_qty WHERE Products_ID = $product_id");
        } else {
            mysqli_query($conn, "DELETE FROM products WHERE Products_ID = $product_id");
        }

        // Insert into admin table
        $insertAdmin = "INSERT INTO admin (image, full_name, description, quantity, books_name, borrow_date, return_date, phone, email, borrow_id)
                        VALUES ('$image', '$full_name', '$description', $quantity, '$product_name', '$borrow_date', '$return_date', '$phone', '$email', '$borrow_id')";
        mysqli_query($conn, $insertAdmin);

        // Insert into transactions table
        $insertTrans = "INSERT INTO transactions (image, full_name, description, quantity, books_name, borrow_date, return_date, phone, email, borrow_id)
                        VALUES ('$image', '$full_name', '$description', $quantity, '$product_name', '$borrow_date', '$return_date', '$phone', '$email', '$borrow_id')";
        mysqli_query($conn, $insertTrans);

        mysqli_close($conn);
        include('success_popup.php');
        exit;

    } else {
        echo "❌ Not enough quantity available.";
    }

} else {
    echo "❌ Product not found.";
}
?>
