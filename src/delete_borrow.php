<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    include 'database.php'; // or your database connection file

    $stmt = $conn->prepare("DELETE FROM borrow_history WHERE book_id = ?");
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        header("Location: my_dashboard.php?deleted=1");
        exit;
    } else {
        echo "Error deleting record.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>

 <!-- // referencebooks delete -->
<?php
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
       $id = $_POST['id'];

     // Connect to DB
  include 'database.php';  // adjust to your file
 $stmt = $conn->prepare("DELETE FROM reference_books WHERE books_id = ?");
$stmt->bind_param("s", $id);
if ($stmt->execute()) {
    header("Location: welcome.php?deleted=1"); // Redirect after deletion
 } else {
     echo "Error deleting record.";
 }

$stmt->close();
$conn->close();
}
 ?>