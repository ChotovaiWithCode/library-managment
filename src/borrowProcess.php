<?php
session_start();
include('database.php');

// Step 1: Get POST data
$name = $_POST['name'];
$email = $_POST['email'];
$quantityToBorrow = (int) $_POST['quantity'];
$return_date = $_POST['return_date'];
$borrow_date = date("Y-m-d");
$borrow_id = 'BRW-' . strtoupper(substr(md5(uniqid()), 0, 8)); // Generate unique borrow ID

// Step 2: Get product info
$getProduct = "SELECT * FROM products WHERE name = '$name'";
$productResult = $conn->query($getProduct);

if ($productResult->num_rows > 0) {
    $product = $productResult->fetch_assoc();
    $currentQty = (int) $product['quantity'];
    $productID = $product['Products_ID'];
    $image = $product['image'];
    $description = $product['description'];

    if ($currentQty >= $quantityToBorrow) {
        $newQty = $currentQty - $quantityToBorrow;
        $conn->query("UPDATE products SET quantity = $newQty WHERE Products_ID = $productID");

        if ($newQty < 1) {
            $conn->query("DELETE FROM products WHERE Products_ID = $productID");

            // // Insert into admin table with borrow ID
            // $conn->query("INSERT INTO admin (image, name, description, quantity, borrow_date, return_date, email, borrow_id)
            //               VALUES ('$image', '$name', '$description', $quantityToBorrow, '$borrow_date', '$return_date', '$email', '$borrow_id')");

            // Insert into transactions
        //     $conn->query("INSERT INTO transactions (image, product_name, description, quantity, borrow_date, return_date, email, borrow_id)
        //                   VALUES ('$image', '$name', '$description', $quantityToBorrow, '$borrow_date', '$return_date', '$email', '$borrow_id')");

        //     // Now show success popup
        //     $conn->close();
        //     include('success_popup.php'); // Create this file
        //     exit;
        }

         // Insert into admin table with borrow ID
         $conn->query("INSERT INTO admin (image, name, description, quantity, borrow_date, return_date, email, borrow_id)
         VALUES ('$image', '$name', '$description', $quantityToBorrow, '$borrow_date', '$return_date', '$email', '$borrow_id')");

        // Partial borrow success (quantity left > 0)
        $conn->query("INSERT INTO transactions (image, product_name, description, quantity, borrow_date, return_date, email, borrow_id)
                      VALUES ('$image', '$name', '$description', $quantityToBorrow, '$borrow_date', '$return_date', '$email', '$borrow_id')");
        $conn->close();
        include('success_popup.php'); // Still show popup
        exit;
    } else {
        echo "❌ Not enough quantity available.";
    }
} else {
    echo "❌ Product not found.";
}
?>
