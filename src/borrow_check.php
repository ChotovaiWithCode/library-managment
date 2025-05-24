<?php
session_start();

// Include your database connection file
include 'database.php';

// Check if form values exist
if (isset($_POST['email']) && isset($_POST['member_id'])) {
    // Trim and sanitize input
    $member_email = trim(strtolower($_POST['email']));
    $member_id = trim($_POST['member_id']);

    // Prepare SQL query (case-insensitive email match)
    $stmt = $conn->prepare("SELECT * FROM member_info WHERE LOWER(email) = ? AND member_id = ?");
    $stmt->bind_param("ss", $member_email, $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if member exists
    if ($result->num_rows > 0) {
        // Optional: store member in session
        $_SESSION['member_email'] = $member_email;

        // Redirect to add_to_cart page
        header("Location:bookscollection.php");
        exit();
    } else {
        echo "<script>alert('Invalid Email or Member ID'); window.history.back();</script>";
        exit();
    }
} else {
    echo "<script>alert('Please fill in all fields'); window.history.back();</script>";
    exit();
}
?>
