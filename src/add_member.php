<?php
session_start();
include 'database.php';

$email = $_SESSION['email'] ?? '';
if (!$email) {
    echo "<script>alert('Session expired. Please login again.'); window.location.href = 'login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if email already exists in `member_info`
    $stmt = $conn->prepare("SELECT * FROM member_info WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('This email is already registered.'); window.history.back();</script>";
        exit;
    }

    // Gather inputs
    $name = $_POST['name'] ?? '';
    $place = $_POST['place'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $quantity = $_POST['quantity'] ?? 0;
    $price = $_POST['price'] ?? 0;
    $remark = $_POST['remark'] ?? '';

    // File upload
    $uploadPath = '';
    if ($_FILES['upload_file']['error'] === 0) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        $fileName = basename($_FILES['upload_file']['name']);
        $uploadPath = $uploadDir . time() . '_' . $fileName;
        move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadPath);
    }

    try {
        $member_id = "MEM" . date("Ymd") . rand(1000, 9999);
        $stmt = $conn->prepare("INSERT INTO member_info (member_id, name, place, phone, address, email, quantity, price, remark, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssisss", $member_id, $name, $place, $phone, $address, $email, $quantity, $price, $remark, $uploadPath);
        $stmt->execute();

        echo "<script>alert('Member added successfully.'); window.location.href = 'bookscollection.php';</script>";
        exit;
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('An error occurred: " . $e->getMessage() . "'); window.location.href = 'members.php';</script>";
    }
}
?>
